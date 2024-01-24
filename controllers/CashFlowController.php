<?php

namespace app\controllers;

use app\helpers\App;
use app\helpers\Html;
use app\models\CashFlow;
use app\models\search\CashFlowSearch;
use yii\web\ForbiddenHttpException;
use app\models\form\CashflowImportForm;

/**
 * CashFlowController implements the CRUD actions for CashFlow model.
 */
class CashFlowController extends Controller 
{
    public function actionFindByKeywords($keywords = '', $type=CashFlow::TYPE_RECEIVABLE)
    {
        return $this->asJson(
            CashFlow::findByKeywords($keywords, ['cf.name', 'cf.amount', 'u.username'], 10, [
                'type' => $type
            ])
        );
    }

    /**
     * Lists all CashFlow models.
     * @return mixed
     */
    public function actionIndex($type=CashFlow::TYPE_RECEIVABLE)
    {
        $searchModel = new CashFlowSearch();

        if (!$searchModel->isTypeValid($type)) throw new ForbiddenHttpException('invalid type');

        $dataProvider = $searchModel->search(['CashFlowSearch' => App::queryParams()]);
        $dataProvider->query->andWhere(['cf.type' => $type]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIncome()
    {
        $searchModel = new CashFlowSearch([
            'type' => CashFlow::TYPE_RECEIVABLE,
            'searchAction' => ['cash-flow/income']
        ]);
        $dataProvider = $searchModel->search(['CashFlowSearch' => App::queryParams()]);
        $dataProvider->query->income();

        return $this->render('income', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => CashFlow::income()
        ]);
    }

    public function actionExpense()
    {
        $searchModel = new CashFlowSearch([
            'type' => CashFlow::TYPE_PAYABLE,
            'searchAction' => ['cash-flow/expense']
        ]);
        $dataProvider = $searchModel->search(['CashFlowSearch' => App::queryParams()]);
        $dataProvider->query->expense();

        return $this->render('expense', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => CashFlow::expense()
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
    public function actionCreate($type=CashFlow::TYPE_RECEIVABLE)
    {
        $model = new CashFlow([
            'type' => $type,
            'status' => CashFlow::STATUS_COMPLETED
        ]);
        if (!$model->validate('type')) throw new ForbiddenHttpException('invalid type');
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

    public function actionImportIncome($process = 'validate')
    {
        $searchModel = new CashFlowSearch();
        $model = CashflowImportForm::income();

        $post = App::post();
        if ($post) {
            $model->file_token = $post['token'];

            if ($process === 'validate') {

                if ($model->validate()) {
                    return $this->asJson([
                        'status' => 'success',
                        'message' => 'File is valid!',
                    ]);
                }
            }
            else {
                $import = $model->import();
                if ($import) {
                    App::success('File imported successfully');
                    return $this->asJson([
                        'status' => 'success',
                        'message' => 'File imported successfully',
                    ]);
                }
            }

            return $this->asJson([
                'status' => 'failed',
                'message' => Html::errorSummary($model),
            ]);
        }

        return $this->render('import-income', [
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }

    public function actionImportExpense($process = 'validate')
    {
        $searchModel = new CashFlowSearch();
        $model = CashflowImportForm::expense();

        $post = App::post();
        if ($post) {
            $model->file_token = $post['token'];

            if ($process === 'validate') {

                if ($model->validate()) {
                    return $this->asJson([
                        'status' => 'success',
                        'message' => 'File is valid!',
                    ]);
                }
            }
            else {
                $import = $model->import();
                if ($import) {
                    App::success('File imported successfully');
                    return $this->asJson([
                        'status' => 'success',
                        'message' => 'File imported successfully',
                    ]);
                }
            }

            return $this->asJson([
                'status' => 'failed',
                'message' => Html::errorSummary($model),
            ]);
        }

        return $this->render('import-expense', [
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }
}