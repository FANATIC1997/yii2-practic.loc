<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class EditInfoForm extends Model
{
	public $username;
	public $email;
	public $password;
	public $role;

	private function getAccess($id): ?string
	{
		$roles = Yii::$app->authManager->getRolesByUser($id);
		$access = 'user';
		if(isset($roles['admin']))
			$access = 'admin';
		if(isset($roles['manager']))
			$access = 'manager';

		return $access;
	}

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

			['role', 'trim']
		];
	}

	/**
	 * @throws \yii\db\StaleObjectException
	 * @throws \yii\db\Exception
	 * @throws \yii\base\Exception
	 */
	public function edit($id = null)
	{
		if (!$this->validate()) {
			return null;
		}


		if(is_null($id))
			$idUser = Yii::$app->user->getId();
		else
			$idUser = $id;

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

		if(!is_null($rolestr)) {
			$auth = Yii::$app->authManager;
			$role = $auth->getRole($this->getAccess($idUser));
			$auth->revoke($role, $idUser);
			$role = $auth->getRole($rolestr);
			$auth->assign($role, $idUser);
		}

		if(!empty($this->username))
			Yii::$app->db->createCommand()->update('user', ['username' => $this->username], 'id = '.$idUser)->execute();

		if(!empty($this->email))
			Yii::$app->db->createCommand()->update('user', ['email' => $this->email], 'id = '.$idUser)->execute();

		if(!empty($this->password)) {
			$newpass = Yii::$app->security->generatePasswordHash($this->password);
			Yii::$app->db->createCommand()->update('user', ['password_hash' => $newpass], 'id = '.$idUser)->execute();
		}

		return Yii::$app->user->identity;
	}
}