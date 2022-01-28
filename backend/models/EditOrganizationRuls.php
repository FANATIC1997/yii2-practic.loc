<?php

namespace backend\models;

use Yii;

class EditOrganizationRuls extends Organization
{
	public function rules()
	{
		return [

			[['name', 'address', 'contact'], 'required'],
			[['name', 'address', 'contact'], 'string', 'max' => 255],

		];
	}

	public function edit()
	{
		if (!$this->validate()) {
			return 'Не пройдена валидация';
		}

		if ($this->name != $this->oldAttributes['name']) {
			$org = Organization::findByName($this->name);
			if (!is_null($org)) {
				return 'Такое наименование уже занято';
			}
		}

		$this->deleteAllConnectUsers();

		$this->save();
		return null;

	}
}