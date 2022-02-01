<?php

namespace backend\models;

use Yii;

class EditUserRuls extends User
{

	public function rules()
	{
		return [

			['username', 'trim'],
			['username', 'required', 'message' => 'Поле является обязательным'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['email', 'trim'],
			['email', 'required', 'message' => 'Поле является обязательным'],
			['email', 'email'],
			['email', 'string', 'max' => 255],

			['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

			['role', 'required', 'message' => 'Поле является обязательным.'],
		];
	}

	public function edit()
	{
		if (!$this->validate()) {
			return 'Не пройдена валидация';
		}

		if ($this->username != $this->oldAttributes['username']) {
			$user = User::findByUsername($this->username);
			if (!is_null($user)) {
				return 'Такой никнейм уже занят';
			}
		}
		if ($this->email != $this->oldAttributes['email']) {
			$user = User::findByEmail($this->email);
			if (!is_null($user)) {
				return 'Такой email уже занят';
			}
		}

		if(!empty($this->password))
		{
			$this->setPassword($this->password);
		}

		$this->deleteAllConnectOrg();

		$this->save();
		return null;

	}
}