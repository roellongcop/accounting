<?php

namespace app\models\form\setting;

class DeveloperForm extends SettingForm
{
    const NAME = 'developer-settings';

    public $css;
    public $js;

    public $viber_code;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['css', 'js', 'viber_code'], 'string'],
            [['css', 'js', 'viber_code'], 'safe'],
        ];
    }

    public function default()
    {
        return [
            'css' => [
                'name' => 'css',
                'default' => ''
            ],
            'js' => [
                'name' => 'js',
                'default' => ''
            ],
            'viber_code' => [
                'name' => 'viber_code',
                'default' => ''
            ],

        ];
    }
}