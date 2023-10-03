<?php

namespace app\models\form\setting;

class DeveloperForm extends SettingForm
{
    const NAME = 'developer-settings';

    public $css;
    public $js;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['css', 'js',], 'string'],
            [['css', 'js',], 'safe'],
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
        ];
    }
}