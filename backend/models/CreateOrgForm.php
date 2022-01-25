<?php

namespace backend\models;

use yii\base\Model;

class CreateOrgForm extends Model
{
	public $name;
	public $address;
	public $contact;

	public function rules()
	{
		return [
			['name', 'trim'],
			['name', 'required', 'message' => 'Поле является обязательным'],
			['name', 'unique', 'targetClass' => '\backend\models\Organization', 'message' => 'Такая организация уже есть'],
			['name', 'string', 'min' => 2, 'max' => 255],

			['address', 'trim'],
			['address', 'required', 'message' => 'Поле является обязательным'],
			['address', 'string', 'min' => 2, 'max' => 255],

			['contact', 'trim'],
			['contact', 'required', 'message' => 'Поле является обязательным'],
			['contact', 'string', 'min' => 2, 'max' => 255],
		];
	}

	public function create()
	{
		if (!$this->validate()) {
			return null;
		}

		$org = new Organization();
		$org->name = $this->name;
		$org->address = $this->name;
		$org->contact = $this->name;
		if($org->save())
			return $org;

		return null;
	}

}