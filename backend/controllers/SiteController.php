<?php

namespace backend\controllers;

use backend\models\CreateUserForm;
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

		return $this->render('organization', ['organizations' => $organizations]);
	}

	public function actionCabinet()
	{
		return $this->render('cabinet');
	}

	public function actionApplication()
	{
		return $this->render('application');
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
