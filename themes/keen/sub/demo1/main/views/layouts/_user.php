<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
?>
<div class="topbar-item ml-4">
    <div class="">
        <?= Html::image(App::setting('image')->primary_logo, ['w' => 40 , 'quality' => 90], [
            'class' => 'h-30px align-self-end',
            'alt' => 'AIR Logo',
        ]) ?>
    </div> 
</div>