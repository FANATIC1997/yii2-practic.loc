<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organization-view">

	<? if(count($model->orgusers) > 0): ?>
        <h2>Приклепленные пользователи</h2>
        <div class="container overflow-hidden">
			<? foreach (array_chunk($model->orgusers, 3) as $array): ?>
                <div class="row gy-5">
					<? foreach ($array as $item): ?>
                        <div class="col">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item->username ?></h5>
                                </div>
                            </div>
                        </div>
					<? endforeach; ?>
                </div>
			<? endforeach; ?>
        </div>
	<? else: ?>
        <h2>Прикрепленные пользователи не найдены</h2>
	<? endif; ?>

    <h1 style="margin-top: 1%;"><?= Html::encode($this->title) ?></h1>

    <p>
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
            'name',
            'address',
            'contact',
        ],
    ]) ?>

</div>
