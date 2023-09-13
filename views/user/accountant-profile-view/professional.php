<?php

use app\widgets\ModelAttribute;
use app\helpers\App;
use app\helpers\Html;
?>

<section>
	<p class="lead font-weight-bolder mb-10">PROFESSIONAL INFORMATION</p>
	<div class="row">
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'years_of_experience',
			]) ?>
		</div>
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'current_employer',
			]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'job_title',
			]) ?>
		</div>
	</div>

	<?= App::if($model->file, 
		fn ($file) => Html::tag('p', 'WITH CERTIFICATION', [
			'class' => 'lead font-weight-bolder my-5'
		]) . Html::a('View Certification', $file->viewerUrl, [
			'class' => 'btn btn-primary font-weight-bold',
			'target' => '_blank'
		])
	) ?>
</section>