<?php

namespace backend\controllers;

use backend\models\Application;
use backend\models\Roles;
use backend\models\SignupForm;
use backend\models\User;
use common\models\Dashboard;
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
                        'actions' => ['login', 'error', 'signup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'get-analysis-application'],
                        'allow' => true,
                        'roles' => ['admin', 'manager', 'user'],
                    ],
					[
						'actions' => ['get-max', 'get-stat-users'],
						'allow' => true,
						'roles' => ['admin']
					]
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
	 * Показ главной страницы
	 * @return string
	 */
	public function actionIndex()
    {

		$dashboard = new Dashboard();

        return $this->render('index', [
			'application' => $dashboard->getCountApplication(),
			'countOrgs' => $dashboard->getCountOrg(),
		]);
    }


	/**
	 * Авторизация
	 * @return string|Response
	 */
	public function actionLogin()
    {
		if (!Yii::$app->user->isGuest)
			return $this->goHome();


		$this->layout = 'blank';

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}

		$model->password = '';

		return $this->render('login', [
			'model' => $model,
		]);
    }

    /**
     * Выход из системы
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

	/**
	 * Регистрация пользователя
	 *
	 * @return mixed
	 */
	public function actionSignup()
	{
		$model = new SignupForm();


		if ($model->load(Yii::$app->request->post()) && $model->signup()) {
			Yii::$app->session->setFlash('success', 'Спасибо за регистрацию');
			return $this->goHome();
		}

		$this->layout = 'blank';

		return $this->render('signup', [
			'model' => $model,
		]);
	}

	/**
	 * Получения массива с наибольшим числом выполненых заявок
	 * @return array
	 */
	public function actionGetMax()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$user = new User();
		return $user->getMaxWork();
	}

	/**
	 * Получение массива с анализом заявок
	 * @return array
	 */
	public function actionGetAnalysisApplication()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$applications = new Application();
		return $applications->getAnalysis();
	}

	/**
	 * Получения массива с статистикой пользователей
	 * @return array
	 */
	public function actionGetStatUsers()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$user = new User();
		return $user->getStatUsers();
	}
}
