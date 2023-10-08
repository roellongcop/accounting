<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Payable;
use app\models\search\PayableSearch;

/**
 * PayableController implements the CRUD actions for Payable model.
 */
class PayableController extends Controller 
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Payable::findByKeywords($keywords, ['p.title', 'p.description', 'p.amount'])
        );
    }

    /**
     * Lists all Payable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayableSearch();
        $dataProvider = $searchModel->search(['PayableSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payable model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Payable::controllerFind($id),
        ]);
    }

    /**
     * Creates a new Payable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payable();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Payable model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($id)
    {
        $originalModel = Payable::controllerFind($id);
        $model = new Payable();
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
     * Updates an existing Payable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Payable::controllerFind($id);

        if (($post = App::post()) != null) {
            $post['Payable']['file_tokens'] = $post['Payable']['file_tokens'] ?? [];

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
     * Deletes an existing Payable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Payable::controllerFind($id);

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
        $model = Payable::controllerFind($id);
        $model->scenario = Payable::SCENARIO_RECEIVE_PAYMENT;

        if (App::get('ajaxValidate')) {
            return $this->_ajaxValidate($model);
        }
        
        if ($model->load(App::post()) && $model->save()) {
            return $this->_ajaxCreated($model);
        }

        return $this->_ajaxForm($model);
    }
}