<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Overview';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;
$this->params['displayTitle'] = false;

$this->registerCss(<<< CSS
    .subheader {
        padding-bottom: 0!important;
    }
CSS);
?>
<div class="dashboard-page">
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('_income-expenses', [
                'cashFlow' => $cashFlow
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $this->render('_receivables', [
                'receivable' => $receivable
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $this->render('_payables', [
                'payable' => $payable
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('_due-dates', [
                'event' => $event
            ]) ?>
        </div>
    </div>
</div>