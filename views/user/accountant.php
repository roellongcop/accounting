<?php

use app\models\search\UserSearch;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'Accountant: ' . $user->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $user->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $user->mainAttribute, 'url' => $user->viewUrl];
$this->params['breadcrumbs'][] = ucwords($tab);
$this->params['searchModel'] = new UserSearch();
$this->params['wrapCard'] = false;
$this->params['headerButtons'] = Html::a('Update Profile', ['user/profile', 'slug' => $user->slug], [
	'class' => 'btn btn-primary font-weight-bold'
]);
?>
<div class="user-profile-page">
	<?= $this->render('_accountant', ['model' => $model, 'tab' => $tab]) ?>
</div>