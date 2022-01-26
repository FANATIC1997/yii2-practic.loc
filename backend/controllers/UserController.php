<?php

namespace backend\controllers;

use backend\models\Connect;
use backend\models\EditInfoForm;
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
			return $this->render('index', ['user' => User::findOne($id)]);
		}
		else return $this->render('site/user');
	}

	public function actionEdit($id = false)
	{
		if(isset($id))
		{
			$user = User::findOne($id);
			$model = new EditInfoForm();
			$resultform = '';
			if ($model->load(Yii::$app->request->post()) && $edit = $model->edit($id)) {
				$resultform = 'Данные успешно изменены';
			}
			return $this->render('user', ['user' => $user, 'model' => $model, 'resultform' => $resultform, 'edit' => $edit]);
		}
		else return $this->render('site/user');
	}

	public function actionDeleteCon($userid = false, $orgid = false)
	{
		if(isset($userid) and isset($orgid))
		{
			$con = Connect::findOne(['orgid' => $orgid, 'userid' => $userid]);
			if(!is_null($con))
			{
				$con->delete();
				$result = 'Организация успешно отвязана';
				$user = User::findOne($userid);
				$model = new EditInfoForm();
				if ($model->load(Yii::$app->request->post()) && $edit = $model->edit($userid)) {
					$resultform = '';
				}
				return $this->render('user', ['user' => $user, 'model' => $model, 'result' => $result]);
			}
			else
			{
				return $this->redirect(['site/users']);
			}
		}
	}

}