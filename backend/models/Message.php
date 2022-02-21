<?php

namespace backend\models;


use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $application_id
 * @property int $user_id
 * @property int $status_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $message
 *
 * @property Application $application
 * @property Status $status
 */
class Message extends ActiveRecord
{
	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'create_time',
				'updatedAtAttribute' => 'update_time',
				'value' => new Expression('NOW()'),
			],
		];
	}

	public static function tableName()
	{
		return 'message';
	}

	public function rules()
	{
		return [
			[['application_id', 'user_id', 'status_id', 'message'], 'required', 'message' => 'Поле является обязательным'],
			[['application_id', 'user_id', 'status_id'], 'integer'],
			[['message'], 'string', 'max' => 255],
			[['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'id']],
			[['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'application_id' => 'Application ID',
			'user_id' => 'User ID',
			'status_id' => 'Status ID',
			'create_time' => 'Создано',
			'update_time' => 'Изменено',
			'message' => 'Сообщение',
		];
	}

	/**
	 * @return ActiveQuery
	 */
	public function getApplication()
	{
		return $this->hasOne(Application::className(), ['id' => 'application_id']);
	}

	/**
	 * @return ActiveQuery
	 */
	public function getStatus()
	{
		return $this->hasOne(Status::className(), ['id' => 'status_id']);
	}

	/**
	 * @return ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @param $id
	 * @return array|ActiveRecord[]
	 */
	public function getMessage($id)
	{
		return self::find()->where(['application_id' => $id])->orderBy('create_time')->all();
	}

	/**
	 * Новое сообщение
	 * @return array|string[]
	 */
	public function newMessage()
	{
		$application = Application::findOne($this->application_id);
		if ($this->save()) {
			$messages = $this->getMessage($application->id);

			if (Yii::$app->user->getId() != $application->user_id) {
				$user = User::findOne($application->user_id);
				Yii::$app->mailer->compose()
					->setFrom(Yii::$app->params['adminEmail'])
					->setTo($user->email)
					->setSubject('По вашему обращению')
					->setTextBody('Вам прислали новое сообщение по вашему обращению')
					->send();
			}
			return ['message' => new Message(), 'messages' => $messages, 'application' => $application];
		}
		return ['success' => 'false'];
	}

	/**
	 * Изменение сообщения
	 * @return array|string[]
	 */
	public function updateMessage()
	{
		$application = Application::findOne($this->application_id);
		if ($this->save()) {
			$messages = $this->getMessage($application->id);

			return ['message' => new Message(), 'messages' => $messages, 'application' => $application];
		}
		return ['success' => 'false'];
	}

	/**
	 * Высчет времени на возможность изменения
	 * сообщения
	 * @param $time
	 * @return bool
	 * @throws \Exception
	 */
	public function isEditMessage($time)
	{
		$nowTime = new DateTime();
		$timeMessage = new DateTime($time);

		$interval = $nowTime->diff($timeMessage);

		if ($interval->h < 8) {
			return true;
		} else {
			return false;
		}
	}
}
