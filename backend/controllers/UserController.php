<?php

namespace backend\controllers;

use backend\models\User;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{
	public function actionDelete($id = false)
	{
		if (isset($id)) {
			if (User::deleteAll(['in', 'id', $id])) {
				$this->redirect(['site/users']);
			}
		} else {
			$this->redirect(['site/users']);
		}
	}

	public function actionView($id = false)
	{
		if(isset($id))
		{
			return $this->render('index', ['user' => User::findOne(Yii::$app->user->getId())]);
		}
		else return $this->render('site/user');
	}
}