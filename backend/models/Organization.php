<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $contact
 *
 * @property Application[] $applications
 * @property Orguser[] $orgusers
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'contact'], 'required'],
            [['name', 'address', 'contact'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'address' => 'Адрес',
            'contact' => 'Контакты',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['organization_id' => 'id']);
    }

    /**
     * Gets query for [[Orgusers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrgusers()
    {
		return $this->hasMany(User::class, ['id' => 'userid'])
			->viaTable('orguser', ['orgid' => 'id']);
    }

	public function findByName($name)
	{
		return static::findOne(['name' => $name]);
	}
}
