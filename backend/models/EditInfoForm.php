<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class EditInfoForm extends Model
{
	public $username;
	public $email;
	public $password;

	public function rules()
	{
		return [

			['username', 'trim'],
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой псевдоним занят.'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['email', 'trim'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой email занят.'],

			['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
		];
	}

	/**
	 * @throws \yii\db\StaleObjectException
	 * @throws \yii\db\Exception
	 * @throws \yii\base\Exception
	 */
	public function edit()
	{
		if (!$this->validate()) {
			return null;
		}

		$user = new User();

		$idUser = Yii::$app->user->getId();

		if(!empty($this->username))
			Yii::$app->db->createCommand()->update('user', ['username' => $this->username], 'id = '.$idUser)->execute();

		if(!empty($this->email))
			Yii::$app->db->createCommand()->update('user', ['email' => $this->email], 'id = '.$idUser)->execute();

		if(!empty($this->password)) {
			$newpass = Yii::$app->security->generatePasswordHash($this->password);
			Yii::$app->db->createCommand()->update('user', ['password_hash' => $newpass], 'id = '.$idUser)->execute();
		}

		return null;
	}
}