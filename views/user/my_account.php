<?php

use app\models\search\UserSearch;
use app\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update Account';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => ['view', 'slug' => $model->slug]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
$this->params['activeMenuLink'] = Url::toRoute(['user/my-account']);
?>
<div class="user-my-account-page">
	<?= $this->render('_form_my_account', [
        'model' => $model,
    ]) ?>
</div>