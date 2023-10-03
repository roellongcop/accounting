<?php

use app\widgets\ActiveForm;
use app\helpers\App;
?>

<?php if (App::identity('isDeveloper')): ?>
	<?php $form = ActiveForm::begin(['id' => 'setting-general-developer-form']); ?>
	    <h4 class="mb-10 font-weight-bold text-dark">Developer Settings</h4>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'css')->textarea(['rows' => 20]) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'js')->textarea(['rows' => 20]) ?>
			</div>
		</div>
		
		<div class="form-group"> <br>
			<?= $form->buttons() ?>
		</div>
	<?php ActiveForm::end(); ?>
<?php else: ?>
	    <h4 class="mb-10 font-weight-bold text-dark">Developer Settings</h4>
	    <h3 class="mb-10 font-weight-bold text-dark">These Settings is only available for developers</h3>
<?php endif ?>
