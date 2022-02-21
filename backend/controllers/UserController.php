<?php

namespace backend\controllers;

use backend\models\EditUserRuls;
use backend\models\Organization;
use backend\models\Roles;
use backend\models\User;
use backend\models\UserSearch;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
	 * Показ всех пользователей
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new UserSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}


	/**
	 * Показ одного пользователя
	 * @param $id
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$model->setRoleStr();
		return $this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * Создание нового пользователя, при успешном выполнении
	 * переход на просмотр его информации
	 * @return string|Response
	 * @throws \Exception
	 */
	public function actionCreate()
	{
		$model = new User();

		$orgs = Organization::find()->select(['id', 'name'])->all();

		foreach ($orgs as $item) {
			$data[$item->id] = $item->name;
		}

		if ($this->request->isPost) {
			if ($model->load($this->request->post())) {
				$model->orgTags = $this->request->post()['User']['orgTags'];
				$model->phone = $this->request->post()['User']['phone'];
				$model->validatePhone();
				$model->setPassword($model->password);
				$model->generateAuthKey();
				if ($model->save()) {
					if ($model->createRoleConnect())
					{
						$model->createConnectOrgArray();
						return $this->redirect(['view', 'id' => $model->id]);
					}
				}
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
			'orgs' => $data
		]);
	}

	/**
	 * Изменение информации о пользователе, при успешном
	 * выполнении переход на просмотр
	 * @param int $id ID
	 * @return string|Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModelEdit($id);

		$orgs = Organization::find()->select(['id', 'name'])->all();

		foreach ($orgs as $item) {
			$data[$item->id] = $item->name;
		}

		$error = null;

		if ($this->request->isPost && $model->load($this->request->post())) {
			$model->orgTags = $this->request->post()['EditUserRuls']['orgTags'];
			$model->phone = $this->request->post()['EditUserRuls']['phone'];
			if(is_null($error = $model->edit())) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
		}

		return $this->render('update', [
			'model' => $model,
			'orgs' => $data,
			'error' => $error
		]);
	}

	/**
	 * Удаление информации о пользователе, при успешном
	 * выполнении переход на листинг
	 * @param int $id ID
	 * @return Response
	 * @throws NotFoundHttpException|StaleObjectException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$role = Roles::find()->where(['user_id' => $id])->one();
		if(!is_null($role))
		{
			$role->delete();
		}

		$this->findModel($id)->delete();
		return $this->redirect(['index']);
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
			$model->role = $model->getAccess();
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	/**
	 * Поиск модели для изменения
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
}
