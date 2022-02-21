<?php

namespace backend\controllers;

use backend\models\EditOrganizationRuls;
use backend\models\Organization;
use backend\models\SearchOrganization;
use backend\models\User;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OrganizationController implements the CRUD actions for Organization model.
 */
class OrganizationController extends Controller
{
	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'actions' => ['index', 'view', 'create', 'update', 'delete'],
							'allow' => true,
							'roles' => ['admin'],
						],
					],
				],
			]
		);
	}

	/**
	 * Листинг всех организаций.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new SearchOrganization();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Показ одной организации.
	 * @param int $id ID
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Добавление информации об органищации.
	 * @return string|Response
	 */
	public function actionCreate()
	{
		$model = new Organization();

		$user = new User();
		$data = $user->getAllUsers();

		if ($this->request->isPost) {
			if ($model->load($this->request->post())) {
				$model->usersConnect = $this->request->post()['Organization']['usersConnect'];
				if ($model->save()) {
					$model->createConnectUserArray();
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		}

		return $this->render('create', [
			'model' => $model,
			'users' => $data,
		]);
	}

	/**
	 * Изменение информации об организации.
	 * @param int $id ID
	 * @return string|Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModelEdit($id);

		$user = new User();
		$data = $user->getAllUsers();

		$error = null;
		if ($this->request->isPost && $model->load($this->request->post())) {
			$model->usersConnect = $this->request->post()['EditOrganizationRuls']['usersConnect'];
			if (is_null($error = $model->edit())) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
		}

		return $this->render('update', [
			'model' => $model,
			'users' => $data,
			'error' => $error
		]);
	}

	/**
	 * Удаление информации об организации.
	 * @param int $id ID
	 * @return Response
	 * @throws NotFoundHttpException|StaleObjectException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Поиск модели
	 * @param int $id ID
	 * @return Organization the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Organization::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}


	/**
	 * Поиск модели для изменения
	 * @param $id
	 * @return EditOrganizationRuls|null
	 * @throws NotFoundHttpException
	 */
	protected function findModelEdit($id)
	{
		if (($model = EditOrganizationRuls::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
