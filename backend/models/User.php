<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $phone
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Application[] $application
 * @property Orguser[] $orgusers
 */
class User extends \yii\db\ActiveRecord
{
	const STATUS_DELETED = 0;
	const STATUS_INACTIVE = 9;
	const STATUS_ACTIVE = 10;

	public $password;
	public $role;
	public $orgTags;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [

			['username', 'trim'],
			['username', 'required', 'message' => 'Поле является обязательным'],
			['username', 'unique', 'targetClass' => '\backend\models\User', 'message' => 'Такой псевдоним занят.'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['phone', 'trim'],
			['phone', 'required', 'message' => 'Поле является обязательным'],
			['phone', 'string', 'min' => 10, 'max' => 18],

			['email', 'trim'],
			['email', 'required', 'message' => 'Поле является обязательным'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\backend\models\User', 'message' => 'Такой email занят.'],

			['password', 'required', 'message' => 'Поле является обязательным'],
			['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

			['role', 'required', 'message' => 'Поле является обязательным.'],

			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => 'Никнейм',
			'phone' => 'Телефон',
			'email' => 'Email',
			'role' => 'Уровень доступа'
		];
	}

	/**
	 * Gets query for [[Application]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getApplications()
	{
		return $this->hasMany(Application::className(), ['user_id' => 'id']);
	}

	/**
	 * Gets query for [[Orgusers]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrgusers()
	{
		return $this->hasMany(Organization::class, ['id' => 'orgid'])
			->viaTable('orguser', ['userid' => 'id']);
	}

	public function getOrgUsersArray()
	{
		$org = $this->orgusers;

		foreach ($org as $item)
		{
			$data[] = $item->id;
		}
		if (!empty($data))
			return $data;
		else
			return null;
	}

	public function getOrgArray()
	{
		$org = $this->orgusers;

		$data = [];

		foreach ($org as $item)
		{
			$data[] = ['id' => $item->id, 'name' => $item->name];
		}

		return $data;
	}

	public function getOrgDropList()
	{
		$org = $this->orgusers;

		$data = [];

		foreach ($org as $item)
		{
			$data[$item->id] = $item->name;
		}

		return $data;
	}

	public function setRoleStr($str = null)
	{
		if (!is_null($str)) $this->role = $str;
		switch ($this->role)
		{
			case 'admin':
				$this->role = 'Администратор';
				return 'Администратор';
			case 'manager':
				$this->role = 'Менеджер';
				return 'Менеджер';
			default:
				$this->role = 'Пользователь';
				return 'Пользователь';
		}

	}

	public function getAccess()
	{
		$roles = Yii::$app->authManager->getRolesByUser($this->id);
		$access = 'user';
		if (isset($roles['admin']))
			$access = 'admin';
		if (isset($roles['manager']))
			$access = 'manager';
		return $access;
	}

	public function createRoleConnect()
	{
		$auth = Yii::$app->authManager;
		$role = $auth->getRole($this->role);
		$auth->assign($role, $this->id);
		return true;
	}

	public function createConnectOrgArray()
	{
		if (!empty($this->orgTags))
		{
			foreach ($this->orgTags as $item)
			{
				$org = Organization::findOne($item);
				$this->link('orgusers', $org);
			}
		}
	}

	public function validatePhone()
	{
		$phone = mb_substr(trim($this->phone), 2);
		$phone = preg_replace('/[^0-9]/', '', $phone);
		$this->phone = (int) $phone;
	}

	public function deleteAllConnectOrg()
	{
		$this->unlinkAll('orgusers', true);
		$this->createConnectOrgArray();
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * {@inheritdoc}
	 * @throws NotSupportedException
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	public static function findByEmail($email)
	{
		return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token))
		{
			return null;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds user by verification email token
	 *
	 * @param string $token verify email token
	 * @return static|null
	 */
	public static function findByVerificationToken($token)
	{
		return static::findOne([
			'verification_token' => $token,
			'status' => self::STATUS_INACTIVE
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token))
		{
			return false;
		}

		$timestamp = (int)substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Generates new token for email verification
	 */
	public function generateEmailVerificationToken()
	{
		$this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

}
