<?php

namespace app\models\form;

use app\models\User;

class SetNewPasswordForm extends \yii\base\Model
{
    public $prt;
    public $password;
    public $password_repeat;

    private $_user;

    public function rules()
    {
        return [
            [['password', 'password_repeat', 'prt'], 'required'],
            [['password', 'password_repeat', 'prt'], 'string', 'min' => 6],
            [['password', 'password_repeat', 'prt'], 'trim'],
            ['prt', 'exist', 'targetClass' => 'app\models\User', 'targetAttribute' => 'password_reset_token'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function setNewPassword()
    {
        if ($this->validate()) {
            if (($user = $this->getUser()) != null) {
                $user->setPassword($this->password);
                $user->generatePasswordResetToken();
                if ($user->save()) {
                    return $user;
                }
                else {
                    $this->addError('user', $user->errors);
                }
            }

            $this->addError('user', 'User not found');
        }
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()
                ->where(['password_reset_token' => $this->prt])
                ->one();
        }

        return $this->_user;
    }
}