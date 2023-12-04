<?php

use app\helpers\Html;
use app\widgets\ModelAttribute;
?>

<section>
  <p class="lead font-weight-bolder mb-10">PERSONAL INFORMATION</p>
  <div class="row">
    <div class="col-md-6">
      <?= ModelAttribute::widget([
        'model' => $model,
        'attribute' => 'email',
      ]) ?>
    </div>
    <div class="col-md-6">
      <?= ModelAttribute::widget([
        'model' => $model,
        'attribute' => 'viber',
      ]) ?>
    </div>
  </div>
</section>