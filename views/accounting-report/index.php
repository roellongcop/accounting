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
    .circular-border {
        border-radius: 50%;
        width: 272px;
        height: 274px;
        background: linear-gradient(90deg, #0054a3, #0cd840);
        display: flex;
        justify-content: center;
        align-items: center;
        /* 3D/Embossed effect */
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.6), 
            -5px -5px 15px rgba(225, 225, 163, 0.6);
    }
    .circular-border:hover {
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.8), 
            -5px -5px 15px rgba(0, 84, 163, 0.8);
    }

    .image-click {
        margin-top: 40px;
    }

CSS);
?>
<div class="accounting-report-index-page">
    <a href="<?= App::setting('system')->manager_io_link ?>" target="_blank" class="text-center">
        <div class="circular-border">
            <img class="image-click" src="/default/account-it-right-circle-logo.png" alt="">
        </div>
        <p class="lead font-weight-bold mt-3 text-uppercase">Login to Manager.io</p>
    </a>
</div>