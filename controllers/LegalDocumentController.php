<?php

namespace app\controllers;

use app\helpers\App;
use app\models\LegalDocument;
use app\models\search\LegalDocumentSearch;

/**
 * LegalDocumentController implements the CRUD actions for LegalDocument model.
 */
class LegalDocumentController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            LegalDocument::findByKeywords($keywords, ['name', 'description'])
        );
    }

    /**
     * Lists all LegalDocument models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LegalDocumentSearch();
        $dataProvider = $searchModel->search(['LegalDocumentSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LegalDocument model.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => LegalDocument::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new LegalDocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LegalDocument();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new LegalDocument model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = LegalDocument::controllerFind($slug, 'slug');
        $model = new LegalDocument();
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
     * Updates an existing LegalDocument model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = LegalDocument::controllerFind($slug, 'slug');

        if (($post = App::post()) != null) {
            $post['LegalDocument']['file_tokens'] = $post['LegalDocument']['file_tokens'] ?? [];

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
     * Deletes an existing LegalDocument model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = LegalDocument::controllerFind($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger($model->errors);
        }

        return $this->redirect($model->indexUrl);
    }
}