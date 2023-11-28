
<?php

use app\widgets\ActiveForm;
use app\helpers\App;
use app\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>
    <section>
        <p class="lead font-weight-bolder mb-10">Professional Networking</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'linkedIn')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="my-5"></div>
    <!-- <section>
        <p class="lead font-weight-bolder mb-5">General Social Media</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section> -->
    <div class="my-5"></div>
    <section>
        <p class="lead font-weight-bolder mb-5">Video Sharing Platforms</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'youTube')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'vimeo')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="my-5"></div>
    <section>
        <p class="lead font-weight-bolder mb-5">Forums and Community Boards</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'reddit')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'quora')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="my-5"></div>
    <section>
        <p class="lead font-weight-bolder mb-5">Blogging Platforms</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'medium')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'wordPress')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="my-5"></div>
    <section>
        <p class="lead font-weight-bolder mb-5">Industry-Specific Platforms</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'xero')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'quickBooks')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="my-5"></div>
    <section>
        <p class="lead font-weight-bolder mb-5">Collaboration and Work Management</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'slack')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="my-5"></div>
    <section>
        <p class="lead font-weight-bolder mb-5">Visual Boards</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'pinterest')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="my-5"></div>
    <section>
        <p class="lead font-weight-bolder mb-5">Others</p>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'snapchat')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'tikTok')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'bitrix')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'tawkto')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </section>
    <div class="form-group mt-10">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>