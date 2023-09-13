<?php

use app\helpers\Html;
use app\widgets\ModelAttribute;
?>

<section>
	<p class="lead font-weight-bolder mb-10">PERSONAL INFORMATION</p>
	<div class="row">
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'first_name',
			]) ?>
		</div>
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'last_name',
			]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'phone_number',
			]) ?>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
					<?= ModelAttribute::widget([
						'model' => $model,
						'attribute' => 'date_of_birth',
					]) ?>
				</div>
				<div class="col-md-6">
					<?= ModelAttribute::widget([
						'model' => $model,
						'attribute' => 'genderName',
					]) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= ModelAttribute::widget([
				'model' => $model,
				'attribute' => 'bio',
			]) ?>
		</div>
	</div>
</section>