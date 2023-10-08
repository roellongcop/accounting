<?php

use app\helpers\Html;

$toolbar = $toolbar ?? '';
?>

<div class="card card-custom <?= ($stretch ?? false) ? 'card-stretch': '' ?> gutter-b <?= $class ?? '' ?>">
	<?= Html::if(($title = $title ?? '') != null, function() use($title, $toolbar) {
		return <<< HTML
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">{$title}</h3>
				</div>
				{$toolbar}
			</div>
		HTML;
	}) ?>

    <div class="card-body" style="<?= $bodyStyle ?? '' ?>">
		<?= $content ?> 
	</div>

	<div class="card-footer">
		<?= $footer ?? '' ?> 
 	</div>
</div>