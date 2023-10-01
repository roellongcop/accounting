<?php

namespace app\controllers;

use app\helpers\App;
use app\models\AccountingReport;
use app\models\search\AccountingReportSearch;

/**
 * AccountingReportController implements the CRUD actions for AccountingReport model.
 */
class AccountingReportController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            AccountingReport::findByKeywords($keywords, ['ar.name', 'ar.description'])
        );
    }

    /**
     * Lists all AccountingReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountingReportSearch();
        $dataProvider = $searchModel->search(['AccountingReportSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccountingReport model.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => AccountingReport::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new AccountingReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountingReport();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new AccountingReport model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = AccountingReport::controllerFind($slug, 'slug');
        $model = new AccountingReport();
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
     * Updates an existing AccountingReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = AccountingReport::controllerFind($slug, 'slug');
        if (($post = App::post()) != null) {
            $post['AccountingReport']['file_tokens'] = $post['AccountingReport']['file_tokens'] ?? [];

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
     * Deletes an existing AccountingReport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = AccountingReport::controllerFind($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger($model->errors);
        }

        return $this->redirect($model->indexUrl);
    }
}