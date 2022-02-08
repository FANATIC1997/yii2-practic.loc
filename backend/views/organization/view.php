<?php

use backend\models\Roles;
use backend\models\User;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */

$this->title = $model->name;
YiiAsset::register($this);
$role = new Roles();
$access = $role->getRole();
?>
<div class="organization-view container" style="padding-top: 5em;">

    <div class="users mb-5">
		<? if (count($model->orgusers) > 0): ?>
            <div class="container-fluid overflow-hidden">
                <h2>Приклепленные пользователи</h2>
                <div class="row gy-5">
					<? foreach ($model->orgusers as $item): ?>
                        <div class="col-4 mb-2">
                            <div class="card text-center" style="width: auto;">
                                <div class="card-body p-1">
                                    <?= Html::a('<h5 class="card-title m-0">'.$item->username.'</h5>', ['user/view', 'id' => $model->id], ['style' => 'color: black;']) ?>
                                </div>
                            </div>
                        </div>
					<? endforeach; ?>
                </div>
            </div>
		<? else: ?>
        <div class="container-fluid overflow-hidden">
            <h2>Прикрепленные пользователи не найдены</h2>
        </div>
		<? endif; ?>
    </div>

    <div class="col mb-4">
        <div class="d-flex justify-content-center">
            <div class="col-xl col-md-12 p-0">
                <div class="card user-card-full">
                    <div class="card-block">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">
							<?= Html::encode($model->name) ?>
                            ID: <?= $model->id ?>
                            <div class="float-right clearfix" style="margin-top: -15px;">
								<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mb-2']) ?>
								<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
									'class' => 'btn btn-danger mb-2',
									'data' => [
										'confirm' => 'Вы уверены что хотите удалить?',
										'method' => 'post',
									],
								]) ?>
                            </div>
                        </h6>
                        <div class="row w-100">
                            <div class="col-md-4">
                                <p class="m-b-10 f-w-600" style="font-size: 1.4em">Наименование</p>
                                <h6 class="text-muted f-w-400"><?= $model->name ?></h6>
                            </div>
                            <div class="col-md-4">
                                <p class="m-b-10 f-w-600" style="font-size: 1.4em">Адрес</p>
                                <h6 class="text-muted f-w-400"><?= $model->address ?></h6>
                            </div>
                            <div class="col-md-4">
                                <p class="m-b-10 f-w-600" style="font-size: 1.4em">Контакты</p>
                                <h6 class="text-muted f-w-400"><?= $model->contact ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
