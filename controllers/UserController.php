<?php

namespace app\controllers;

use app\helpers\App;
use app\models\User;
use app\models\form\ChangePasswordForm;
use app\models\search\UserSearch;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            User::findByKeywords($keywords, ['u.username', 'u.email', 'r.name'])
        );
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(['UserSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => User::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User([
            'status' => User::STATUS_ACTIVE,
            'record_status' => User::RECORD_ACTIVE,
            'is_blocked' => User::UNBLOCKED
        ]);

        if ($model->load(App::post()) && $model->validate()) {
            $model->setPassword($model->password);
            if ($model->save()) {
                App::success('Successfully Created');
                return $this->redirect($model->viewUrl);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates an existing User model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDuplicate($slug)
    {
        $originalModel = User::controllerFind($slug, 'slug');
        $model = new User();
        $model->attributes = $originalModel->attributes;

        if ($model->load(App::post()) && $model->validate()) {
            $model->setPassword($model->password);
            if ($model->save()) {
                App::success('Successfully Duplicated');
                return $this->redirect($model->viewUrl);
            }
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = User::controllerFind($slug, 'slug');

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    // public function _ctionDelete($slug)
    // {
    //     $model = User::controllerFind($slug, 'slug');

    //     if ($model->delete()) {
    //         App::success('Successfully Deleted');
    //     } else {
    //         App::danger(json_encode($model->errors));
    //     }

    //     return $this->redirect($model->indexUrl);
    // }

    public function actionMyPassword($token = '')
    {
        $user = ($token) ? User::controllerFind($token, 'password_reset_token') : App::identity();

        $model = new ChangePasswordForm([
            'user_id' => $user->id,
            'password_hint' => $user->password_hint
        ]);

        if ($model->load(App::post()) && $model->changePassword()) {
            App::success('Password Change.');
            return $this->redirect(['user/my-password']);
        }

        $user->setGoogleAuthenticator();

        return $this->render('my_password', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionMyAccountant($tab='personal')
    {
        $user = User::controllerFind(App::identity('accountant_id'));

        if (!$user) throw new NotFoundHttpException('User not found.');
        
        $model = $user->profile;

        return $this->render('my-accountant', [
            'user' => $user,
            'model' => $model,
            'tab' => $tab,
        ]);
    }

    public function actionAccountant($slug='', $tab='personal')
    {
        $user = User::findOne(['slug' => $slug]) ?: User::findOne(App::identity('accountant_id'));

        if (!$user) throw new NotFoundHttpException('User not found.');
        
        $model = $user->profile;

        return $this->render('accountant', [
            'user' => $user,
            'model' => $model,
            'tab' => $tab,
        ]);
    }

    public function actionProfile($slug='', $tab='personal')
    {
        $user = User::findOne(['slug' => $slug]) ?: App::identity();
        $model = $user->profile;

        if (($post = App::post()) != null) {
            $post[App::className($model)]['certification'] = $post[App::className($model)]['certification'] ?? '';

            if ($model->load($post) && $model->save()) {
                App::success('Profile Updated');
                return $this->redirect(['profile', 
                    'slug' => $user->slug,
                    'tab' => $tab,
                ]);
            }
        }

        return $this->render($model::META_NAME, [
            'user' => $user,
            'model' => $model,
            'tab' => $tab,
        ]);
    }

    public function actionMyAccount()
    {
        $model = App::identity();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->refresh();
        }
        $model->flashErrors();
        return $this->render('my_account', [
            'model' => $model,
        ]);
    }

    public function actionDashboard($slug)
    {
        $model = User::find()
            ->where([
                'slug' => $slug,
                'status' => 10,
                'is_blocked' => 0,
                'record_status' => 1
            ])
            ->one();

        if ($model) {
            App::user()->logout();
            App::user()->login($model, 0);

            return $this->redirect(['dashboard/index']);
        } else {
            App::danger('No user found or user is cannot be log in.');
        }

        return $this->redirect(App::referrer());
    }

    public function actionChangeLoginType($slug, $type=User::LOGIN_TYPE_DEFAULT)
    {
        $model = User::controllerFind($slug, 'slug');
        $model->login_type = $type;
        if ($model->save()) {
            App::success('Login Type Changed.');
        }
        else {
            App::danger($model->errorSummary);
        }

        return $this->redirect(App::referrer());
    }

    public function actionUpdateRoleAccess($slug)
    {
        $model = User::controllerFind($slug, 'slug');
        $post = App::post();

        if (!$post) {
            App::warning('No post data');
            return $this->redirect(App::referrer());
        }

        $model->navigation = $post['User']['navigation'] ?? [];
        $model->module_access = $post['User']['module_access'] ?? [];
        if ($model->save()) {
            App::success('Role updated');
        }
        else {
            App::error($model->errorSummary);
        }

        return $this->redirect(App::referrer());
    }

    public function actionResetRoleAccess($slug)
    {
        $model = User::controllerFind($slug, 'slug');

        $model->navigation = [];
        $model->module_access = [];
        if ($model->save()) {
            App::success('Role was reset');
        }
        else {
            App::error($model->errorSummary);
        }

        return $this->redirect(App::referrer());
    }
}