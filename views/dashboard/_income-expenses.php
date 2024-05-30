<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use app\widgets\ActiveForm;
use app\models\User;
use app\models\Role;
use app\helpers\App;


$this->addCssFile('css/dashboard-income-expenses');
$this->addJsFile('js/dashboard-income-expenses');

$this->registerJs(<<< JS
    initData("{$cashFlow->allDateRange}");
JS);

if (!App::identity()->can('index', 'cash-flow')) return;
?>

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
                        <?= $form->bootstrapSelect($cashFlow, 'user_id', User::dropdown('id', 'username', App::identity('isAccountant') ? [
                            'role_id' => Role::CLIENT,
                            'accountant_id' => App::identity('id')
                        ]: ['role_id' => Role::CLIENT]), [
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
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-9">
                <div id="cashflow-chart"></div>
            </div>
            <div class="col-md-3 total-container">
                <p class="text-muted mb-0 font-weight-bolder">Income</p>
                <div class="font-weight-bolder display-4" id="total-income"></div>
                <hr>
                <p class="text-muted mb-0 font-weight-bolder mt-5">Expense</p>
                <div class="font-weight-bolder display-4" id="total-expense"></div>
                <hr>
                <p class="text-muted mb-0 font-weight-bolder mt-5" id="total-balance-label">Balance</p>
                <div class="font-weight-bolder display-4" id="total-balance"></div>
            </div>
        </div>
    </div>
</div>