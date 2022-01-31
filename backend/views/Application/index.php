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

    <p>
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'theme',
            [
                    'attribute' => 'organization',
				'value' => function ($data) {
					return $data->organization->name;
				}
            ],
            [
				'attribute' => 'user',
				'value' => function ($data) {
					return $data->user->username;
				}
            ],
			[
				'attribute' => 'manager',
				'value' => function ($data) {
					return $data->manager->username;
				}
			],
            [
				'attribute' => 'status',
				'value' => function ($data) {
					return $data->status->name;
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

    <?php Pjax::end(); ?>

</div>
