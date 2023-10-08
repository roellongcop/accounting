<?php

use yii\helpers\FileHelper;
use app\helpers\App;
use app\helpers\Html;
use app\widgets\DataTable;
?>

<div class="row">
    <?= Html::foreach($directories, function($folder, $folderName) use ($folderImage) {
        return $this->render('_folder', [
            'folder' => $folder,
            'folderName' => $folderName,
            'folderImage' => $folderImage,
        ]);
    }) ?>

    <?= App::if(App::identity()->can('add-folder', 'file'), $this->render('_create-folder', [
        'path' => $path,
        'addFolderImage' => $addFolderImage,
    ]))  ?>

    <?= App::if(!App::identity('isClient'), $this->render('_dropzone', [
        'path' => $path,
        'reloadUrl' => $reloadUrl,
        'widgetId' => $widgetId,
        'tag' => $tag,
    ])) ?>
</div>

<div class="mt-10"></div>

<?= DataTable::widget(['models' => $files, 'pageLength' => 5]) ?>
