<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use app\widgets\ActiveForm;
use app\models\User;
use app\models\Role;
use app\helpers\App;

$this->title = 'Overview';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;
$this->params['displayTitle'] = false;

$this->addCssFile('amcharts/lib/3/plugins/export/export');
$this->addCssFile('css/dashboard');

$this->addJsFile('amcharts/lib/3/amcharts');
$this->addJsFile('amcharts/lib/3/serial');

$this->addJsFile('amcharts/lib/3/plugins/animate/animate.min');
$this->addJsFile('amcharts/lib/3/plugins/export/export.min');
$this->addJsFile('amcharts/lib/3/themes/light');

$this->addJsFile('js/dashboard');

$this->registerJs(<<< JS
    initData("{$cashFlow->allDateRange}");
JS);
?>
<div class="dashboard-page">
    <div class="row">

        <div class="col-md-12">
            <div class="card card-custom gutter-b cashflow-card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Income/Expense Trend</h3>
                    </div>
                    <div class="card-toolbar">
                        <?php $form = ActiveForm::begin(['id' => 'filter-form']); ?>
                            <?= $form->dateRange($cashFlow, [
                                'title' => 'Date Filter',
                                'onChange' => <<< JS
                                    const userId = $('#cashflow-user_id').val();
                                    fetchData({dateRange: inputValue, userId})
                                JS
                            ]) ?>

                            <?php if (!App::identity('isClient')): ?>
                                <div class="d-flex ml-5">
                                    <?= $form->bootstrapSelect($cashFlow, 'user_id', User::dropdown('id', 'username', [
                                        'role_id' => Role::CLIENT
                                    ]), [
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
                <div class="card-body">
                    <div id="cashflow-chart" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Tax Due Dates</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="kt_amcharts_1" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div> -->
</div>