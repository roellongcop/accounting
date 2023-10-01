<?php

namespace app\controllers;

use app\helpers\App;
use app\models\CashFlow;
use app\models\search\CashFlowSearch;

/**
 * CashFlowController implements the CRUD actions for CashFlow model.
 */
class CashFlowController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            CashFlow::findByKeywords($keywords, ['cf.name', 'cf.description'])
        );
    }

    /**
     * Lists all CashFlow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashFlowSearch();
        $dataProvider = $searchModel->search(['CashFlowSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CashFlow model.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => CashFlow::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new CashFlow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CashFlow();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new CashFlow model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = CashFlow::controllerFind($slug, 'slug');
        $model = new CashFlow();
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
     * Updates an existing CashFlow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = CashFlow::controllerFind($slug, 'slug');

        if (($post = App::post()) != null) {
            $post['CashFlow']['file_tokens'] = $post['CashFlow']['file_tokens'] ?? [];

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
     * Deletes an existing CashFlow model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = CashFlow::controllerFind($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger($model->errors);
        }

        return $this->redirect($model->indexUrl);
    }
}