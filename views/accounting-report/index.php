<?php

use app\helpers\App;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AccountingReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounting Reports';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<< CSS
    .accounting-report-index-page {
        height: 45vh; 
        display: flex; 
        align-items: center; 
        justify-content: center;
    }
CSS);
?>
<div class="accounting-report-index-page"> <div>
        <?= Html::a('Login to Manager.io', App::setting('system')->manager_io_link, [
            'class' => 'btn btn-lg btn-outline-primary font-weight-bolder',
            'target' => '_blank'
        ]) ?>
    </div>
</div>