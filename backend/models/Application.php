<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Application".
 *
 * @property int $id
 * @property string $theme
 * @property string $description
 * @property int $organization_id
 * @property int $user_id
 * @property int $status_id
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
            [['theme', 'description', 'organization_id', 'user_id', 'status_id'], 'required'],
            [['organization_id', 'user_id', 'status_id'], 'integer'],
            [['theme', 'description'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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

	public function getOrganization()
	{
		return $this->hasOne(Organization::class, ['id' => 'organization_id']);
	}

	public function getAllUsers()
	{
		$user = User::find()->select(['id', 'username'])->all();
		foreach ($user as $item) {
			$users[$item->id] = $item->username;
		}
		return $users;
	}

	public function getAllOrganization()
	{
		$org = Organization::find()->select(['id', 'name'])->all();
		foreach ($org as $item) {
			$orgs[$item->id] = $item->name;
		}
		return $orgs;
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
