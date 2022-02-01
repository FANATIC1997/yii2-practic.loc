<?php

/* @var $this yii\web\View */

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
                        <li class="list-group-item">Администраторов: <strong><?= $users['admins'] ?></strong></li>
                        <li class="list-group-item">Менеджеров: <strong><?= $users['managers'] ?></strong></li>
                        <li class="list-group-item">Пользователей: <strong><?= $users['users'] ?></strong></li>
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
                        <li class="list-group-item">В работе: <strong><?= $application['applicationsWork'] ?></strong></li>
                        <li class="list-group-item">Новых: <strong><?= $application['applicationsNew'] ?></strong></li>
                        <li class="list-group-item">Решенных: <strong><?= $application['applicationsComplete'] ?></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
