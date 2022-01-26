<?php

namespace backend\controllers;

use backend\models\Application;
use backend\models\CreateOrgForm;
use backend\models\CreateUserForm;
use backend\models\EditInfoForm;
use backend\models\Organization;
use backend\models\user;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'logout'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'users', 'organization', 'cabinet', 'application'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		return $this->render('index');
    }

	public function actionUsers()
	{
		$users = user::find()->all();
		$model = new CreateUserForm();
		$result = '';
		$user = null;
		if ($model->load(Yii::$app->request->post()) && $user = $model->create()) {
			$result = 'Пользователь успешно создан';
			$model->username = '';
			$model->email = '';
			$model->password = '';
			$model->role = '';
		}
		return $this->render('users', ['users' => $users, 'result' => $result, 'model' => $model, 'user' => $user]);
	}

	public function actionOrganization()
	{
		$organizations = Organization::find()->all();
		$model = new CreateOrgForm();
		$result = '';
		$org = null;
		if ($model->load(Yii::$app->request->post()) && $org = $model->create()) {
			if(!is_null($org))
				$result = 'Организация успешно записана';

			$model->name = '';
			$model->address = '';
			$model->contact = '';
		}
		return $this->render('organization', ['organizations' => $organizations, 'model' => $model, 'result' => $result, 'org' => $org]);
	}

	public function actionCabinet()
	{
		$model = new EditInfoForm();
		$result = '';
		if ($model->load(Yii::$app->request->post()) && $model->edit()) {
			$result = 'Ваши данные успешно изменены';
			$model->username = '';
			$model->email = '';
			$model->password = '';
		}
		return $this->render('cabinet', ['model' => $model, 'result' => $result]);
	}

	public function actionApplication()
	{
		$applications = Application::find()->orderBy(['status_id' => SORT_ASC])->all();
		return $this->render('application', ['applications' => $applications]);
	}

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
			return $this->goHome();


        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			if(Yii::$app->user->can('admin'))
            	return $this->goBack();
			else {
				$error = 'Вы не являетесь администратором';
				Yii::$app->user->logout();
			}
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
			'error' => $error
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
