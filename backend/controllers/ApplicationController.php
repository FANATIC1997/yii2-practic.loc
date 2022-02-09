<?php

namespace backend\controllers;

use backend\models\Application;
use backend\models\ApplicationSearch;
use backend\models\Log;
use backend\models\Message;
use backend\models\Organization;
use backend\models\Roles;
use backend\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class ApplicationController extends Controller
{

	/**
	 * @return array
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
							'actions' => ['index', 'view', 'create', 'update', 'get-org', 'get-manager-ajax', 'get-manager-rnd', 'message-create', 'message-update'],
							'allow' => true,
							'roles' => ['manager', 'user', 'admin']
						],
						[
							'actions' => ['delete'],
							'allow' => true,
							'roles' => ['manager', 'admin']
						],
					],
				],
			]
		);
	}


	/**
	 * Показ главной страницы
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new ApplicationSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);
		$log = new Log();
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'error' => $this->request->get('error'),
			'log' => $log
		]);
	}


	/**
	 * Показ детальной страницы заявки а так же
	 * принятие запроса на изменение статуса заявки
	 * @param Application $id
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionView($id)
	{
		$log = new Log();
		$message = new Message();
		$messages = $message->getMessage($id);
		$logs = $log->getLog($id);
		$logsUser = $log->getLogUser($id);
		$model = $this->findModel($id);
		if ($this->request->isPost) {
			$model->setState($this->request->post());
		}
		return $this->render('view', [
			'model' => $model,
			'log' => $log,
			'messages' => $messages,
			'message' => $message,
			'logs' => $logs,
			'logsUser' => $logsUser,
			'error' => $this->request->get('error')
		]);
	}


	/**
	 * Создание новой заявки
	 * @return string|Response
	 */
	public function actionCreate()
	{
		$model = new Application();
		$log = new Log();
		if ($this->request->isPost) {
			if ($model->load($this->request->post())) {
				$model->newApplication();
				if ($model->save()) {
					$log->createLog($model);
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Изменение данных о заявке
	 * @param Application $id
	 * @return string|Response
	 * @throws NotFoundHttpException
	 */
	public function actionUpdate($id)
	{
		$role = new Roles();
		$access = $role->getRole();
		$model = $this->findModel($id);
		if ($access['item_name'] == User::USER and $model->status_id == Application::STATUS_CLOSED) {
			return $this->redirect(['view', 'id' => $model->id, 'error' => 'Заявка уже закрыта, ее не возможно изменить']);
		} elseif ($access['item_name'] == User::MANAGER and $access['user_id'] != $model->user_id) {
			return $this->redirect(['view', 'id' => $model->id, 'error' => 'Вы не являетесь создателем данной заявки']);
		}
		if ($this->request->isPost && $model->load($this->request->post())) {
			$log = new Log();
			$log->createLog($model);
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		}
		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Удаление заявки
	 * @param Application $id
	 * @return Response
	 * @throws NotFoundHttpException
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$role = new Roles();
		$access = $role->getRole();
		if ($access['item_name'] == User::ADMIN) {
			$model->delete();
		} elseif ($access['item_name'] == User::MANAGER) {
			if ($model->user_id != $access['user_id']) {
				return $this->redirect(['index', 'error' => 'Вы не являетесь создателем данной заявки']);
			}
		} elseif ($access['item_name'] == User::USER) {
			return $this->redirect(['index', 'error' => 'Вы не можете удалять заявки']);
		}
		return $this->redirect(['index']);
	}

	/**
	 * @return array|string[]
	 */
	public function actionGetOrg()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$user_id = $parents[0];
				$user = User::findOne($user_id);
				return ['output' => $user->getOrgArray(), 'selected' => ''];
			}
		}
		return ['output' => '', 'selected' => ''];

	}

	/**
	 * Получение менеджеров аяксом
	 * @return array|string[]
	 */
	public function actionGetManagerAjax()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$org_id = empty($parents[0]) ? null : $parents[0];
				if (!is_null($org_id)) {
					$org = Organization::findOne($org_id);
					return ['output' => $org->getUsersArray(), 'selected' => ''];
				}
			}
		}
		return ['output' => '', 'selected' => ''];
	}

	/**
	 * Создание нового сообщения аявксом
	 * @return string
	 */
	public function actionMessageCreate()
	{
		$model = new Message();
		if ($this->request->isPost && $model->load($this->request->post())) {
			\Yii::$app->response->format = Response::FORMAT_JSON;
			$result = $model->newMessage();
			return $this->renderAjax('message', $result);
		}
		return false;
	}

	/**
	 * Создание нового сообщения аявксом
	 * @return string
	 */
	public function actionMessageUpdate()
	{
		if ($this->request->isPost) {
			if(isset($this->request->post()['Message']['id'])) {
				$idMessage = $this->request->post()['Message']['id'];
				$model = $this->findMessage($idMessage);
				if ($model->load($this->request->post())) {
					\Yii::$app->response->format = Response::FORMAT_JSON;
					$result = $model->updateMessage();
					return $this->renderAjax('message', $result);
				}
			}
		}
		return false;
	}

	/**
	 * Поиск модели
	 * @param Application $id
	 * @return Application|null
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id)
	{
		if (($model = Application::findOne(['id' => $id])) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}

	/**
	 * Поиск модели
	 * @param Message $id
	 * @return Message|null
	 * @throws NotFoundHttpException
	 */
	protected function findMessage($id)
	{
		if (($model = Message::findOne(['id' => $id])) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
