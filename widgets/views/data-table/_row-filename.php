<?php

use app\helpers\App;
?>

<div class="d-flex">
    <div>
        <?= $model->show([
            'class' => 'img-fluid',
            'loading' => 'lazy',
            'width' => 100,
            'style' => 'border-radius: 4px;width: 40px; height: 40px'
        ], 100) ?>
    </div>
    <div>
        <div class="ml-4">
            <b id="file-<?= $model->id ?>"><?= $model->nameWithExtension ?></b> 
            <span class="badge badge-secondary py-1"><?= $model->fileSize ?></span>
            <br>
            <span class="app-hidden"><?= strtotime($model->created_at) ?></span>
            <?= App::formatter('asFulldate', $model->created_at) ?>
        </div>
    </div>
</div>