<?php

namespace backend\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class Application extends ActiveRecord
{

	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	public function getStatus()
	{
		return $this->hasOne(Status::class, ['id' => 'status_id']);
	}

	public function getOrg()
	{
		return $this->hasOne(Organization::class, ['id' => 'organization_id']);
	}

}