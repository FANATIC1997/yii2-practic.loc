<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="container overflow-hidden">
        <div class="row">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Общее количество пользователей <strong><?= $allusers ?></strong></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Администраторов: <strong><?= $admins ?></strong></li>
                        <li class="list-group-item">Менеджеров: <strong><?= $managers ?></strong></li>
                        <li class="list-group-item">Пользователей: <strong><?= $users ?></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
