<?php

namespace backend\controllers;

use backend\models\Roles;
use backend\models\SignupForm;
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
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['admin', 'manager', 'user'],
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
		$arrayCountUsers = [];
		if(Yii::$app->user->can('admin')) {
			$arrayCountUsers['allusers'] = Roles::find()->count();
			$arrayCountUsers['admins'] = Roles::find()->where(['item_name' => 'admin'])->count();
			$arrayCountUsers['managers'] = Roles::find()->where(['item_name' => 'manager'])->count();
			$arrayCountUsers['users'] = Roles::find()->where(['item_name' => 'user'])->count();
		}

		$dashboard = new Dashboard();

        return $this->render('index', [
			'users' => $arrayCountUsers,
			'application' => $dashboard->getCountApplication(),
			'countOrgs' => $dashboard->getCountOrg(),
		]);
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
			return $this->goBack();
		}

		$model->password = '';

		return $this->render('login', [
			'model' => $model,
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

	/**
	 * Signs user up.
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
}
