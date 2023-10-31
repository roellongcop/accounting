<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Event;
use app\models\search\EventSearch;
use app\widgets\ActiveForm;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Event::findByKeywords($keywords, ['e.name', 'e.description'])
        );
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(['EventSearch' => App::queryParams()]);

        if (App::isAjax()) {
            return $this->asJson([
                'status' => 'success',
                'models' => $dataProvider->models
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        $model = Event::controllerFind($slug, Event::tableName() . '.slug');

        if (App::isAjax()) {
            $can_update = App::identity()->can('update');

            $result = $can_update
                ? $this->renderAjax('_form-ajax', [
                    'model' => $model,
                    'action' => 'update'
                ])
                : $model->detailView;

            return $this->asJson([
                'status' => 'success',
                'model' => $model,
                'result' => $result,
                'can_update' => $can_update,
            ]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event([
            'color' => Event::BLUE
        ]);

        if (App::get('ajaxValidate')) {
            return $this->_ajaxValidate($model);
        }
        
        if ($model->load(App::post()) && $model->save()) {
            if (App::isAjax()) {
                return $this->_ajaxCreated($model);
            }

            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        if (App::isAjax()) {
            return $this->_ajaxForm($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Event model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $model = Event::controllerFind($slug, Event::tableName() . '.slug');
        $model = new Event();
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
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = Event::controllerFind($slug, Event::tableName() . '.slug');

        if (App::get('ajaxValidate')) {
            return $this->_ajaxValidate($model);
        }
        
        if ($model->load(App::post()) && $model->save()) {
            if (App::isAjax()) {
                return $this->_ajaxCreated($model);
            }

            App::success('Successfully Updated');

            return $this->redirect($model->viewUrl);
        }

        if (App::isAjax()) {
            return $this->_ajaxForm($model);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Event::controllerFind($slug, Event::tableName() . '.slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger($model->errors);
        }

        return $this->redirect($model->indexUrl);
    }
}