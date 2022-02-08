<?php

use backend\models\Organization;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchOrganization */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Организации';
?>
<div class="organization-index m-auto w-75" style="padding-top: 5em;">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить организацию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'emptyText' => 'Организации не найдены',
		'summary' => false,
		'headerRowOptions' => ['class' => 'bg-light'],
		'tableOptions' => ['class' => 'table table-borderless text-center table-application'],
		'rowOptions' => function ($model, $key, $index, $grid)
		{
			return ['id' => $model['id'], 'onclick' => 'location.href="'.yii\helpers\Url::to(['view', 'id' => $model->id]).'"'];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'address',
            'contact',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
