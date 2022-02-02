<?php

namespace backend\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "logs_application".
 *
 * @property int $id
 * @property string $comment
 * @property string $description
 * @property int $application_id
 * @property int $user_id
 * @property int $status_id
 * @property int $old_user_id
 */
class Log extends ActiveRecord
{

	public function behaviors()
	{
		return [
			TimestampBehavior::class,
		];
	}

	public static function tableName()
	{
		return 'logs_application';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['comment'], 'required', 'message' => 'Это поле является обязательным'],
			[['comment'], 'string', 'max' => 255],
			[['comment'], 'trim'],
			[['old_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['old_user_id' => 'id']],
			[['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
			[['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'comment' => 'Комментарий',
			'status_id' => 'Статус',
			'user_id' => 'Пользователь',
			'old_user_id' => 'Старый пользователь',
			'application_id' => 'Заявка'
		];
	}

	/**
	 * Gets query for [[Application]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getApplication()
	{
		return $this->hasOne(Application::class, ['id' => 'application_id']);
	}

	/**
	 * Gets query for [[Status]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getStatus()
	{
		return $this->hasOne(Status::class, ['id' => 'status_id']);
	}

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getOldUser()
	{
		return $this->hasOne(User::class, ['id' => 'old_user_id']);
	}
}