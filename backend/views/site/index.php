<?php

/* @var $this yii\web\View */
/* @var $users backend\models\User */
/* @var $application backend\models\Application */

/* @var $countOrgs backend\models\Organization */

use backend\models\Roles;
use backend\models\User;
use miloschuman\highcharts\Highcharts;
use yii\bootstrap4\Html;
use miloschuman\highcharts\HighchartsAsset;

HighchartsAsset::register($this)->withScripts(['highcharts', 'modules/exporting', 'modules/export-data', 'modules/accessibility', 'modules/drilldown']);

$this->title = 'Dashboard';
$role = new Roles();
$access = $role->getRole();
?>
<div class="site-index">
    <div class="container overflow-hidden">
        <h2 style="margin-bottom: 2%;">Прикрепленных к вам организаций: <strong><?= $countOrgs ?></strong></h2>

        <div class="row">
			<?php if ($access['item_name'] == User::ADMIN): ?>
                <div class="col">
                    <div class="box">
                        <div id="chart-user-info" style="display: none;">
                            <span id="all"><?= $users['allusers'] ?></span>
                            <span id="admin"><?= $users['admins'] ?></span>
                            <span id="manager"><?= $users['managers'] ?></span>
                            <span id="user"><?= $users['users'] ?></span>
                        </div>
                        <div id="chart-user"></div>
                    </div>
                </div>
			<?php endif; ?>

			<?php if ($access['item_name'] != User::USER): ?>
                <div class="col">
                    <div class="box">
                        <div id="chart-application"></div>
                    </div>
                </div>
			<?php endif; ?>
        </div>

		<?php if ($access['item_name'] == User::ADMIN): ?>
            <div class="row">
                <div class="col">
                    <div class="box">
                        <div id="chart-max-work"></div>
                    </div>
                </div>
            </div>
		<?php endif; ?>

        <div class="row">
            <div class="col">
                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        <h5 class="card-title">Статистика заявок</h5>
                        <p class="card-text">
                            Общее количество заявок <strong><?= $application['allapplications'] ?></strong>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
						<?= Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">Новых: <span class="badge badge-primary badge-pill">' . $application['applicationsNew'] . '</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'Новая']]) ?>
						<?= Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">В работе:  <span class="badge badge-primary badge-pill">' . $application['applicationsWork'] . '</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'В работе']]) ?>
						<?= Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">Готовых:  <span class="badge badge-primary badge-pill">' . $application['applicationsComplete'] . '</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'Готово']]) ?>
						<?= Html::a('<li class="list-group-item d-flex justify-content-between align-items-center">Решенных:  <span class="badge badge-primary badge-pill">' . $application['applicationsClosed'] . '</span></li>', ['application/index', 'ApplicationSearch' => ['status' => 'Закрыто']]) ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
