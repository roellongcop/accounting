<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Overview';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;
$this->params['displayTitle'] = false;
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
        <div class="col-md-12">
            <?= $this->render('_due-dates', [
                'event' => $event
            ]) ?>
        </div>
    </div>
</div>