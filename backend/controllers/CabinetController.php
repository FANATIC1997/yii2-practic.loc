<?php

namespace backend\controllers;

use backend\models\EditUserRuls;
use backend\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CabinetController extends Controller
{
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'actions' => ['index', 'update'],
							'allow' => true,
							'roles' => ['manager' , 'user', 'admin']
						],
					],
				],
			]
		);
	}

	/**
	 * Показ главной страницы со всеми записями
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionIndex()
	{
		$model = $this->findModel(Yii::$app->user->getId());
		$model->setRoleStr();
		return $this->render('index', [
			'model' => $model
		]);
	}

	/**
	 * Изменение личных данных пользователя
	 * @param $id
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModelEdit($id);

		$error = null;

		if ($this->request->isPost && $model->load($this->request->post())) {
			$model->orgTags = $this->request->post()['EditUserRuls']['orgTags'];
			if(is_null($error = $model->edit())) {
				return $this->redirect(['index', 'id' => $model->id]);
			}
		}

		return $this->render('update', [
			'model' => $model,
			'error' => $error
		]);
	}

	/**
	 * Поиск модели для изменения
	 * @param $id
	 * @return EditUserRuls|null
	 * @throws NotFoundHttpException
	 */
	protected function findModelEdit($id)
	{
		if (($model = EditUserRuls::findOne(['id' => $id])) !== null) {
			$model->role = $model->getAccess();
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	/**
	 * Поиск модели
	 * @param int $id ID
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = User::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}