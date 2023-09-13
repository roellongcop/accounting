<?php

use app\models\search\UserSearch;
use app\helpers\Html;
use app\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'My Accountant';
$this->params['breadcrumbs'][] = $user->mainAttribute;
$this->params['searchModel'] = new UserSearch();
$this->params['wrapCard'] = false;
$this->params['activeMenuLink'] = Url::toRoute(['user/my-accountant']);
?>
<div class="user-profile-page">
	<?= $this->render('_accountant', ['model' => $model, 'tab' => $tab]) ?>
</div>