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
?>
<div class="application-index m-auto w-75" style="padding-top: 5em;">

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
	<?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
	<? if (Yii::$app->user->can('admin')): ?>
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'emptyText' => 'Заявки не найдены',
			'summary' => false,
			'headerRowOptions' => ['class' => 'bg-light'],
			'tableOptions' => ['class' => 'table table-borderless text-center table-application'],
			'rowOptions' => function ($model, $key, $index, $grid)
			{
				return ['id' => $model['id'], 'onclick' => 'location.href="'.yii\helpers\Url::to(['view', 'id' => $model->id]).'"'];
			},
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
				]
			],
		]); ?>
	<? else: ?>
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'emptyText' => 'Заявки не найдены',
			'summary' => false,
			'headerRowOptions' => ['class' => 'bg-light'],
			'tableOptions' => ['class' => 'table table-borderless text-center table-application'],
			'rowOptions' => function ($model, $key, $index, $grid)
			{
				return ['id' => $model['id'], 'onclick' => 'location.href="'.Url::toRoute(['view', 'id' => $model->id]).'"'];
			},
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
				]
			],
		]); ?>
	<? endif; ?>
	<?php Pjax::end(); ?>
</div>
