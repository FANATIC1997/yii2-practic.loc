<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->title = $model->theme;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->theme;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($model->theme) ?></h1>

    <p>
        <? if(Yii::$app->user->can('manager')): ?>
            <? if($model->status_id == 1): ?>
			    <?= Html::a('В работу', ['work', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <? elseif($model->status_id == 2): ?>
				<?= Html::a('Завершить', ['completed', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <? endif; ?>
        <? endif; ?>

		<? if(Yii::$app->user->can('user')): ?>
			<? if($model->status_id == 3): ?>
				<?= Html::a('Закрыть', ['close', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
			<? endif; ?>
		<? endif; ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'theme',
            'description',
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
				'attribute' => 'Телефон',
				'value' => function ($data) {
					return '+7'.$data->user->phone;
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
        ],
    ]) ?>

</div>
