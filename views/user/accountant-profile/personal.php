<?php

use app\widgets\ActiveForm;
use app\helpers\App;
use app\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>
	<section>
		<p class="lead font-weight-bolder mb-10">PERSONAL INFORMATION</p>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<?= $form->datePicker($model, 'date_of_birth') ?>
					</div>
					<div class="col-md-6">
						<?= $form->bootstrapSelect($model, 'gender', App::keyMapParams('genders')) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<?= $form->field($model, 'bio')->textarea(['rows' => 8]) ?>
			</div>
			<div class="col-md-3">
				<div class="mt-8 text-center">
					<?= Html::image($model->photo, ['w' => 150], [
		                'class' => 'img-thumbnail user-photo',
		                'loading' => 'lazy',
		            ] ) ?>
		            <br>

		            <?= $form->imageGallery($model, 'photo', 'User', [
		                'ajaxSuccess' => "
		                    if(s.status == 'success') {
		                        $('.user-photo').attr('src', s.src);
		                    }
		                ",
		            ]) ?>
				</div>
			</div>
		</div>
	</section>
	<div class="form-group mt-10">
		<?= $form->buttons() ?>
	</div>
<?php ActiveForm::end(); ?>