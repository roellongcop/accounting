<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Payroll;
use app\models\search\PayrollSearch;

/**
 * PayrollController implements the CRUD actions for Payroll model.
 */
class PayrollController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Payroll::findByKeywords($keywords, ['p.name', 'p.description'])
        );
    }

    /**
     * Lists all Payroll models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayrollSearch();
        $dataProvider = $searchModel->search(['PayrollSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payroll model.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => Payroll::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new Payroll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payroll();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Payroll model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = Payroll::controllerFind($slug, 'slug');
        $model = new Payroll();
        $model->attributes = $originalModel->attributes;

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Duplicated');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing Payroll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = Payroll::controllerFind($slug, 'slug');

        if (($post = App::post()) != null) {
            $post['Payroll']['file_tokens'] = $post['Payroll']['file_tokens'] ?? [];

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Updated');
                return $this->redirect($model->viewUrl);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Payroll model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Payroll::controllerFind($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger($model->errors);
        }

        return $this->redirect($model->indexUrl);
    }
}