<?php

use backend\controllers\CabinetController;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $error CabinetController */

$this->title = 'Изменение личных данных';
?>
<div class="user-update container" style="margin-top: 3.5em;">

	<h1><?= Html::encode($this->title) ?></h1>

	<? if(!is_null($error)): ?>
		<div class="alert alert-danger" role="alert">
			<?= $error ?>
		</div>
	<? endif; ?>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
