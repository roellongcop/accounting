<?php

use app\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
  <section>
    <p class="lead font-weight-bolder mb-10">CONTACT INFORMATION</p>
    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'viber')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
  </section>
  <div class="form-group mt-10">
    <?= $form->buttons() ?>
  </div>
<?php ActiveForm::end(); ?>