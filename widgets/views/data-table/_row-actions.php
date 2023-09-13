<?php

use app\helpers\App;
use app\helpers\Html;
?>
<div class="btn-group" role="group" aria-label="File Actions">

    <?= Html::a('<i class="fa fa-download"></i>', $model->downloadUrl, [
        'class' => 'btn btn-outline-secondary btn-sm btn-icon',
        'data-toggle' => 'tooltip',
        'data-title' => 'Download'
    ]) ?>
    <?= Html::a('<i class="fa fa-eye"></i>', $model->viewerUrl, [
        'class' => 'btn btn-light-primary btn-sm btn-icon btn-view-file',
        'data-toggle' => 'tooltip',
        'data-title' => 'View',
        'target' => '_blank'
    ]) ?>

    <?= App::if (
        App::identity()->can('update', 'file'), 
        fn () => Html::button('<i class="fa fa-edit"></i>', [
            'data-token' => $model->token,
            'data-name' => $model->name,
            'data-toggle' => 'tooltip',
            'data-title' => 'Rename',
            'class' => 'btn btn-light-warning btn-sm btn-icon btn-edit-file',
        ])
    ) ?>

    <?= App::if (
        App::identity()->can('delete', 'file'), 
        fn () => Html::button('<i class="fa fa-trash"></i>', [
            'data-token' => $model->token,
            'data-delete-url' => $model->deleteUrl,
            'data-toggle' => 'tooltip',
            'data-title' => 'Delete',
            'class' => 'btn btn-light-danger btn-sm btn-icon btn-remove-file',
        ])
    ) ?>
</div>