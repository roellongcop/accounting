<?php

namespace app\filters;

use app\helpers\App;
use app\models\search\IpSearch;
use app\models\Ip;
use yii\web\ForbiddenHttpException;

class IpFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $ip = App::ip();


        if (!App::isControllerAction('site/error')) {
            $blackList = Ip::find()
                ->where([
                    'name' => $ip,
                    'type' => Ip::TYPE_BLACKLIST
                ])
                ->exists();
            if ($blackList) {
                throw new ForbiddenHttpException('IP is Blocked !');
            }

            if (App::setting('system')->whitelist_ip_only) {
                $whiteList = Ip::find()
                    ->where([
                        'name' => $ip,
                        'type' => Ip::TYPE_WHITELIST
                    ])
                    ->exists();

                if (!$whiteList) {
                    throw new ForbiddenHttpException('IP not WhiteListed.');
                }
            }
        }

        $modelIP = Ip::findOne($ip);
        if (!$modelIP) {
            $model = new Ip([
                'record_status' => 1,
                'name' => $ip,
                'type' => Ip::TYPE_WHITELIST,
                'description' => 'IP Session: ' . App::session('id')
            ]);
            $model->save();
        }

        return true;
    }
}