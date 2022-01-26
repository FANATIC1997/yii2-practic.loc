<?php

namespace backend\models;

class Connect extends \yii\db\ActiveRecord
{

	public static function tableName()
	{
		return '{{%orguser}}';
	}

}