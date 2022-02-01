<?php

namespace common\models;

use backend\models\Application;
use backend\models\User;
use Yii;

class Dashboard extends User
{
	public function getCountOrg()
	{
		$user = User::findOne(Yii::$app->user->getId());
		return count($user->orgusers);
	}

	public function getCountApplication()
	{
		$arrayCountApplications = [];
		if(Yii::$app->user->can('admin')) {
			$arrayCountApplications['allapplications'] = Application::find()->count();
			$arrayCountApplications['applicationsWork'] = Application::find()->where(['status_id' => 2])->count();
			$arrayCountApplications['applicationsNew'] = Application::find()->where(['status_id' => 1])->count();
			$arrayCountApplications['applicationsComplete'] = Application::find()->where(['status_id' => [3, 4]])->count();
		} elseif(Yii::$app->user->can('manager')) {
			$arrayCountApplications['allapplications'] = Application::find()->where(['manager_id' => Yii::$app->user->getId()])->count();
			$arrayCountApplications['applicationsWork'] = Application::find()->where(['status_id' => 2])->andWhere(['manager_id' => Yii::$app->user->getId()])->count();
			$arrayCountApplications['applicationsNew'] = Application::find()->where(['status_id' => 1])->andWhere(['manager_id' => Yii::$app->user->getId()])->count();
			$arrayCountApplications['applicationsComplete'] = Application::find()->where(['status_id' => [3,4]])->andWhere(['manager_id' => Yii::$app->user->getId()])->count();
		} else {
			$arrayCountApplications['allapplications'] = Application::find()->where(['user_id' => Yii::$app->user->getId()])->count();
			$arrayCountApplications['applicationsWork'] = Application::find()->where(['status_id' => 2])->andWhere(['user_id' => Yii::$app->user->getId()])->count();
			$arrayCountApplications['applicationsNew'] = Application::find()->where(['status_id' => 1])->andWhere(['user_id' => Yii::$app->user->getId()])->count();
			$arrayCountApplications['applicationsComplete'] = Application::find()->where(['status_id' => [3,4]])->andWhere(['user_id' => Yii::$app->user->getId()])->count();
		}

		return $arrayCountApplications;
	}
}