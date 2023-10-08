<?php

use app\helpers\Html;
use app\helpers\Url;
use app\helpers\App;
use app\models\User;
use app\models\Role;
use app\widgets\StackChart;
use app\widgets\ActiveForm;

$clients = User::clientsDropdown();

$this->registerCss(<<< CSS
  .field-receivable-user_id {
    margin-bottom: 0 !important;
  }
CSS);
?>

<div class="card card-custom gutter-b card-stretch">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label">Receivables</h3>
		</div>
		<div class="card-toolbar">
			<?php $form = ActiveForm::begin(['id' => 'filter-form']); ?>
        <?php if (!App::identity('isClient')): ?>
          <div class="d-flex">
            <?= $form->bootstrapSelect($receivable, 'user_id', $clients, [
            	'label' => false,
              'options' => [
                'class' => 'kt-selectpicker form-control',
                'tabindex' => 'null',
              ]
            ]) ?>
          </div>
        <?php endif ?>
    <?php ActiveForm::end(); ?>
		</div>
	</div>

	<div class="card-body p-0 pt-5 ">
  	<?= App::ifElse(array_key_first($clients), fn ($id) => StackChart::widget([
  		'data_url' => Url::toRoute(['dashboard/filter-receivable']),
  		'user_id' => $id,
			'additional_scripts' => <<< JS
				$('#receivable-user_id').change(function() {
					const userId = $(this).val();
					stackChart.userId = userId;
					stackChart.fetchData();
				});
			JS
  	]), 'No data found') ?>
	</div>

	<div class="card-footer d-flex justify-content-between">
		<?= Html::a('Create New', ['receivable/create'], [
			'class' => 'btn btn-success font-weight-bolder'
		]) ?>
		<?= Html::a('View All Receivables', ['receivable/index'], [
			'class' => 'btn btn-outline-secondary font-weight-bolder'
		]) ?>
	</div>
</div>
