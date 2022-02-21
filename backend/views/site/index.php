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
    <div class="container overflow-hidden mt-5">
        <h2 style="margin-bottom: 1%; margin-top: 2%;">Прикрепленных к вам организаций: <strong><?= $countOrgs ?></strong></h2>

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
                <div class="box">
					<?= Html::img('@web/image/new.svg', ['class' => 'box-image']) ?>
					<?= Html::a('Новых <span class="badge badge-primary badge-pill">' . $application['applicationsNew'] . '</span>', ['application/index', 'ApplicationSearch' => ['status' => 'Новая']], ['class' => 'ml-2']) ?>
                </div>
            </div>
            <div class="col">
                <div class="box">
					<?= Html::img('@web/image/work.svg', ['class' => 'box-image']) ?>
					<?= Html::a('В работе  <span class="badge badge-primary badge-pill">' . $application['applicationsWork'] . '</span>', ['application/index', 'ApplicationSearch' => ['status' => 'В работе']], ['class' => 'ml-2']) ?>
                </div>
            </div>
            <div class="col">
                <div class="box">
					<?= Html::img('@web/image/complete.svg', ['class' => 'box-image']) ?>
					<?= Html::a('Готовых  <span class="badge badge-primary badge-pill">' . $application['applicationsComplete'] . '</span>', ['application/index', 'ApplicationSearch' => ['status' => 'Готово']], ['class' => 'ml-2']) ?>
                </div>
            </div>
            <div class="col">
                <div class="box">
					<?= Html::img('@web/image/close.svg', ['class' => 'box-image']) ?>
					<?= Html::a('Решенных  <span class="badge badge-primary badge-pill">' . $application['applicationsClosed'] . '</span>', ['application/index', 'ApplicationSearch' => ['status' => 'Закрыто']], ['class' => 'ml-1']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
