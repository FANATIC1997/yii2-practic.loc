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

		if(empty($this->comment)) {
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
			$this->comment .= ' статус на ' . $model->status->name;
			$mail = Yii::$app->mailer->compose()
				->setFrom(Yii::$app->params['adminEmail'])
				->setTo($model->user->email)
				->setSubject('Изменения в вашей заявки')
				->setTextBody('В вашей заявке на тему "' . $model->theme . '" изменили статус');
			$mail->send();
			//mail($model->user->email, 'Изменения в вашей заявки', 'В вашей заявке на тему "' . $model->theme . '" изменили статус', 'From: '.Yii::$app->params['adminEmail']);
		}
		$this->save();
		$this->comment = null;
	}

	/**
	 * @throws \Exception
	 */
	public function getBackStatus($data)
	{
		if($data->status_id != 1) {
			$log = static::find()->where(['application_id' => $data->application_id])
				->andWhere(['status_id' => $data->status_id - 1])->one();

			$startDate = new DateTime(date('Y-m-d H:m:s', $data->created_at));
			$endDate = new DateTime(date('Y-m-d H:m:s', $log->created_at));

			$interval = $startDate->diff($endDate);

			$str = '<br><span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="Время реагирования">';
			$str .= ($interval->y != 0) ? $interval->format('%y л '): '';
			$str .= ($interval->m != 0) ? $interval->format('%m м '): '';
			$str .= ($interval->d != 0) ? $interval->format('%dдн '): '';
			$str .= ($interval->h != 0) ? $interval->format('%h ч '): '';
			$str .= ($interval->i != 0) ? $interval->format('%i мин '): '';
			$str .= ($interval->s != 0) ? $interval->format('%sс '): '';
			$str .= '</span>';

			return $str;
		} else {
			if($data->comment != 'Создание заявки')
			{
				$log = static::find()->where(['application_id' => $data->application_id])
					->andWhere(['status_id' => 1])->orderBy('id')->one();

				$startDate = new DateTime(date('Y-m-d H:m:s', $data->created_at));
				$endDate = new DateTime(date('Y-m-d H:m:s', $log->created_at));

				$interval = $startDate->diff($endDate);

				$str = '<br><span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="Время реагирования">';
				$str .= ($interval->y != 0) ? $interval->format('%y л '): '';
				$str .= ($interval->m != 0) ? $interval->format('%m м '): '';
				$str .= ($interval->d != 0) ? $interval->format('%dдн '): '';
				$str .= ($interval->h != 0) ? $interval->format('%h ч '): '';
				$str .= ($interval->i != 0) ? $interval->format('%i мин '): '';
				$str .= ($interval->s != 0) ? $interval->format('%sс '): '';
				$str .= '</span>';

				return $str;
			}
		}
		return null;
	}
}