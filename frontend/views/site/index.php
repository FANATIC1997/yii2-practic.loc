<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="container overflow-hidden">
        <h2 style="margin-bottom: 2%;">Прикрепленных к вам организаций: <strong><?= $countOrgs ?></strong></h2>
        <div class="row">
            <div class="col">
                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        <h5 class="card-title">Статистика заявок</h5>
                        <p class="card-text">
                            Общее количество заявок <strong><?= $applications['allapplications'] ?></strong>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">В работе: <strong><?= $applications['applicationsWork'] ?></strong></li>
                        <li class="list-group-item">Новых: <strong><?= $applications['applicationsNew'] ?></strong></li>
                        <li class="list-group-item">Решенных: <strong><?= $applications['applicationsComplete'] ?></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
