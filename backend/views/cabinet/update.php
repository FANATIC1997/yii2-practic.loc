<?php
use kartik\select2\Select2;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Изменение личных данных';
?>
<div class="user-update">

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
