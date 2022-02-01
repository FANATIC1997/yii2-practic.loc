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
	 * Lists all Application models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$model = $this->findModel(Yii::$app->user->getId());
		$model->setRoleStr();
		return $this->render('index', [
			'model' => $model
		]);
	}

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
	 * Finds the Application model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
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