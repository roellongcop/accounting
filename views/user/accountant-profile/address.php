<?php

use app\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
	<section>
		<p class="lead font-weight-bolder mb-10">ADDRESS INFORMATION</p>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
	</section>
	<div class="form-group mt-10">
		<?= $form->buttons() ?>
	</div>
<?php ActiveForm::end(); ?>