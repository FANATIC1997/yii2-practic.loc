<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
	public function getOrgs()
	{
		return $this->hasMany(Organization::class, ['id' => 'orgid'])
			->viaTable('orguser', ['userid' => 'id']);
	}

}