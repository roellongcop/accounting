<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\ActiveForm;
use app\widgets\Alert;

$this->title = 'Set New Password';
$this->params['breadcrumbs'][] = $this->title;

$publishedUrl = App::publishedUrl();

$this->registerCss(<<< CSS
    .ss-container {
      max-width: 500px;
      margin: 0 auto;
      padding: 40px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .ss h1 {
      color: #333;
      font-size: 24px;
      margin-bottom: 20px;
      text-align: center;
    }

    .ss p {
      color: #666;
      font-size: 16px;
      line-height: 1.5;
      margin-bottom: 10px;
    }

    .ss ol {
      margin-bottom: 20px;
      padding-left: 20px;
    }

    .ss a {
      color: #007bff;
      text-decoration: none;
    }

    .ss a:hover {
      text-decoration: underline;
    }
CSS);
?>
<div class="d-flex flex-column flex-root">
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #7EBFDB;">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <a href="/" class="text-center mb-15">
                    <img src="<?= $publishedUrl . '/media/logos/logo-5.svg' ?>" alt="logo" class="h-70px" />
                </a>
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white">Discover Amazing
                <br />Features &amp; Possibilites</h3>
            </div>
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(<?= $publishedUrl . '/media/svg/illustrations/payment.svg' ?>)"></div>
        </div>
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex flex-column-fluid flex-center">
               <form id="kt_login_forgot_form"></form>
               <form id="kt_login_signin_form"></form>
                <div class="login-form login-signin">
                    <?= Alert::widget() ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'kt_login_signup_form',
                        'errorCssClass' => 'is-invalid',
                        'successCssClass' => 'is-valid',
                        'validationStateOn' => 'input',
                        'options' => [
                            'class' => 'form',
                            'novalidate' => 'novalidate'
                        ]
                    ]); ?>

                        <div class="pb-5 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Reset Password</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Set your new password</p>
                        </div>
                        <?= $form->field($model, 'password', ['template' => '{input}{error}'])->passwordInput([
                                'class' => 'form-control form-control-solid h-auto p-6 rounded-lg font-size-h6',
                                'autocomplete' => 'off',
                                'placeholder' => 'New Password'
                            ]
                        ) ?>
                        <?= $form->field($model, 'password_repeat', ['template' => '{input}{error}'])->passwordInput([
                                'class' => 'form-control form-control-solid h-auto p-6 rounded-lg font-size-h6',
                                'autocomplete' => 'off',
                                'placeholder' => 'Confirm NewPassword'
                            ]
                        ) ?>


                        <div class="form-group d-flex align-items-center">
                            <div class="pl-2 font-weight-bold">Password remembered?
                                <?= Html::tag('a', 'Login here', [
                                    'href' => Url::toRoute(['login']),
                                    'class' => 'ml-1'
                                ]) ?>
                            </div>
                        </div>
                        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
                        <button type="submit" id="" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Reset Password</button>

                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>