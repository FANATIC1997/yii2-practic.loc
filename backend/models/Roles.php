<?php

namespace backend\models;

use Yii;

class Roles extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'auth_assignment';
	}

	public function getRole()
	{
		return self::find()->where('user_id='.Yii::$app->user->getId())->one();
	}
}