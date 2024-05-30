<?php

use app\helpers\App;

$this->registerCssFile(App::publishedUrl("/plugins/custom/fullcalendar/fullcalendar.bundle.css"), [
    'depends' => [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ]
]);
$this->registerJsFile(App::publishedUrl("/plugins/custom/fullcalendar/fullcalendar.bundle.js"), [
    'depends' => App::setting('theme')->appAssetClass
]);
$this->addCssFile('css/dashboard-due-dates');

$this->addJsFile('js/dashboard-due-dates');

if (!App::identity()->can('index', 'event')) return;
?>

<div class="card card-custom due-dates-card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Events</h3>
        </div>
        <div class="card-toolbar">
            <?= App::if(App::identity()->can('create', 'event'), <<< HTML
                <a href="#" class="btn btn-light-primary font-weight-bold" id="btn-add-event">
                <i class="ki ki-plus icon-md mr-2"></i>Add Event</a>
            HTML) ?>
		</div>
    </div>
    <div class="card-body">
        <div id="kt_calendar"></div>
    </div>
</div>

<div class="modal fade" id="modal-event" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="btn-save-event">Save Event</button>
            </div>
        </div>
    </div>
</div>