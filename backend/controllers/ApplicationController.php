<?php

namespace backend\controllers;

use backend\models\Application;
use backend\models\ApplicationSearch;
use backend\models\Log;
use backend\models\Organization;
use backend\models\Status;
use backend\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
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
							'actions' => ['work', 'completed'],
							'allow' => true,
							'roles' => ['admin', 'manager'],
						],
						[
							'actions' => ['index', 'view', 'create', 'update', 'delete', 'get-org', 'get-manager-ajax', 'get-manager-rnd'],
							'allow' => true,
							'roles' => ['manager', 'user', 'admin']
						],
						[
							'actions' => ['index', 'view', 'create', 'update', 'get-org', 'get-manager-ajax', 'get-manager-rnd'],
							'allow' => true,
							'roles' => ['user']
						],
						[
							'actions' => ['close'],
							'allow' => true,
							'roles' => ['user', 'admin']
						]
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
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'error' => $this->request->get('error')
        ]);
    }

    /**
     * Displays a single Application model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$log = new Log();

		$query = Log::find()->where(['application_id' => $id]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$logs = $dataProvider;

		$model = $this->findModel($id);
		if ($this->request->isPost) {
			if($model->status_id == 1)
			{
				$this->actionWork($model);
			}
			elseif($model->status_id == 2)
			{
				$this->actionCompleted($model);
			}
			elseif($model->status_id == 3)
			{
				$this->actionClose($model);
			}
			$log->load($this->request->post());
			$log->createLog($model);
		}
        return $this->render('view', [
            'model' => $model,
			'log' => $log,
			'logs' => $logs,
			'error' => $this->request->get('error')
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Application();
		$log = new Log();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if(Yii::$app->user->can('user'))
				{
					if(!isset($model->user_id))
					{
						$model->user_id = Yii::$app->user->getId();
					}
					$organization = new Organization();
					$model->manager_id = $organization->getManagerOrganization($model->organization_id);
					$model->status_id = 1;
				}
				elseif(Yii::$app->user->can('manager'))
				{
					$model->user_id = Yii::$app->user->getId();
					$model->manager_id = $model->user_id;
					$model->status_id = 1;
				}
				if($model->save())
				{
					$log->comment = 'Создание заявки';
					$log->createLog($model);
					return $this->redirect(['view', 'id' => $model->id]);
				}
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
		if(Yii::$app->user->can('user') and $model->status_id == 4)
		{
			return $this->redirect(['view', 'id' => $model->id, 'error' => 'Заявка уже закрыта, ее не возможно изменить']);
		}
		if(Yii::$app->user->can('manager') and $model->user_id != Yii::$app->user->getId())
		{
			return $this->redirect(['view', 'id' => $model->id, 'error' => 'Вы не являетесь создателем данной заявки']);
		}
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

		if(Yii::$app->user->can('manager'))
		{
			if($model->user_id != Yii::$app->user->getId())
			{
				return $this->redirect(['index', 'error' => 'Вы не являетесь создателем данной заявки']);
			}
		}
		if(Yii::$app->user->can('user'))
		{
			return $this->redirect(['index', 'error' => 'Вы не можете удалять заявки']);
		}

		$model->delete();

        return $this->redirect(['index']);
    }

	public function actionGetOrg()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$user_id = $parents[0];
				$user = User::findOne($user_id);
				return ['output' => $user->getOrgArray(), 'selected' => ''];
			}
		}
		return ['output'=>'', 'selected'=>''];

	}

	public function actionGetManagerAjax()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$org_id = empty($parents[0]) ? null : $parents[0] ;
				if(!is_null($org_id)) {
					$org = Organization::findOne($org_id);
					return ['output' => $org->getUsersArray(), 'selected' => ''];
				} else {
					return ['output'=>'', 'selected'=>''];
				}
			} else {
				return ['output'=>'', 'selected'=>''];
			}
		}
		return ['output'=>'', 'selected'=>''];

	}

	public function actionWork($model)
	{
		$app = $model;
		$app->status_id = 2;
		$app->save();
	}

	public function actionCompleted($model)
	{
		$app = $model;
		$app->status_id = 3;
		$app->save();
	}

	public function actionClose($model)
	{
		$app = $model;
		$app->status_id = 4;
		$app->save();
	}

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
