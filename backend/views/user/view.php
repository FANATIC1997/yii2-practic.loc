<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
YiiAsset::register($this);
?>
<div class="user-view container" style="padding-top: 5em;">
	<? if(count($model->orgusers) > 0): ?>
        <div class="container overflow-hidden">
            <h2>Приклепленные организации</h2>
			<? foreach (array_chunk($model->orgusers, 3) as $array): ?>
                <div class="row gy-5">
					<? foreach ($array as $item): ?>
                        <div class="col-sm-4 mb-1">
                            <div class="card" style="width: auto;">
                                <div class="card-body">
									<?= Html::a('<h5 class="card-title">'.$item->name.'</h5>', ['organization/view', 'id' => $model->id], ['style' => 'color: black;']) ?>
                                    <p class="card-text"><strong>Адрес:</strong> <?= $item->address?>
                                        <br/>
                                        <br/>
                                        <strong>Контакты:</strong> <?= $item->contact ?>
                                    </p>
                                </div>
                            </div>
                        </div>
					<? endforeach; ?>
                </div>
			<? endforeach; ?>
        </div>
	<? else: ?>
    <div class="container overflow-hidden">
        <h2>Прикрепленные организации не найдены</h2>
    </div>
	<? endif; ?>

    <div class="user-view">
        <div class="d-flex justify-content-center">
            <div class="col-xl col-md-12">
                <h1><?= Html::encode($this->title) ?></h1>
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"><img src="https://img.icons8.com/bubbles/100/000000/user.png"
                                                         class="img-radius" alt="User-Profile-Image"></div>
                                <h6 class="f-w-600"><?=$model->username?></h6>
                                <p><?=$model->role?></p>
								<?= Html::a('<i class="mdi mdi-square-edit-outline feather icon-edit"></i>', ['update', 'id' => $model->id], ['style'=>'color: white;']) ?>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">
                                    Информация

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
                                    <div class="col-md-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400"><?=$model->email?></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-b-10 f-w-600">Телефон</p>
                                        <h6 class="text-muted f-w-400"><?='+7'.$model->phone?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
