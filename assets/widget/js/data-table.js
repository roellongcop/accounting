class DataTableWidget {

    constructor({widgetId, pageLength}) {
        this.widgetId = widgetId;
        this.pageLength = pageLength;
    }

    removeFile(el) {
        let self = this;
        const token = $(el).data('token');
        const tableId = $(el).closest('table').attr('id');
        const tr = $(el).closest('tr');

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
                    url: `${app.baseUrl}file/delete?token=${token}`,
                    method: 'post',
                    dataType: 'json',
                    success: function(s) {
                        if(s.status == 'success') {
                            $(`#${tableId}`).DataTable({
                                destroy: true,
                                pageLength: self.pageLength,
                                order: [[0, 'desc']]
                            })
                            .row(tr)
                            .remove()
                            .draw();

                            $(document).find(`.file-hidden-input-${token}`).remove();
                            Swal.fire({
                                icon: "success",
                                title: "Deleted",
                                text: "Your file has been deleted.",
                                showConfirmButton: false,
                                timer: 1500
                            });
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
    }


    editFile(el) {
        const self = this;
        const token = $(el).data('token');

        KTApp.block(`#${this.widgetId} .files-container`, {
            state: 'warning', // a bootstrap color
            message: 'Please wait...',
        });

        $.ajax({
            url: `${app.baseUrl}file/view`,
            method: 'get',
            data: {token, template: '_form-ajax'},
            dataType: 'json',
            success: function(s) {
                if(s.status == 'success') {
                    $(`#modal-edit-document-${self.widgetId} .modal-body`).html(s.form);
                    $(`#modal-edit-document-${self.widgetId}`).modal('show');
                }
                else {
                    Swal.fire('Error', s.error, 'error');
                }
                KTApp.unblock(`#${self.widgetId} .files-container`);
            },
            error: function(e) {
                Swal.fire('Error', e.responseText, 'error');
                KTApp.unblock(`#${self.widgetId} .files-container`);
            }
        });
    }

    init() {
        const self = this;
        
        $(`#${self.widgetId}`).DataTable({
            pageLength: self.pageLength,
            order: [[0, 'desc']]
        });

        $(document).on('click', `#${self.widgetId} .btn-remove-file`, function() {
            self.removeFile(this);
        });


        $(document).on('click', `#${self.widgetId} .btn-edit-file`, function() {
            self.editFile(this);
        });
    }
}

