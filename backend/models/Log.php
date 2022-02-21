<?php

namespace backend\models;

use Cassandra\Date;
use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "logs_application".
 *
 * @property int $id
 * @property string $comment
 * @property int $application_id
 * @property int $user_id
 * @property int $status_id
 * @property int $old_user_id
 * @property int $old_manager_id
 * @property TimestampBehavior $create_time
 * @property TimestampBehavior $update_time
 */
class Log extends ActiveRecord
{

	const YEAR_SEC = 31556926;
	const MONTH_SEC = 2629743;
	const DAY_SEC = 86400;
	const HOUR_SEC = 3600;
	const MINUTE_SEC = 60;

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
			[['old_manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['old_manager_id' => 'id']],
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
			'user_id' => 'Кто',
			'old_user_id' => 'Старый пользователь',
			'old_manager_id' => 'Старый менеджер',
			'application_id' => 'Заявка',
			'create_time' => 'Когда',
			'update_time' => 'Время обновления',
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

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getOldManager()
	{
		return $this->hasOne(User::class, ['id' => 'old_manager_id']);
	}

	/**
	 * Создание нового лога
	 * @param $model
	 * @return void
	 */
	public function createLog($model)
	{
		$userId = Yii::$app->user->getId();
		$this->status_id = $model->status_id;
		$this->user_id = $userId;
		$this->application_id = $model->id;

		$action = explode('/', Yii::$app->controller->route)[1];
		if($this->status_id == Application::STATUS_NEW and $action != 'update')
		{
			$this->comment = 'Создание заявки';
		}

		if (empty($this->comment)) {
			$this->comment = 'Изменил: ';
			if ($model->theme != $model->getOldAttribute('theme')) {
				$this->comment .= 'тему';
			}
			if ($model->description != $model->getOldAttribute('description')) {
				$this->comment .= 'описание';
			}
			if ($model->user_id != $model->getOldAttribute('user_id')) {
				$this->comment .= 'пользователя на ' . $model->user->username;
				$this->old_user_id = $model->getOldAttribute('user_id');
			}
			if ($model->manager_id != $model->getOldAttribute('manager_id')) {
				$this->comment .= 'менеджера на ' . $model->manager->username;
				$this->old_manager_id = $model->getOldAttribute('manager_id');
			}
		}
		if ($model->status_id != $model->getOldAttribute('status_id')) {
			if(!empty($this->comment) and $this->comment != 'Создание заявки')
			{
				$message = new Message();
				$message->application_id = $this->application_id;
				$message->user_id = $userId;
				$message->status_id = $this->status_id;
				$message->message = $this->comment;
				$message->save();
			}
			$this->comment .= ' Новый статус: ' . $model->status->name;
			if($userId != $model->user_id) {
				Yii::$app->mailer->compose()
					->setFrom(Yii::$app->params['adminEmail'])
					->setTo($model->user->email)
					->setSubject('Изменения в вашей заявки')
					->setTextBody('В вашей заявке на тему "' . $model->theme . '" изменили статус')
					->send();
			}
		}
		$this->save();
		$this->comment = null;
	}

	/**
	 * Получение строки со временем реакции
	 * @param $startDate
	 * @param $endDate
	 * @return string
	 */
	private function getStrTime($startDate, $endDate)
	{

		$interval = $startDate->diff($endDate);



		$str = '<br><span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="Время реагирования">';
		$str .= ($interval->y != 0) ? $interval->y.' л ' : '';
		$str .= ($interval->m != 0) ? $interval->m.' м ' : '';
		$str .= ($interval->d != 0) ? $interval->d.' дн ' : '';
		$str .= ($interval->h != 0) ? $interval->h.' ч ' : '';
		$str .= ($interval->i != 0) ? $interval->i.' мин ' : '';
		$str .= ($interval->s != 0) ? $interval->s.'с' : '';

		$str .= '</span>';

		return $str;
	}


	/**
	 * Получение предыдущего статуса
	 * @param $data
	 * @return string|null
	 * @throws \Exception
	 */
	public function getBackStatus($data)
	{
		if ($data->status_id != 1) {
			$log = static::find()->where(['application_id' => $data->application_id])
				->andWhere(['status_id' => $data->status_id - 1])->one();

			$startDate = new DateTime($data->create_time);
			$endDate = new DateTime($log->create_time);

			return self::getStrTime($startDate, $endDate);
		}
		return null;
	}

	/**
	 * Листинг лога
	 * @param $id
	 * @return ActiveDataProvider
	 */
	public function getLog($id)
	{
		$query = Log::find()->where(['application_id' => $id])
			->andWhere(['old_user_id' => null])
			->andWhere(['old_manager_id' => null]);
		return new ActiveDataProvider([
			'query' => $query,
		]);
	}

	/**
	 * Листинг лога по юзеру
	 * @param $id
	 * @return array|ActiveRecord[]
	 */
	public function getLogUser($id)
	{
		return Log::find()->where(['application_id' => $id])
			->with('oldUser')
			->with('oldManager')
			->andWhere(['!=', 'old_user_id', ' '])
			->orWhere(['!=' ,'old_manager_id', ' '])
			->orderBy('create_time')->all();
	}
}