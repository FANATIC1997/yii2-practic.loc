<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
	public $phone;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Данное поле является обязательным'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой логин уже занят'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Данное поле является обязательным'],
            ['email', 'email', 'message' => 'Не является email`om'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой email уже занят'],

			['phone', 'trim'],
			['phone', 'required', 'message' => 'Поле является обязательным'],
			['phone', 'string', 'min' => 10, 'max' => 18],

            ['password', 'required', 'message' => 'Данное поле является обязательным'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
		$user->phone = $this->phone;
		$user->validatePhone();
        $user->generateAuthKey();
		$user->save(false);

		$auth = Yii::$app->authManager;
		$authorRole = $auth->getRole('user');
		$auth->assign($authorRole, $user->getId());


		return $user;
    }

}
