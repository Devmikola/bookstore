<?php
namespace app\models;

use Yii;

class SignUpForm extends  \yii\base\Model
{
    public $login;
    public $password;
    public $password_confirmation;

    public function scenarios()
    {
        $scenarios = [
            'user_create' => ['phone', 'login', 'password', 'city', 'country', 'password_confirmation', 'invite_id'],
        ];

        return array_merge(parent::scenarios(), $scenarios);
    }

    public function rules()
    {
        return [

            [['login', 'password', 'password_confirmation'], 'required', 'message' => 'Поле "{attribute}" не должно быть пустым.',  'skipOnEmpty' => false, 'skipOnError' => false],
            ['login', 'string', 'min' => 5, 'max' => 20, 'tooShort' => 'Логин должен быть не менее 5 символов.','tooLong' => 'Логин должен быть не более 20 символов.'],
            ['login', 'match', 'pattern' => '/^[a-z0-9]+$/i', 'message' => 'Логин должен содержать только буквы латинского алфавита и цифры от 0 до 9.'],
            ['password', 'string', 'min' => 5, 'max' => 20, 'tooShort' => 'Пароль должен быть не менее 5 символов.','tooLong' => 'Пароль должен быть не более 20 символов.'],
            ['password', 'match', 'pattern' => '/^[a-z0-9]+$/i', 'message' => 'Пароль должен содержать только буквы латинского алфавита и цифры от 0 до 9.'],
            ['password_confirmation', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают." ],

            ['login', function ($attribute){
                if(User::findOne(['login' => $this->$attribute])) {
                    $this->addError($attribute, 'Этот логин уже занят.');
                }
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_confirmation' => 'Подтверждение пароля',
        ];
    }

}