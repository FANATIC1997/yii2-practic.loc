<?php

use backend\models\Application;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<? if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
			<?= $error ?>
        </div>
	<? endif; ?>

    <p>
		<?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?php Pjax::begin(); ?>
	<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
	<? if (Yii::$app->user->can('admin')): ?>
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'emptyText' => 'Заявки не найдены',
			'summary' => false,
			'headerRowOptions' => ['class' => 'bg-light'],
			'tableOptions' => ['class' => 'table table-borderless text-center'],
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'theme',
				[
					'attribute' => 'status',
					'content' => function ($data) {
						return $data->getColor($data);
					}
				],
				[
					'attribute' => 'user',
					'content' => function ($data) {
						return '<img src="https://i.imgur.com/VKOeFyS.png" width="25"> ' . $data->user->username;
					}
				],
				[
					'attribute' => 'manager',
					'content' => function ($data) {
						return '<img src="https://i.imgur.com/VKOeFyS.png" width="25"> ' . $data->manager->username;
					}
				],
				[
					'attribute' => 'organization',
					'value' => function ($data) {
						return $data->organization->name;
					}
				],
				[
					'class' => ActionColumn::className(),
					'urlCreator' => function ($action, Application $model, $key, $index, $column) {
						return Url::toRoute([$action, 'id' => $model->id]);
					}
				],
			],
		]); ?>
	<? else: ?>
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'emptyText' => 'Заявки не найдены',
			'summary' => false,
			'headerRowOptions' => ['class' => 'bg-light'],
			'tableOptions' => ['class' => 'table table-borderless text-center'],
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'theme',
				[
					'attribute' => 'status',
					'content' => function ($data) {
						return $data->getColor($data);
					}
				],
				[
					'attribute' => 'manager',
					'content' => function ($data) {
						return '<img src="https://i.imgur.com/VKOeFyS.png" width="25"> ' . $data->manager->username;
					}
				],
				[
					'attribute' => 'organization',
					'value' => function ($data) {
						return $data->organization->name;
					}
				],
				[
					'class' => ActionColumn::className(),
					'urlCreator' => function ($action, Application $model, $key, $index, $column) {
						return Url::toRoute([$action, 'id' => $model->id]);
					}
				],
			],
		]); ?>
	<? endif; ?>
	<?php Pjax::end(); ?>
</div>
