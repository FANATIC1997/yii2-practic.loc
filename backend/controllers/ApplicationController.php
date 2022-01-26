<?php

namespace backend\controllers;

use backend\models\Application;
use yii\web\Controller;

class ApplicationController extends Controller
{

	public function actionDelete($id = false)
	{
		if (isset($id)) {
			if (Application::deleteAll(['in', 'id', $id])) {
				$this->redirect(['site/application']);
			}
		} else {
			$this->redirect(['site/application']);
		}
	}

}