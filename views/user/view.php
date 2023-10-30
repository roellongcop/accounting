<?php

use app\models\search\UserSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;
use app\helpers\App;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="user-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
    ]) ?>  
    <?= $model->isClient ? '': Anchor::widget([
    	'title' => 'Profile', 
    	'link' => ['profile', 'slug' => $model->slug],
    	'options' => ['class' => 'btn btn-success']
    ]) ?>
    <?= Anchor::widget([
        'title' => 'User Dashboard', 
        'link' => ['user/dashboard', 'slug' => $model->slug],
        'options' => [
            'class' => 'btn btn-warning',
            'data-method' => 'post',
            'data-confirm' => 'Your account will be logout!'
        ]
    ]) ?>

    <?= Anchor::widget([
        'title' => 'User Activities', 
        'link' => ['log/index', 'userSlug' => $model->slug],
        'options' => ['class' => 'btn btn-secondary']
    ]) ?>
    <div class="row">
        <div class="col-md-6">
            <?= Detail::widget(['model' => $model]) ?>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <?= Html::img($model->qRCodeurl, [
                    'class' => 'img-thumbnail symbol'
                ]) ?>

                <p class="lead font-weight-bold mt-10">Scan These QR Code to add to Google Authenticator</p>
            </div>
        </div>
    </div>
</div>