<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="container overflow-hidden">
        <h2 style="margin-bottom: 2%;">Прикрепленных к вам организаций: <strong><?= $countOrgs ?></strong></h2>
        <div class="row">
			<? if(Yii::$app->user->can('admin')): ?>
            <div class="col">
                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        <h5 class="card-title">Статистика пользователей</h5>
                        <p class="card-text">
                            Общее количество пользователей <strong><?= $users['allusers'] ?></strong>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Администраторов:  <span class="badge badge-primary badge-pill"><?= $users['admins'] ?></span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Менеджеров:  <span class="badge badge-primary badge-pill"><?= $users['managers'] ?></span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Пользователей:  <span class="badge badge-primary badge-pill"><?= $users['users'] ?></span></li>
                    </ul>
                </div>
            </div>
            <? endif; ?>
            <div class="col">
                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        <h5 class="card-title">Статистика заявок</h5>
                        <p class="card-text">
                            Общее количество заявок <strong><?= $application['allapplications'] ?></strong>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?=Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">Новых: <span class="badge badge-primary badge-pill">'.$application['applicationsNew'].'</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'Новая']])?>
                        <?=Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">В работе:  <span class="badge badge-primary badge-pill">'.$application['applicationsWork'].'</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'В работе']])?>
                        <?=Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">Готовых:  <span class="badge badge-primary badge-pill">'.$application['applicationsComplete'].'</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'Готово']])?>
                        <?=Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">Решенных:  <span class="badge badge-primary badge-pill">'.$application['applicationsClosed'].'</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'Закрыто']])?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
