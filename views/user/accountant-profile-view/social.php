
<?php

use app\widgets\ModelAttribute;
?>

<section>
    <p class="lead font-weight-bolder mb-10">Professional Networking</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'linkedIn',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">General Social Media</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'facebook',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'instagram',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'twitter',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">Video Sharing Platforms</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'youTube',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'vimeo',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">Forums and Community Boards</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'reddit',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'quora',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">Blogging Platforms</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'medium',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'wordPress',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">Industry-Specific Platforms</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'xero',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'quickBooks',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">Collaboration and Work Management</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'slack',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">Visual Boards</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'pinterest',
            ]) ?>
        </div>
    </div>
</section>
<div class="my-5"></div>
<section>
    <p class="lead font-weight-bolder mb-5">Others</p>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'snapchat',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'tikTok',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'bitrix',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'tawkto',
            ]) ?>
        </div>
    </div>
</section>