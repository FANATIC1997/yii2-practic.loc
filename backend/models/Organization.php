<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

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

		foreach ($org as $item) {
			$data[] = $item->id;
		}
		if (!empty($data))
			return $data;
		else
			return null;
	}

	public function getUsersOrg()
	{
		$arrayUsers = User::find()->leftJoin('auth_assignment ass', 'user.id=ass.user_id')
			->joinWith('orgusers')
			->where(['orguser.orgid' => $this->id])
			->andWhere(['!=', 'ass.item_name', User::ADMIN])
			->asArray()->all();

		$data = ArrayHelper::map($arrayUsers, 'id', 'username');

		if (!empty($data))
			return $data;
		else
			return null;
	}

	public function getManagerArray()
	{
		$arrayManager = User::find()->leftJoin('auth_assignment ass', 'user.id=ass.user_id')
			->joinWith('orgusers')->where(['ass.item_name' => 'manager'])
			->andWhere(['orguser.orgid' => $this->id])->asArray()->all();

		$data = ArrayHelper::map($arrayManager, 'id', 'username');

		$user = new User();

		$result = $data + $user->getAllAdminArray();

		if (!empty($result))
			return $result;
		else
			return null;
	}

	public function getManagerOrganization($org_id)
	{
		$result = $this::find()->from('organization org')
			->select(['ass.`user_id`, count(ap.`id`)'])
			->joinWith('orgusers')
			->leftJoin('auth_assignment ass', 'orguser.userid = ass.user_id')
			->leftJoin('application ap', 'ap.manager_id = ass.user_id')
			->where(['org.id' => $org_id])
			->andWhere(['ass.item_name' => 'manager'])
			->groupBy('ass.user_id')
			->orderBy(['ass.user_id' => SORT_DESC])->asArray()->one()['user_id'];
		if(is_null($result))
		{
			$user = new User();
			$allAdmin = $user->getAllAdminArray();
			$result = array_rand($allAdmin)['id'];
		}
		return $result;
	}

	public function getUsersArray()
	{
		$users = $this->orgusers;

		if (!is_null($users)) {
			foreach ($users as $item) {
				$role = Roles::find()->where(['user_id' => $item->id])->one();
				if ($role->item_name == 'manager' or $role->item_name == 'admin') {
					$data[] = ['id' => $item->id, 'name' => $item->username];
				}
			}
		}

		if (!empty($data))
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
		if (!empty($this->usersConnect)) {
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

	public function getAllOrganization()
	{
		$orgs = static::find()->asArray()->all();
		return ArrayHelper::map($orgs, 'id', 'name');
	}
}
