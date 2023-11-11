<?php

namespace app\models\form\setting;

use app\helpers\App;

class SystemSettingForm extends SettingForm
{
    const NAME = 'system-settings';
    const ASIA_MANILA = 'Asia/Manila';

    const OFF = 0;
    const ON = 1;

    public $timezone;
    public $pagination;
    public $auto_logout_timer;
    public $theme;
    public $whitelist_ip_only;
    public $enable_visitor;
    public $manager_io_link;
    public $tawk_to_link;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['timezone', 'pagination', 'theme', 'auto_logout_timer', 'manager_io_link'], 'required'],
            [['timezone', 'manager_io_link'], 'string'],
            [['whitelist_ip_only', 'enable_visitor', 'tawk_to_link'], 'safe'],
            [['pagination', 'auto_logout_timer', 'theme', 'whitelist_ip_only', 'enable_visitor'], 'integer'],

            ['pagination', 'in', 'range' => array_keys(App::params('pagination'))],
            ['whitelist_ip_only', 'in', 'range' => array_keys(App::params('whitelist_ip_only'))],
            ['enable_visitor', 'in', 'range' => array_keys(App::params('enable_visitor'))],
            ['theme', 'exist', 'targetClass' => 'app\models\Theme', 'targetAttribute' => 'id'],
            ['timezone', 'in', 'range' => array_keys(App::component('general')->timezoneList())],
        ];
    }

    public function default()
    {
        return [
            'timezone' => [
                'name' => 'timezone',
                'default' => self::ASIA_MANILA,
            ],
            'pagination' => [
                'name' => 'pagination',
                'default' => 25,
            ],
            'auto_logout_timer' => [
                'name' => 'auto_logout_timer',
                'default' => 1440
            ],
            'theme' => [
                'name' => 'theme',
                'default' => 2,
            ],
            'whitelist_ip_only' => [
                'name' => 'whitelist_ip_only',
                'default' => self::OFF,
            ],
            'enable_visitor' => [
                'name' => 'enable_visitor',
                'default' => self::OFF,
            ],
            'manager_io_link' => [
                'name' => 'manager_io_link',
                'default' => 'https://accountitrightaccountingfirm.manager.io/',
            ],
            'tawk_to_link' => [
                'name' => 'tawk_to_link',
                'default' => 'https://embed.tawk.to/654f1d49cec6a912820ed232/1heugkqlg',
            ]
        ];
    }
}