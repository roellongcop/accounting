<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Receivable;
use app\models\search\ReceivableSearch;

/**
 * ReceivableController implements the CRUD actions for Receivable model.
 */
class ReceivableController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Receivable::findByKeywords($keywords, ['r.title', 'r.description', 'r.amount'])
        );
    }

    /**
     * Lists all Receivable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceivableSearch();
        $dataProvider = $searchModel->search(['ReceivableSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Receivable model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Receivable::controllerFind($id),
        ]);
    }

    /**
     * Creates a new Receivable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Receivable();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Receivable model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($id)
    {
        $originalModel = Receivable::controllerFind($id);
        $model = new Receivable();
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
     * Updates an existing Receivable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Receivable::controllerFind($id);

        if (($post = App::post()) != null) {
            $post['Receivable']['file_tokens'] = $post['Receivable']['file_tokens'] ?? [];

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
     * Deletes an existing Receivable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Receivable::controllerFind($id);

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger($model->errors);
        }

        return $this->redirect($model->indexUrl);
    }


    public function actionReceivePayment($id)
    {
        $model = Receivable::controllerFind($id);
        $model->scenario = Receivable::SCENARIO_RECEIVE_PAYMENT;

        if (App::get('ajaxValidate')) {
            return $this->_ajaxValidate($model);
        }
        
        if ($model->load(App::post()) && $model->save()) {
            return $this->_ajaxCreated($model);
        }

        return $this->_ajaxForm($model);
    }
}