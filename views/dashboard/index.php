<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;
?>
<div class="dashboard-page">
	<div class="card card-custom gutter-b">
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">Simple Column Chart</h3>
			</div>
		</div>
		<div class="card-body">
			<div id="kt_amcharts_1" style="height: 500px;"></div>
		</div>
	</div>
</div>