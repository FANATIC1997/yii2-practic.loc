<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'theme')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'user_id')->widget(Select2::classname(), [
		'data' => $model->getAllUsers(),
		'options' => ['placeholder' => 'Выберите пользователя...'],
		'pluginOptions' => [
			'allowClear' => true
		],
	]); ?>

	<?= $form->field($model, 'organization_id')->widget(Select2::classname(), [
		'data' => $model->getAllOrganization(),
		'options' => ['placeholder' => 'Выберите организацию...'],
		'pluginOptions' => [
			'allowClear' => true
		],
	]); ?>

	<?= $form->field($model, 'status_id')->widget(Select2::classname(), [
		'data' => $model->getAllStatus(),
		'options' => ['placeholder' => 'Выберите статус...'],
		'pluginOptions' => [
			'allowClear' => true
		],
	]); ?>

    <div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
