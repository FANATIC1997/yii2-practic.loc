<?php

namespace backend\models;

class Roles extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'auth_assignment';
	}
}