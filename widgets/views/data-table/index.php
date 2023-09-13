<?php

use app\helpers\App;
use app\helpers\Html;

$this->registerJsFile(App::publishedUrl("/plugins/custom/datatables/datatables.bundle.js"), [
    'depends' => App::setting('theme')->appAssetClass
]);
$this->registerWidgetCssFile('data-table');
$this->registerWidgetJsFile('data-table');

$this->registerJs(<<< JS
    new DataTableWidget({
        widgetId: '{$tableId}',
        pageLength: {$pageLength},
    }).init();
JS);
?>

<div class="app-data-table">
    
    <table class="table table-bordered table-head-solid" id="<?= $tableId ?>">
        <thead>
            <tr>
                <th class="th-file">File</th>
                <?= Html::if($withAction, Html::tag('th', 'action', [
                    'width' => 100, 
                    'class' => 'text-center'
                ])) ?>
            </tr>
        </thead>
        <tbody class="files-container">
            <?= App::foreach($models, fn ($model) => $this->render('_row', [
                'model' => $model,
                'withAction' => $withAction,
            ])) ?>
        </tbody>
    </table>

    <div class="modal fade" id="modal-edit-document-<?= $tableId ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-document">Rename File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
