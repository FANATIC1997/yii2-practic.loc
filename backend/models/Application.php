<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Application';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

	public function getStatus()
	{
		return $this->hasOne(Status::class, ['id' => 'status_id']);
	}

	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	public function getManager()
	{
		return $this->hasOne(User::class, ['id' => 'manager_id']);
	}

	public function getOrganization()
	{
		return $this->hasOne(Organization::class, ['id' => 'organization_id']);
	}

	public function getManagerArray($org_id)
	{
//		$org = Organization::findOne($org_id);
//		return $org->getManagerArray();
	}

	public function getAllUsers()
	{
		return ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username');
	}

	public function getAllOrganization()
	{
		return ArrayHelper::map(Organization::find()->asArray()->all(), 'id', 'name');
	}

	public function getAllStatus()
	{
		$stat = Status::find()->select(['id', 'name'])->all();
		foreach ($stat as $item) {
			$status[$item->id] = $item->name;
		}
		return $status;
	}
}
