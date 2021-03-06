<?php

use backend\models\Application;
use backend\models\Log;
use backend\models\Roles;
use backend\models\User;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $log  Log */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$role = new Roles();
$access = $role->getRole();
?>
<div class="application-index m-auto w-75" style="padding-top: 5em;">

	<h1><?=Html::encode($this->title)?></h1>
	<?php if (!empty($error)): ?>
		<div class="alert alert-danger" role="alert">
			<?=$error?>
		</div>
	<?php endif; ?>

	<p>
		<?=Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success'])?>
	</p>

	<?php Pjax::begin(); ?>
	<?php //echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php if (Yii::$app->user->can('admin')): ?>
		<?=GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'emptyText' => 'Заявки не найдены',
			'summary' => false,
			'headerRowOptions' => ['class' => 'bg-light'],
			'tableOptions' => ['class' => 'table table-borderless text-center table-application'],
			'rowOptions' => function ($model, $key, $index, $grid)
			{
				return ['id' => $model['id'], 'onclick' => 'location.href="' . yii\helpers\Url::to(['view', 'id' => $model->id]) . '"'];
			},
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'theme',
				[
					'attribute' => 'status',
					'content' => function ($data)
					{
						return $data->getColor($data);
					}
				],
				[
					'attribute' => 'user',
					'content' => function ($data)
					{
						return '<img src="https://i.imgur.com/VKOeFyS.png" width="25"> ' . $data->user->username;
					}
				],
				[
					'attribute' => 'manager',
					'content' => function ($data)
					{
						return '<img src="https://i.imgur.com/VKOeFyS.png" width="25"> ' . $data->manager->username;
					}
				],
				[
					'attribute' => 'organization',
					'value' => function ($data)
					{
						return $data->organization->name;
					}
				]
			],
		]);?>
	<?php else: ?>
		<?=GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'emptyText' => 'Заявки не найдены',
			'summary' => false,
			'headerRowOptions' => ['class' => 'bg-light'],
			'tableOptions' => ['class' => 'table table-borderless text-center table-application'],
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'theme',
				[
					'attribute' => 'status',
					'content' => function ($data)
					{
						return $data->getColor($data);
					}
				],
				[
					'attribute' => 'manager',
					'content' => function ($data)
					{
						return '<img src="https://i.imgur.com/VKOeFyS.png" width="25"> ' . $data->manager->username;
					}
				],
				[
					'attribute' => 'organization',
					'value' => function ($data)
					{
						return $data->organization->name;
					}
				],
				[
					'class' => 'yii\grid\DataColumn',
					'attribute' => '',
					'content' => function ($data) use ($access)
					{
                        if($access['item_name'] == User::MANAGER or $access['item_name'] == User::ADMIN) {
                            if($data->status_id < 3) {
								return Html::a(Html::img('@web/image/save.svg', ['alt' => 'Тык']), ['comment', 'id' => $data->id], [
									'title' => 'Тык',
									'id' => 'link-modal',
									'data' => [
										'id' => $data->id,
										'status' => $data->status_id,
										'user-now' => $access['user_id'],
										'user-access' => $access['item_name'],
										'user' => $data->user_id,
									]
								]);
							}
						}
					}
				],
			],
		]);?>
	<?php endif; ?>
	<?php Pjax::end(); ?>

	<?php Modal::begin(['title' => 'Смена статуса заявки', 'id' => 'myModal']) ?>
		<?php $form = ActiveForm::begin(['action' => 'application/set-state?id=', 'method' => 'POST', 'id' => 'modal-w1']); ?>
			<div class="form-group">
				<?=$form->field($log, 'comment')->textInput(['maxlength' => true])?>
			</div>

			<div class="form-group">
				<?=Html::submitButton('Дальше', ['class' => 'btn btn-success', 'name' => 'next', 'id' => 'next'])?>
				<?=Html::submitButton('Вернуть в работу', ['class' => 'btn btn-primary', 'name' => 'back', 'id' => 'back'])?>
			</div>
		<?php ActiveForm::end(); ?>
	<?php Modal::end() ?>


	<?php
	$this->registerJs("
        $('td').click(function (e) {
            var id = $(this).closest('tr').data('key');
            if(e.target == this)
                location.href = '" . Url::to(['view']) . "?id=' + id;
        });
    ");
	?>
</div>
