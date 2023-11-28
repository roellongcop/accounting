<?php

/* @var $form app\widgets\ActiveForm */
/* @var $model app\models\LoginForm */
use app\helpers\App;
use app\widgets\Alert;
use app\widgets\ActiveForm;
use app\helpers\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$publishedUrl = App::publishedUrl();

$this->registerCss(<<< CSS
    .login.login-1 .login-aside,
    .login.login-1 .login-content  {
        width: 50% !important;
        max-width: none !important;
    }
    .login-aside {
        background-image: url('/default/login-gradient-bg2.png');
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;
        overflow: hidden;
        border-top-right-radius: 30px;
        border-bottom-right-radius: 30px;
    }
    .arrow-img-top {
        background-repeat: no-repeat;
        position: absolute;
        top: -250px;
        left: -78px;
        animation: diagonal-move-anim 2s linear;
        animation-fill-mode: forwards;  
    }
    .arrow-img-bottom {
        background-repeat: no-repeat;
        position: absolute;
        bottom: -250px;
        right: -98px;
        animation: diagonal-move-anim2 2s linear;
        animation-fill-mode: forwards;      
    }
    @keyframes diagonal-move-anim {
        0% {
            top: -250px;
            left: -78px;
        }
        100% {
            top: -230px;
            left: -108px;
        }
    }

    @keyframes diagonal-move-anim2 {
        0% {
            bottom: -250px;
            right: -98px;
        }
        100% {
            bottom: -230px;
            right: -128px;
        }
    }
    .color-default {
        color: #3a3a3a;
        text-align: center;
    }
    .color-subdefault {
        color: #767676;
        text-align: center;
    }
    .btn-login {
        background-color: #50CD89; 
        width: 100%;
        color: #ffffff;
    }
    .btn-cancel {
        width: 100%;
    }
    .login-aside {
        background-color: #7EBFDB;
    }
    .aside-img {
        background-image: url("{$publishedUrl}/media/svg/illustrations/payment.svg");
        min-height: auto !important;
    }

    @media only screen and (max-width: 991px) {

        .arrow-img-top,
        .arrow-img-bottom {
            display: none;
        }

        .login.login-1 .login-aside {
            background-color: #7EBFDB;
            width: 100% !important;
            border-top-right-radius: 0px;
            border-bottom-left-radius: 30px !important;
            border-bottom-right-radius: 30px !important;
        }

        .login.login-1 .login-content {
            width: 100% !important;      
        }

        .login-logo {
            height: 200px !important;
        }

        .tagline-img {
            margin-bottom: 50px;
        }    
    }

    @media only screen and (max-width: 767px) {
        .air-logo {
            height: 200px !important;
        }
        .arrow-img-top,
        .arrow-img-bottom {
            display: none;
        }
        .tagline-img {
            width: 80% !important;
        }
    }
    @media only screen and (max-width: 425px) {
        .img-container {
            flex-wrap: wrap;
            justify-content: center;
        }
        .air-logo {
            height: 140px !important;
        }
    }
CSS);
?>
<div class="d-flex flex-column flex-root">
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside d-flex flex-column flex-row-auto justify-content-center">
            <div class="d-flex flex-column tagline align-items-center">
                <a href="#" class="text-center">
                    <img class=" mw-250 air-logo" src="/default/account-it-right-circle-logo.png" alt="Logo">
                </a>
                <img class="tagline-img" src="/default/tagline.png" alt="tagline">
            </div>
            <div class="arrow-img-top">
                <img src="/default/Group 289288.png">
            </div>
            <div class="arrow-img-bottom">
                <img src="/default/Group 289287.png">
            </div>
        </div>
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex flex-column-fluid flex-center">
                <div class="login-form login-signin">
                    <?= Alert::widget() ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'kt_login_signin_form',
                        'errorCssClass' => 'is-invalid',
                        'successCssClass' => 'is-valid',
                        'validationStateOn' => 'input',
                        'options' => [
                            'class' => 'form',
                            'novalidate' => 'novalidate'
                        ]
                    ]); ?>
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder color-default  font-size-h4 font-size-h1-lg">Sign In</h3>
                            <div class="text-muted font-weight-bold color-subdefault font-size-h4">
                                Welcome to My AIR
                            </div>
                        </div>
                        <?= $form->field($model, 'username', [
                            'template' => '
                                <label class="font-size-h6 font-weight-bolder text-dark">
                                    Username
                                </label>
                                {input}{error}
                            '
                        ])->textInput([
                            'autofocus' => true, 
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg'
                        ]) ?>
                        <?= $form->field($model, 'password', [
                            'template' => '
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                {input}{error}
                            '
                        ])->passwordInput([
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg'
                        ]) ?>
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_signin_submit" class="btn btn-login font-weight-bolder font-size-h6 px-8 py-4 my-3">Sign In</button>
                            <div class="forgot text-center">
                                <a href="#" class="text-primary font-size-h6 text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="login-form login-signup">
                    <form class="form" novalidate="novalidate" id="kt_login_signup_form">
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sign Up</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</p>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="text" placeholder="Fullname" name="fullname" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Password" name="password" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label class="checkbox mb-0">
                                <input type="checkbox" name="agree" />
                                <span></span>
                            </label>
                            <div class="pl-2">I Agree the
                            <a href="#" class="ml-1">terms and conditions</a></div>
                        </div>
                        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
                        <button type="button" id="kt_login_signup_submit" class="btn btn-login btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Submit</button>
                            <button type="button" id="kt_login_signup_cancel" class="btn  btn-cancel  btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="login-form login-forgot">
                    <?php $form = ActiveForm::begin([
                        'id' => 'kt_login_forgot_form',
                        'errorCssClass' => 'is-invalid',
                        'successCssClass' => 'is-valid',
                        'validationStateOn' => 'input',
                        'options' => [
                            'class' => 'form',
                            'novalidate' => 'novalidate'
                        ],
                        'action' => ['reset-password']
                    ]); ?>
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>
                        <?= $form->field($PSR, 'email')->textInput([
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg font-size-h6',
                            'type' => 'email',
                            'placeholder' => 'Email',
                            'autocomplete' => 'off',
                        ])->label(false) ?>
                        <div class="form-group">
                            <div class="checkbox-list"> 
                                <label class="checkbox">
                                    <input type="checkbox" 
                                        value="1" 
                                        name="PasswordResetForm[hint]"> 
                                    <span></span>
                                    Show password hint instead.
                                </label>
                            </div>
                        </div>
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                        <button type="submit" id="" class="btn btn-login font-weight-bolder font-size-h6 px-8 py-4 my-3">Submit</button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-cancel btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>