<?php

use app\helpers\Html;
use app\helpers\App;
use app\models\User;
use app\widgets\FileExplorer;

$show = true;
if ($folderName == $folder['path']) {
	if (App::identity('isAdmin') && User::findOne(['email' => $folderName, 'accountant_id' => App::identity('id')]) === null) {
		$show = false;
	}
}
$folderImage = FileExplorer::FOLDER_MAP[$folderName] ?? $folderImage;
?>

<?php if ($show): ?>
	<div class="col-md-2">
		<div class="folder-container mb-2" data-path="<?= $folder['path'] ?>" data-toggle="tooltip" title="Double click to open" data-placement="top">
		    <img src="<?= $folderImage ?>" class="img-fluid img-create-folder">
		    <div class="font-weight-bold folder-label"><?= $folderName ?></div>

		    <?= Html::ifElse($folder['total_documents'] == 0, 
		    	function() {
			    	return Html::tag('label', 0, [
			    		'class' => 'file-count badge badge-danger'
			    	]);
			    },
		    	function() use($folder) {
		    		return Html::tag('label', number_format($folder['total_documents']), [
			    		'class' => 'file-count badge badge-success'
			    	]);
			    },
			) ?>
		</div>
	</div>
<?php endif ?>
