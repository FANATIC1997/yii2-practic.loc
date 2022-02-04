<?php

namespace backend\models;

use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "logs_application".
 *
 * @property int $id
 * @property string $comment
 * @property int $application_id
 * @property int $user_id
 * @property int $status_id
 * @property int $old_user_id
 * @property int $created_at
 * @property int $updated_at
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
			'user_id' => 'Кто',
			'old_user_id' => 'Старый пользователь',
			'application_id' => 'Заявка',
			'created_at' => 'Когда',
			'updated_at' => 'Время обновления',
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

	public function createLog($model)
	{

		$this->status_id = $model->status_id;
		$this->user_id = Yii::$app->user->getId();
		$this->application_id = $model->id;

		if (empty($this->comment)) {
			$this->comment = 'Изменил: ';
			if ($model->user_id != $model->getOldAttribute('user_id')) {
				$this->old_user_id = $model->getOldAttribute('user_id');
			}
			if ($model->theme != $model->getOldAttribute('theme')) {
				$this->comment .= 'тему';
			}
			if ($model->description != $model->getOldAttribute('description')) {
				$this->comment .= 'описание';
			}
			if ($model->user_id != $model->getOldAttribute('user_id')) {
				$this->comment .= 'пользователя на ' . $model->user->username;
			}
			if ($model->manager_id != $model->getOldAttribute('manager_id')) {
				$this->comment .= 'менеджера на ' . $model->manager->username;
			}
		}
		if ($model->status_id != $model->getOldAttribute('status_id')) {
			$this->comment .= ' Новый статус: ' . $model->status->name;
			if(Yii::$app->user->getId() != $model->user_id) {
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

	private function getStrTime($startDate, $endDate)
	{
		$diff = $startDate - $endDate;

		$second = $diff;

		$years = floor($diff / self::YEAR_SEC);

		$month = floor($diff / self::MONTH_SEC);

		$days = floor($diff / self::DAY_SEC);

		$hours = floor($diff / self::HOUR_SEC);

		$minutes = floor($diff / self::MINUTE_SEC);

		$str = '<br><span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="Время реагирования">';

		$str .= ($years != 0) ? $years . ' л ' : '';
		$str .= ($month != 0) ? $month - ($years * 12) . ' м ' : '';
		$str .= ($days != 0) ? $days - ($month * 30) . ' дн ' : '';
		$str .= ($hours != 0) ? $hours - ($days * 24) . ' ч ' : '';
		$str .= ($minutes != 0) ? $minutes - ($hours * 60) . ' мин ' : '';
		$str .= ($second != 0) ? $second - ($minutes * 60) . 'с ' : '';


		$str .= '</span>';

		return $str;
	}

	/**
	 * @throws \Exception
	 */
	public function getBackStatus($data)
	{
		if ($data->status_id != 1) {
			$log = static::find()->where(['application_id' => $data->application_id])
				->andWhere(['status_id' => $data->status_id - 1])->one();

			$startDate = $data->created_at;
			$endDate = $log->created_at;

			return self::getStrTime($startDate, $endDate);
		}
		return null;
	}
}