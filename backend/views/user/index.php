<?php

use backend\models\User;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>
<div class="user-index m-auto w-75" style="padding-top: 5em;">

    <h1><?= Html::encode('Пользователи') ?></h1>

    <p>
		<?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?php Pjax::begin(); ?>
	<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'emptyText' => 'Пользователи не найдены',
		'summary' => false,
		'headerRowOptions' => ['class' => 'bg-light'],
		'tableOptions' => ['class' => 'table table-borderless text-center table-application'],
		'rowOptions' => function ($model, $key, $index, $grid) {
			return ['id' => $model['id'], 'onclick' => 'location.href="' . yii\helpers\Url::to(['view', 'id' => $model->id]) . '"'];
		},
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'username',
			'email:email',
			[
				'attribute' => 'item_name',
				'label' => 'Уровень доступа',
				'value' => function ($data) {
					return $data->getAccess();
				}
			],
		],
	]); ?>

	<?php Pjax::end(); ?>

</div>
