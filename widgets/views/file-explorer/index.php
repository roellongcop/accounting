<?php

use app\helpers\App;

$this->registerCss(<<< CSS
    .file-explorer-widget .file-count {
        width: inherit;
        position: absolute;
        top: 0;
        font-weight: 600;
        display: block;
        cursor: pointer;
    }
    .file-explorer-widget .folder-container:hover,
    .file-explorer-widget .add-folder:hover {
        outline: 2px solid #1bc5bd;
        border-radius: 10px;
        cursor: pointer;
    }

    .file-explorer-widget .folder-container,
    .file-explorer-widget .add-folder {
        padding: 5px 15px;
        width: fit-content;
    }

    .file-explorer-widget .img-folder,
    .file-explorer-widget .img-create-folder {
        max-width: 100px !important;
    }
    .file-explorer-widget .folder-label {
        overflow-wrap: anywhere;
    }

    .file-explorer-widget ul.breadcrumb {
        padding: 10px 16px;
        list-style: none;
        background-color: #eee;
    }
    .file-explorer-widget ul.breadcrumb li {
        display: inline;
        font-size: 14px;
    }
    .file-explorer-widget ul.breadcrumb li+li:before {
        padding: 8px;
        color: black;
        content: "/";
    }
    .file-explorer-widget ul.breadcrumb li a {
        color: #0275d8;
        text-decoration: none;
    }
    .file-explorer-widget ul.breadcrumb li a:hover {
        color: #01447e;
        text-decoration: underline;
    }

    .file-explorer-widget .context-menu {
      display: none;
      position: fixed;
      z-index: 1000;
      width: 200px;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      overflow: hidden;
    }

    .file-explorer-widget .context-menu-item {
      padding: 10px;
      cursor: pointer;
    }

    .file-explorer-widget .context-menu-item:hover {
      background-color: #f1f1f1;
    }

    .file-explorer-widget .context-menu-target {
      width: 200px;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #ccc;
    }
CSS);

$isClient = App::identity('isClient') ? 'true': 'false';

$this->registerWidgetJs($widgetFunction, <<< JS
    let isClient = {$isClient};
    let rightClickEl;
    let rightClickPath = '';
    let loadDirectories = function(el='', path='') {
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'primary',
            message: 'Please wait'    
        })
        if(el) {
            path = el.data('path');
        }
       
        $.ajax({
            url: '{$reloadUrl}',
            data: {path, tag: '{$tag}'},
            method: 'post',
            dataType: 'json',
            success: function(s) {
                const url = new URL(location.href);
                url.searchParams.set('path', path);
                history.pushState(null, '', url);

                $('#{$widgetId} .document-and-breadcrumbs').html(s.html)
                $('[data-toggle="tooltip"]').tooltip();
                $('#table-file').DataTable({
                    destroy: true,
                    pageLength: 5,
                    order: [[0, 'desc']]
                });
                KTApp.unblockPage();
            },
            error: (e) => {
                KTApp.unblockPage();
                alert(e.statusText)
            }
        })
    }
    $(document).on('click', '#{$widgetId} .breadcrumb-link', function(e) {
        e.preventDefault();
        loadDirectories('', $(this).data('path'))
    });

    $(document).on('dblclick', '#{$widgetId} .folder-container', function() {
        loadDirectories($(this))
    });

    // Hide the context menu when clicking anywhere else on the page
    window.addEventListener('click', function() {
        document.getElementById('contextMenu').style.display = 'none';
    });

    // Add click event listeners to the context menu items if needed
    $(document).on('click', '#{$widgetId} .context-menu-item', function() {
        const action = $(this).data('action');

        if (action === 'delete') {
            var self = this;
            Swal.fire({
                title: "Are you sure?",
                text: "You won\"t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    KTApp.block('body', {
                        overlayColor: '#000000',
                        state: 'warning',
                        message: 'Please wait...'
                    });
                    $.ajax({
                        url: app.baseUrl + 'file/delete-folder',
                        data: {
                            path: rightClickPath,
                            tag: '{$tag}',
                        },
                        method: 'post',
                        dataType: 'json',
                        success: function(s) {
                            if(s.status == 'success') {
                                rightClickEl.closest('div.col-md-2').remove();
                            }
                            else {
                                Swal.fire('Error', s.errors, 'error');
                            }
                            KTApp.unblock('body');
                        },
                        error: function(e) {
                            Swal.fire('Error', e.responseText, 'error');
                            KTApp.unblock('body');
                        },
                    })
                }
            });
            return;
        }
    });

    $(document).on('contextmenu', '#{$widgetId} .folder-container', function(e) {
        e.preventDefault();

        if (isClient) return;

        const path =  $(this).data('path');

        rightClickPath = path;
        rightClickEl = $(this);

        // Get the context menu element
        var contextMenu = document.getElementById('contextMenu');

        // Position the context menu at the mouse position
        contextMenu.style.top = e.clientY + 'px';
        contextMenu.style.left = e.clientX + 'px';

        // Show the context menu
        contextMenu.style.display = 'block';
    });

    $(document).on('click', '#{$widgetId} .add-folder', function() {
        let path = $(this).data('path');
        $('#{$widgetId} #folder-path').val(path)

        $('#{$widgetId} #modal-add-folder').modal('show');
    });

    $('#{$widgetId} #btn-add-folder').click(function() {
        KTApp.block('#modal-add-folder .modal-body');
        const folderPath = $('#{$widgetId} #folder-path').val();
        const folderName = $('#{$widgetId} #folder-name').val();

        var _this = this;
        $.ajax({
            url: '{$addFolderUrl}',
            data: {
                folderPath,
                folderName,
                tag: '{$tag}',
            },
            method: 'post',
            dataType: 'json',
            success: (s) => {
                KTApp.unblock('#modal-add-folder .modal-body');
                $('#{$widgetId} #folder-path').val('');
                $('#{$widgetId} #folder-name').val('');
                $('#{$widgetId} #modal-add-folder').modal('hide');

                loadDirectories('', folderPath);
            },
            error: function(e) {
                KTApp.unblock('#modal-add-folder .modal-body');
                Swal.fire('Error', e.responseText, 'error');
            },
        });
    });
JS);

?>

<div id="<?= $widgetId ?>" class="file-explorer-widget">
    <div class="document-and-breadcrumbs">
        <?= $this->render('_document-and-breadcrumbs', [
            'breadcrumbs' => $breadcrumbs,
            'directories' => $directories,
            'files' => $files,
            'path' => $path,
            'reloadUrl' => $reloadUrl,
            'widgetId' => $widgetId,
            'folderImage' => $folderImage,
            'addFolderImage' => $addFolderImage,
            'tag' => $tag,
        ]) ?>
    </div>
            
    <div class="modal fade" id="modal-add-folder" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="" id="folder-path">
                    <input type="text" name="" id="folder-name" class="form-control form-control-lg" placeholder="Enter folder name">
                    <button class="btn btn-success font-weight-bolder btn-block mt-5" id="btn-add-folder">CREATE FOLDER</button>
                </div>
            </div>
        </div>
    </div>

    <div id="contextMenu" class="context-menu">
        <!-- <div class="context-menu-item" data-action="rename">
            <i class="fa fa-edit"></i> Rename
        </div> -->
        <div class="context-menu-item" data-action="delete">
            <i class="fa fa-trash"></i> Delete
        </div>
    </div> 
</div>

