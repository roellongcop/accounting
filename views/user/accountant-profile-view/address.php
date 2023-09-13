<?php

use app\widgets\ModelAttribute;
?>

<section>
	<p class="lead font-weight-bolder mb-10">ADDRESS INFORMATION</p>
	<div class="row">
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'address',
			]) ?>
		</div>
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'city',
			]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'state',
			]) ?>
		</div>
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'country',
			]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'postal_code',
			]) ?>
		</div>
	</div>
</section>