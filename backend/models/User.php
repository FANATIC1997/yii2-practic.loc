<?php

namespace backend\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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
class User extends ActiveRecord
{
	const STATUS_DELETED = 0;
	const STATUS_INACTIVE = 9;
	const STATUS_ACTIVE = 10;
	const ADMIN = 'admin';
	const MANAGER = 'manager';
	const USER = 'user';

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
	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::class,
				'value' => new Expression('NOW()'),
			],
		];
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
			['email', 'email', 'message' => 'Не является email`ом'],
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
	 * Свзяь с таблицей [[Application]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getApplications()
	{
		return $this->hasMany(Application::className(), ['user_id' => 'id']);
	}

	/**
	 * Связь с таблицей [[Orgusers]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrgusers()
	{
		return $this->hasMany(Organization::class, ['id' => 'orgid'])
			->viaTable('orguser', ['userid' => 'id']);
	}

	/**
	 * Получение массива организаций связанных
	 * с пользователем в третьем виде
	 * @return array|null
	 */
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

	/**
	 * Получение массива организаций связанных
	 * с пользователем но в другом виде
	 * @return array
	 */
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

	/**
	 * Получение массива организаций связанных
	 * с пользователем
	 * @return array
	 */
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

	public function getAllUsers()
	{
		$user = self::find()->asArray()->all();
		return ArrayHelper::map($user, 'id', 'username');
	}

	/**
	 * Получение роли пользователя в человеко
	 * читабельном виде
	 * @param $str
	 * @return string
	 */
	public function setRoleStr($str = null)
	{
		if (!is_null($str)) $this->role = $str;
		switch ($this->role)
		{
			case self::ADMIN:
				$this->role = 'Администратор';
				return 'Администратор';
			case self::MANAGER:
				$this->role = 'Менеджер';
				return 'Менеджер';
			default:
				$this->role = 'Пользователь';
				return 'Пользователь';
		}

	}

	/**
	 * Получение роли пользователя
	 * @return string
	 */
	public function getAccess()
	{
		$roles = Yii::$app->authManager->getRolesByUser($this->id);
		$access = self::USER;
		if (isset($roles['admin']))
			$access = self::ADMIN;
		if (isset($roles['manager']))
			$access = self::MANAGER;
		return $access;
	}

	/**
	 * Присвоение роли пользователю при регистрации
	 * @return bool
	 * @throws \Exception
	 */
	public function createRoleConnect()
	{
		$auth = Yii::$app->authManager;
		$role = $auth->getRole($this->role);
		$auth->assign($role, $this->id);
		return true;
	}

	/**
	 * Создание новых связей User|Organization
	 * @return void
	 */
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

	/**
	 * Проверка на валидацию телефона
	 * @return void
	 */
	public function validatePhone()
	{
		$phone = mb_substr(trim($this->phone), 2);
		$phone = preg_replace('/[^0-9]/', '', $phone);
		$this->phone = (int) $phone;
	}

	/**
	 * Уаление всех связей User|Organization
	 * @return void
	 */
	public function deleteAllConnectOrg()
	{
		$this->unlinkAll('orgusers', true);
		$this->createConnectOrgArray();
	}

	/**
	 * Получение всех администраторов
	 * @return array
	 */
	public function getAllAdminArray()
	{
		$admins = static::find()->leftJoin('auth_assignment ass', 'ass.user_id=user.id')->where(['item_name' => self::ADMIN])->all();
		return ArrayHelper::map($admins, 'id', 'username');
	}

	/**
	 * Поиск пользователя по username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Поиск пользователя по email
	 * @param $email
	 * @return User|null
	 */
	public static function findByEmail($email)
	{
		return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Получение ID пользователя
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * Проверка на валидацию пароля
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Генерация хеша нового пароля
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	public function getMaxWork()
	{
		$users = User::find()->select(['username', 'COUNT(*)'])
			->leftJoin('auth_assignment ass', 'user.id=ass.user_id')
			->leftJoin('application ap', 'user.id=ap.manager_id')
			->where(['ap.status_id' => Application::STATUS_CLOSED])
			->andWhere(['ass.item_name' => User::MANAGER])
			->groupBy('username')
			->orderBy(['COUNT(*)' => 'DESC'])
			->limit(10)->asArray()->all();
		$result = [];
		foreach ($users as $item)
		{
			$result[] = ['name' => $item['username'], 'y' => (integer)$item['COUNT(*)']];
		}
		return $result;
	}

	public function getStatUsers()
	{
		$result = [];
		$result['data'][] = ['name' => 'Администратор', 'y' => (integer)Roles::find()->where(['item_name' => 'admin'])->count()];
		$result['data'][] = ['name' => 'Менеджер', 'y' => (integer)Roles::find()->where(['item_name' => 'manager'])->count()];
		$result['data'][] = ['name' => 'Пользователь', 'y' => (integer)Roles::find()->where(['item_name' => 'user'])->count()];

		$result['all'] = (integer)Roles::find()->count();

		return $result;
	}
}
