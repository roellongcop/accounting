<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Backup;
use app\models\File;
use app\models\Ip;
use app\models\Log;
use app\models\Notification;
use app\models\Queue;
use app\models\Role;
use app\models\Session;
use app\models\Setting;
use app\models\Theme;
use app\models\User;
use app\models\UserMeta;
use app\models\VisitLog;
use app\models\Visitor;
use app\models\AccountingReport;
use app\models\BirFilling;
use app\models\CashFlow;
use app\models\Inventory;
use app\models\Kpi;
use app\models\LegalDocument;
use app\models\Payroll;
use app\models\search\DashboardSearch;
use yii\db\Expression;
use yii\helpers\Inflector;

class DashboardController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        $identity = App::identity();

        $data = array_merge(
            ($identity->can('index', 'file') ? File::findByKeywords($keywords, ['name', 'extension', 'token']): []),
            ($identity->can('index', 'backup') ? Backup::findByKeywords($keywords, ['filename', 'tables', 'description']): []),
            ($identity->can('index', 'ip') ? Ip::findByKeywords($keywords, ['name', 'description']): []),
            ($identity->can('index', 'log') ? Log::findByKeywords($keywords, ['method', 'action', 'controller', 'table_name', 'model_name']): []),
            ($identity->can('index', 'notification') ? Notification::findByKeywords($keywords, ['message']): []),
            ($identity->can('index', 'queue') ? Queue::findByKeywords($keywords, ['channel', 'job', 'pushed_at']): []),
            ($identity->can('index', 'role') ? Role::findByKeywords($keywords, ['name']): []),
            ($identity->can('index', 'session') ? Session::findByKeywords($keywords, ['id', 'expire', 'ip', 'browser', 'os', 'device']): []),
            ($identity->can('index', 'setting') ? Setting::findByKeywords($keywords, ['name', 'value']): []),
            ($identity->can('index', 'theme') ? Theme::findByKeywords($keywords, ['name', 'description']): []),
            ($identity->can('index', 'user') ? User::findByKeywords($keywords, ['u.username', 'u.email']): []),
            ($identity->can('index', 'user-meta') ? UserMeta::findByKeywords($keywords, ['um.name', 'um.value']): []),
            ($identity->can('index', 'visit-log') ? VisitLog::findByKeywords($keywords, ['v.ip']): []),
            ($identity->can('index', 'visitor') ? Visitor::findByKeywords($keywords, ['expire', 'cookie', 'ip', 'browser', 'os', 'device', 'location']): []),

            ($identity->can('index', 'accounting-report') ? AccountingReport::findByKeywords($keywords, ['ar.name', 'ar.description']): []),
            ($identity->can('index', 'bir-filling') ? BirFilling::findByKeywords($keywords, ['bf.name', 'bf.description']): []),
            ($identity->can('index', 'cash-flow') ? CashFlow::findByKeywords($keywords, ['cf.name', 'cf.description']): []),
            ($identity->can('index', 'inventory') ? Inventory::findByKeywords($keywords, ['i.name', 'i.description']): []),
            ($identity->can('index', 'kpi') ? Kpi::findByKeywords($keywords, ['kpi.name', 'kpi.description']): []),
            ($identity->can('index', 'legal-document') ? LegalDocument::findByKeywords($keywords, ['ld.name', 'ld.description']): []),
            ($identity->can('index', 'payroll') ? Payroll::findByKeywords($keywords, ['p.name', 'p.description']): []),
        );

        $data = array_unique($data);
        $data = array_values($data);
        sort($data);

        return $this->asJson($data);
    }

    public function actionIndex()
    {
        $searchModel = new DashboardSearch();
        App::access()->setSearchModels();

        $cashFlow = new CashFlow();

        if (($queryParams = App::queryParams()) != null) {
            $dataProviders = $searchModel->search(['DashboardSearch' => $queryParams]);

            if ($searchModel->keywords) {
                return $this->render('search_result', [
                    'dataProviders' => $dataProviders,
                    'searchModel' => $searchModel,
                ]);
            } else {
                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'cashFlow' => $cashFlow,
        ]);
    }

    public function actionFilterCashFlow()
    {
        if (($post = App::post()) !== []) {

            list($startDate, $endDate) = explode(' - ', $post['dateRange']);

            // Determine the range type
            $diff = strtotime($endDate) - strtotime($startDate);
            $daysDiff = round($diff / (60 * 60 * 24));
            $rangeType = $daysDiff > 365 ? 'year' : ($daysDiff > 31 ? 'month' : 'day');

            $baseSelect = [
                'income' => new Expression('SUM(CASE WHEN type = 1 THEN amount ELSE 0 END)'),
                'expenses' => new Expression('SUM(CASE WHEN type = 0 THEN amount ELSE 0 END)')
            ];

            $labelConfigurations = [
                'day' => [
                    'label' => new Expression('CONCAT(MONTH(date), "/", DAY(date))'),
                    'groupBy' => new Expression('DATE(date)')
                ],
                'month' => [
                    'label' => new Expression('MONTH(date)'),
                    'groupBy' => new Expression('MONTH(date), YEAR(date)')
                ],
                'year' => [
                    'label' => new Expression('YEAR(date)'),
                    'groupBy' => new Expression('YEAR(date)')
                ]
            ];

            $query = CashFlow::find();
            if (isset($labelConfigurations[$rangeType])) {
                $config = $labelConfigurations[$rangeType];
                $query->select(array_merge($baseSelect, ['label' => $config['label']]))
                    ->groupBy($config['groupBy']);
            }

            $query->where(['between', 'date', $startDate, $endDate])
                ->andWhere(['user_id' => ($post['userId'] ?? App::identity('id'))])
                ->orderBy(['date' => SORT_ASC]);

            $data = $query->asArray()->all();

            // Convert month number to month name if range type is month
            if ($rangeType == 'month') {
                foreach ($data as &$row) {
                    $row['label'] = date('F', mktime(0, 0, 0, $row['label'], 10));
                }
            }

            return $this->asJson([
                'status' => 'success',
                'message' => 'found',
                'data' => $data
            ]);
        }

        return $this->asJson([
            'status' => 'failed',
            'message' => 'No filter found'
        ]);
    }
}