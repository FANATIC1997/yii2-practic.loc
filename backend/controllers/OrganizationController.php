<?php

namespace backend\controllers;

use backend\models\EditOrganizationRuls;
use backend\models\Organization;
use backend\models\SearchOrganization;
use backend\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * Lists all Organization models.
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
     * Displays a single Organization model.
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
     * Creates a new Organization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Organization();

		$users = User::find()->select(['id', 'username'])->all();

		foreach ($users as $item) {
			$data[$item->id] = $item->username;
		}

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
				$model->usersConnect = $this->request->post()['Organization']['usersConnect'];
				if($model->save()) {
					$model->createConnectUserArray();
					return $this->redirect(['view', 'id' => $model->id]);
				}
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
			'users' => $data,
        ]);
    }

    /**
     * Updates an existing Organization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelEdit($id);

		$users = User::find()->select(['id', 'username'])->all();

		foreach ($users as $item) {
			$data[$item->id] = $item->username;
		}

		$error = null;
        if ($this->request->isPost && $model->load($this->request->post())) {
			$model->usersConnect = $this->request->post()['EditOrganizationRuls']['usersConnect'];
			if(is_null($error = $model->edit())) {
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
     * Deletes an existing Organization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
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
