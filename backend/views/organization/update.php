<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */

$this->title = 'Изменение информации о: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="organization-update">

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
