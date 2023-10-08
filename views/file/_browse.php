<?php

use app\widgets\FileExplorer;
use app\helpers\App;
?>

<?= FileExplorer::widget([
    'tag' => $tag,
    'path' => $path,
    'breadcrumbs' => [['folderName' => $tag, 'folderPath' => '']],
    'reloadUrl' => ['bir-filling/files'],
    'addFolderUrl' => ['bir-filling/add-folder'],
    'template' => '_document-and-breadcrumbs',
]) ?>