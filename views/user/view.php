<?php

use app\models\search\UserSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;
use app\helpers\App;
use app\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\Nestable;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false;

$this->registerCss(<<< CSS
    .detail-view {
        margin-top: 0;
    }
CSS);
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
    <div class="row mt-2">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Main Information'
            ]) ?>
                <?= Detail::widget(['model' => $model]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'QR Authenticator',
                'stretch' => true
            ]) ?>
                <div class="text-center">
                    <?= Html::img($model->qRCodeurl, [
                        'class' => 'img-thumbnail symbol'
                    ]) ?>
                    <p class="lead font-weight-bold mt-10">Scan These QR Code to add to Google Authenticator</p>
                </div>
            <?php $this->endContent() ?>
        </div>
    </div>

    <?php if (App::identity()->can('update-role-access', 'user')): ?>
        <?php $form = ActiveForm::begin(['id' => 'navigation-form', 'action' => ['user/update-role-access', 'slug' => $model->slug]]); ?>
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Role Access',
                'toolbar' => Html::tag(
                    'div',
                        Html::tag('div', implode(' ', [
                            Html::a('Reset', ['user/reset-role-access', 'slug' => $model->slug], [
                                'class' => 'btn btn-warning font-weight-bold',
                                'data-confirm' => 'Are you sure?',
                                'data-method' => 'post'
                            ]),
                            Html::submitButton('Save Role Access', ['class' => 'btn btn-success font-weight-bold'])
                        ]), ['class' => 'd-flex', 'style' => 'gap: 3px']) , 
                    [
                        'class' => 'card-toolbar'
                    ])
            ]) ?>
                <ul class="nav nav-tabs nav-tabs-line">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-navigation-">
                            Navigation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-module-access">
                            Module Access
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-5" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-navigation-" role="tabpanel">
                        <?= Nestable::widget([
                            'controller_actions' => $model->role->module_access,
                            'navigations' => $model->mainNavigation,
                            'defaultName' => 'User[navigation]'
                        ]) ?>
                    </div>
                    <div class="tab-pane fade" id="tab-module-access" role="tabpanel">
                        <?= $this->render('/role/_form_actions', [
                            'controller_actions' => $model->role->module_access,
                            'module_access' => $model->moduleAccess,
                            'name' => 'User[module_access]'
                        ]) ?>
                    </div>
                </div>
                
                <?= Html::submitButton('Save Role Access', ['class' => 'btn btn-success font-weight-bold'])?>
            <?php $this->endContent() ?>
        <?php ActiveForm::end(); ?>
    <?php endif ?>
</div>
