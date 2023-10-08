<?php

namespace app\controllers;

use app\helpers\App;
use app\models\BirFilling;
use app\models\search\BirFillingSearch;
use app\helpers\FileHelper;

/**
 * BirFillingController implements the CRUD actions for BirFilling model.
 */
class BirFillingController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            BirFilling::findByKeywords($keywords, ['bf.name', 'bf.description'])
        );
    }

    /**
     * Lists all BirFilling models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BirFillingSearch();
        $dataProvider = $searchModel->search(['BirFillingSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BirFilling model.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => BirFilling::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new BirFilling model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BirFilling();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new BirFilling model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = BirFilling::controllerFind($slug, 'slug');
        $model = new BirFilling();
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
     * Updates an existing BirFilling model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = BirFilling::controllerFind($slug, 'slug');

        if (($post = App::post()) != null) {
            $post['BirFilling']['file_tokens'] = $post['BirFilling']['file_tokens'] ?? [];

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
     * Deletes an existing BirFilling model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = BirFilling::controllerFind($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger($model->errors);
        }

        return $this->redirect($model->indexUrl);
    }
}