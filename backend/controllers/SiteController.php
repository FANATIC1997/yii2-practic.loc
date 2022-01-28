<?php

namespace backend\controllers;

use backend\models\Application;
use backend\models\Roles;
use backend\models\User;
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
		$arrayCountUsers = [];
		$arrayCountApplications = [];
		$arrayCountUsers['allusers'] = Roles::find()->count();
		$arrayCountUsers['admins'] = Roles::find()->where(['item_name'=>'admin'])->count();
		$arrayCountUsers['managers'] = Roles::find()->where(['item_name'=>'manager'])->count();
		$arrayCountUsers['users'] = Roles::find()->where(['item_name'=>'user'])->count();

		$arrayCountApplications['allapplications'] = Application::find()->count();
		$arrayCountApplications['applicationsWork'] = Application::find()->where(['status_id' => 2])->count();
		$arrayCountApplications['applicationsNew'] = Application::find()->where(['status_id' => 1])->count();
		$arrayCountApplications['applicationsComplete'] = Application::find()->where(['status_id' => [3, 4]])->count();

        return $this->render('index', [
			'users' => $arrayCountUsers,
			'applications' => $arrayCountApplications,
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
