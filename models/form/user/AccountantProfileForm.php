<?php

namespace app\models\form\user;

use app\models\File;
use app\helpers\App;

class AccountantProfileForm extends UserForm
{
    const META_NAME = 'accountant-profile';

    public $photo;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $phone_number;
    public $date_of_birth;
    public $gender;
    public $address;
    public $city;
    public $state;
    public $country;
    public $postal_code;
    public $certification; // file
    public $years_of_experience;
    public $current_employer;
    public $job_title;
    public $bio;

    public $linkedIn;

    public $facebook;
    public $instagram;
    public $twitter;

    public $youTube;
    public $vimeo;

    public $reddit;
    public $quora;

    public $medium;
    public $wordPress;

    public $xero;
    public $quickBooks;
    
    public $slack;
    
    public $pinterest;
    
    public $snapchat;
    public $tikTok;
    public $bitrix;
    public $tawkto;


    public $email;
    public $viber;

    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return $this->setRules([
            [['first_name', 'last_name',], 'required'],
            [['email'], 'trim'],
            [['email'], 'email'],
            [[
                'viber',
                'email',
                'first_name',
                'middle_name', 
                'last_name', 
                'phone_number',
                'date_of_birth',
                'gender',
                'address',
                'city',
                'state',
                'country',
                'postal_code',
                'certification',
                'current_employer',
                'job_title',
                'bio',
                'linkedIn',
                'facebook',
                'instagram',
                'twitter',
                'youTube',
                'vimeo',
                'reddit',
                'quora',
                'medium',
                'wordPress',
                'xero',
                'quickBooks',
                'slack',
                'pinterest',
                'snapchat',
                'tikTok',
                'bitrix',
                'tawkto',
                'photo'
            ], 'string'],
            ['years_of_experience', 'integer'],
        ]);
    }

    public function init()
    {
        parent::init();

        if (!$this->email && $this->user) {
            $this->email = $this->user->email;
        }
    }

    public function getFullname()
    {
        return implode(' ', array_filter([
            $this->first_name,
            $this->last_name
        ]));
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    }

    public function getDetailColumns()
    {
        return [
            'first_name:raw',
            'last_name:raw',
        ];
    }

    public function getFile()
    {
        return File::findByToken($this->certification);
    }

    public function save()
    {
        if ($this->validate()) {
            $user = $this->user;
            $user->photo = $this->photo;
            $user->save();
            return parent::save();
        }
    }

    public function getGenderName()
    {
        return App::params('genders')[$this->gender]['label'] ?? '';
    }
}