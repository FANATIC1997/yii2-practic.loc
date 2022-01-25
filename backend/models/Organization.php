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
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%organization}}';
	}
}