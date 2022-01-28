<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Application".
 *
 * @property int $id
 * @property string $theme
 * @property string $description
 * @property int $organization_id
 * @property int $user_id
 * @property int $status_id
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['theme', 'description', 'organization_id', 'user_id', 'status_id'], 'required'],
            [['organization_id', 'user_id', 'status_id'], 'integer'],
            [['theme', 'description'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Тема' => 'Theme',
            'Сообщение' => 'Description',
        ];
    }
}
