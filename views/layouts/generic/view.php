<?php

use app\widgets\Detail;
use app\widgets\DataTable;
?>

<div class="row">
    <div class="col-md-6">
        <p class="lead font-weight-bolder mt-5">PRIMARY INFORMATION</p>
        <?= Detail::widget(['model' => $model]) ?>
    </div>
    <div class="col-md-6">
        <div class="mt-5">
            <?= DataTable::widget(['models' => $model->files, 'pageLength' => 3]) ?>
        </div>
    </div>
</div>