<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $contact
 */
class Organization extends ActiveRecord
{
	/**
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getUsers()
	{
		return $this->hasMany(User::class, ['id' => 'userid'])
			->viaTable('orguser', ['orgid' => 'id']);
	}
}