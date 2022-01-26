<?php

namespace backend\controllers;

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
			$result = '';
			if ($model->load(Yii::$app->request->post()) && $edit = $model->edit($id)) {
				$result = 'Данные успешно изменены';
			}
			return $this->render('user', ['user' => $user, 'model' => $model, 'result' => $result, 'edit' => $edit]);
		}
		else return $this->render('site/user');
	}

	public function actionDeleteCon($idUser = false, $idOrg = false)
	{
		if(isset($idUser))
		{

		}
	}

}