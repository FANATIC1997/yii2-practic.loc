<?php

namespace backend\controllers;

use backend\models\Organization;
use yii\web\Controller;

class OrganizationController extends Controller
{

	public function actionDelete($id = false)
	{
		if (isset($id)) {
			if (Organization::deleteAll(['in', 'id', $id])) {
				$this->redirect(['site/organization']);
			}
		} else {
			$this->redirect(['site/organization']);
		}
	}

}