<?php

namespace backend\models;

use yii\db\ActiveRecord;

class user extends ActiveRecord
{

	public function getAccess()
	{
		return $this->hasOne(Access::class, ['id' => 'user_id']);
	}

}