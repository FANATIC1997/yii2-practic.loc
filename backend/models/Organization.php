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
 * @property Application[] $application
 * @property Orguser[] $orgusers
 */
class Organization extends \yii\db\ActiveRecord
{

	public $usersConnect;

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
     * Gets query for [[Application]].
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

	public function getUserOrgsArray()
	{
		$org = $this->orgusers;

		foreach ($org as $item)
		{
			$data[] = $item->id;
		}
		if(!empty($data))
			return $data;
		else
			return null;
	}

	public function getManagerOrganization()
	{
		$users = $this->orgusers;
		$idManager = 0;

		if(!is_null($users)) {
			$min_applications = null;
			foreach ($users as $item) {
				$role = Roles::find()->where(['user_id' => $item->id])->one();
				if ($role->item_name == 'manager') {
					$applications_count = Application::find()->where(['manager_id' => $item->id])->count();
					if (is_null($min_applications)) {
						$min_applications = $applications_count;
						$idManager = $item->id;
					} elseif ($applications_count < $min_applications) {
						$min_applications = $applications_count;
						$idManager = $item->id;
					}
				}
			}
			if ($idManager == 0) {
				$role = Roles::find()->where(['item_name' => 'admin'])->one();
				$idManager = $role->user_id;
			}
		}

		if($idManager > 0)
			return $idManager;
		else
			return null;
	}

	public function getUsersArray()
	{
		$users = $this->orgusers;

		if(!is_null($users)) {
			foreach ($users as $item) {
				$role = Roles::find()->where(['user_id' => $item->id])->one();
				if ($role->item_name == 'manager' or $role->item_name == 'admin') {
					$data[] = ['id' => $item->id, 'name' => $item->username];
				}
			}
		}

		if(!empty($data))
			return $data;
		else
			return '';
	}

	public function deleteAllConnectUsers()
	{
		$this->unlinkAll('orgusers', true);
		$this->createConnectUserArray();
	}

	public function createConnectUserArray()
	{
		if(!empty($this->usersConnect)) {
			foreach ($this->usersConnect as $item) {
				$user = User::findOne($item);
				$this->link('orgusers', $user);
			}
		}
	}

	public function findByName($name)
	{
		return static::findOne(['name' => $name]);
	}
}
