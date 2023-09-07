<?php

namespace app\controllers;

use app\helpers\App;
use app\models\User;
use app\models\form\ContactForm;
use app\models\form\LoginForm;
use app\models\form\PasswordResetForm;
use app\models\form\SetNewPasswordForm;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['AccessControl'] = [
            'class' => 'app\filters\AccessControl',
            'publicActions' => [
                'login',
                'reset-password',
                'contact',
                'set-new-password',
            ]
        ];
        $behaviors['VerbFilter'] = [
            'class' => 'app\filters\VerbFilter',
            'verbActions' => [
                'logout' => ['post'],
            ]
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        switch ($action->id) {
            case 'set-new-password':
            case 'login':
            case 'reset-password':
            case 'contact':
                $this->layout = 'login';
                break;

            default:
                # code...
                break;
        }
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionResetPassword()
    {
        $model = new PasswordResetForm();
        if ($model->load(App::post())) {
            if (($user = $model->process()) != null) {
                if ($model->hint) {
                    App::success("Your password hint is: '{$user->password_hint}'.");
                } else {
                    App::success("Email sent.");
                }
            } else {
                App::danger($model->errors);
            }
        }

        return $this->redirect(['login']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (App::isLogin()) {
            return $this->redirect(['dashboard/index']);
        }

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!App::isGuest()) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $PSR = new PasswordResetForm();
        if ($model->load(App::post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'PSR' => $PSR,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        App::logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(App::post()) && $model->contact()) {
            App::success('Thank you for contacting us. We will respond to you as soon as possible.');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSetNewPassword($prt='')
    {
        if (($user = User::findOne(['password_reset_token' => $prt])) != null) {

            $model = new SetNewPasswordForm(['prt' => $user->password_reset_token]);

            if ($model->load(App::post())) {
                if ($model->setNewPassword()) {
                    App::success('Password changed successfully!');
                    return $this->redirect(['login']);
                }
                else {
                    App::danger($model->errors);
                }
            }

            return $this->render('set-new-password', [
                'model' => $model,
            ]);
        }

        throw new NotFoundHttpException('Reset Token Invalid');
    }
}