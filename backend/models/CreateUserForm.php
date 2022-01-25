<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class CreateUserForm extends Model
{
	public $username;
	public $email;
	public $password;
	public $role;

	public function rules()
	{
		return [

			['username', 'trim'],
			['username', 'required', 'message' => 'Поле является обязательным'],
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой псевдоним занят.'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['email', 'trim'],
			['email', 'required', 'message' => 'Поле является обязательным'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой email занят.'],

			['password', 'required', 'message' => 'Поле является обязательным'],
			['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

			['role', 'required', 'message' => 'Поле является обязательным.'],
		];
	}

	public function create()
	{
		if (!$this->validate()) {
			return null;
		}


		$rolestr = null;
		switch ($this->role) {
			case 1:
				$rolestr = 'admin';
				break;
			case 2:
				$rolestr = 'manager';
				break;
			case 3:
				$rolestr = 'user';
				break;
		}

		$user = new User();
		$user->username = $this->username;
		$user->email = $this->email;
		$user->setPassword($this->password);
		$user->generateAuthKey();
		$user->generateEmailVerificationToken();

		if($user->save()){
			$auth = Yii::$app->authManager;
			$role = $auth->getRole($rolestr);
			$auth->assign($role, $user->id);

			return $user;
		}

		return null;
	}
}