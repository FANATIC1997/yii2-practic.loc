<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Request;

/**
 * This is the model class for table "Application".
 *
 * @property int $id
 * @property string $theme
 * @property string $description
 * @property int $organization_id
 * @property int $user_id
 * @property int $status_id
 * @property int $manager_id
 */
class Application extends \yii\db\ActiveRecord
{

	const STATUS_NEW = 1;
	const STATUS_WORK = 2;
	const STATUS_COMPLETED = 3;
	const STATUS_CLOSED = 4;


    public static function tableName()
    {
        return 'Application';
    }


    public function rules()
    {
        return [
            [['theme', 'description', 'organization_id', 'user_id', 'status_id', 'manager_id'], 'required', 'message' => 'Это поле является обязательным'],
            [['organization_id', 'user_id', 'status_id', 'manager_id'], 'integer'],
            [['theme'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'theme' => 'Тема',
            'description' => 'Описание',
            'status' => 'Статус',
            'organization' => 'Организация',
			'user' => 'Пользователь',
			'manager_id' => 'Менеджер',
			'manager' => 'Менеджер',
			'status_id' => 'Статус',
			'user_id' => 'Пользователь',
			'organization_id' => 'Организация',
        ];
    }

	/**
	 * Связь с таблицей Статусы
	 * @return \yii\db\ActiveQuery
	 */
	public function getStatus()
	{
		return $this->hasOne(Status::class, ['id' => 'status_id']);
	}

	/**
	 * Связь с таблицей юзеры
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	/**
	 * Связь с таблицей юзеры
	 * @return \yii\db\ActiveQuery
	 */
	public function getManager()
	{
		return $this->hasOne(User::class, ['id' => 'manager_id']);
	}

	/**
	 * Связь с таблицей организации
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrganization()
	{
		return $this->hasOne(Organization::class, ['id' => 'organization_id']);
	}

	/**
	 * @param $org_id
	 * @return array|null
	 */
	public function getManagerArray($org_id)
	{
		$org = Organization::findOne($org_id);
		return $org->getManagerArray();
	}

	/**
	 * @return array
	 */
	public function getAllUsers()
	{
		return ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username');
	}

	/**
	 * @return array
	 */
	public function getAllOrganization()
	{
		return ArrayHelper::map(Organization::find()->asArray()->all(), 'id', 'name');
	}

	/**
	 * @return array
	 */
	public function getAllStatus()
	{
		$stat = Status::find()->select(['id', 'name'])->all();
		return ArrayHelper::map($stat, 'id', 'name');
	}

	/**
	 * @param Application $data
	 * @return string
	 */
	public function getColor($data)
	{
		switch ($data->status->id) {
			case self::STATUS_NEW:
				return '<span class="badge badge-primary">' . $data->status->name . '</span>';
			case self::STATUS_WORK:
				return '<span class="badge badge-info">' . $data->status->name . '</span>';
			case self::STATUS_COMPLETED:
				return '<span class="badge badge-success">' . $data->status->name . '</span>';
			case self::STATUS_CLOSED:
				return '<span class="badge badge-danger">' . $data->status->name . '</span>';
			default:
				return '<span class="badge badge-light">' . $data->status->name . '</span>';
		}
	}


	public function setState($query)
	{
		if($query['back'] !== null)
		{
			$this->status_id = self::STATUS_WORK;
		}
		elseif ($query['next'] !== null)
		{
			$this->status_id++;
		}
		else
		{
			$this->status_id++;
		}
		$log = new Log();
		$log->load($query);
		$log->createLog($this);
		return $this->save();
	}

	/**
	 * Применение данных для новой заявки
	 * @return void
	 */
	public function newApplication()
	{
		$organization = new Organization();
		$this->manager_id = $organization->getManagerOrganization($this->organization_id);
		$userId = Yii::$app->user->getId();
		if(!Yii::$app->user->can(User::ADMIN))
		{
			$this->user_id = $userId;
		}
		$this->status_id = Application::STATUS_NEW;
	}
}
