<?php

use backend\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */
/* @var $error backend\controllers\OrganizationController */
/* @var $users User */

$this->title = 'Изменение информации о: ' . $model->name;
?>
<div class="organization-update container" style="margin-top: 3.5em;">

    <h1><?= Html::encode($this->title) ?></h1>

	<? if(!is_null($error)): ?>
        <div class="alert alert-danger" role="alert">
			<?= $error ?>
        </div>
	<? endif; ?>
    <?= $this->render('_form', [
        'model' => $model,
		'users' => $users,
        'error' => $error
    ]) ?>

</div>
