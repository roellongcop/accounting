<?php

use app\widgets\Dropzone;
use app\models\Theme;
?>

<div class="col-md-4">
	<div class="mb-2">
	    <?= Dropzone::widget([
	        'tag' => $tag ?? 'Document',
	        'model' => new Theme(),
	        'attribute' => 'photos',
	        'path' => $path,
	        'documentLibrary' => true,
			'complete' => <<< JS
				$( ".file-explorer-widget ul.breadcrumb li" ).last().click();
			JS
	    ]) ?>
	</div>
</div>
