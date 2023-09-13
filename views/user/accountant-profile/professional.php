<?php

use app\widgets\ActiveForm;
use app\helpers\App;
use app\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>
	<section>
		<p class="lead font-weight-bolder mb-10">PROFESSIONAL INFORMATION</p>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'years_of_experience')->textInput(['type' => 'number']) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'current_employer')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'job_title')->textInput(['maxlength' => true]) ?>
			</div>
		</div>

		<p class="lead font-weight-bolder my-5">CERTIFICATION</p>
		<div class="row">
			<div class="col-md-6">
				<?= $form->dropzone($model, 'certification', 'Certification', [
					'title' => 'Upload Certification (PDF)',
					'maxFiles' => 1,
					'files' => $model->file ? [$model->file]: null
				]) ?>

				<div class="mt-5">
					<?= App::if($model->file, 
						fn ($file) => Html::a('View Certification', $file->viewerUrl, [
							'class' => 'btn btn-primary font-weight-bold',
							'target' => '_blank'
						])
					) ?>
				</div>
			</div>
		</div>
	</section>
	<div class="form-group mt-10">
		<?= $form->buttons() ?>
	</div>
<?php ActiveForm::end(); ?>