<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $orgs backend\controllers\UserController */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="user-form">

	<?php $form = ActiveForm::begin(); ?>

	<div class="form-group">
		<?= $form->field($model, 'username')->textInput(['maxlength' => true])->input('username', ['placeholder' => 'Никнейм...']) ?>
	</div>
	<div class="form-group">
		<?= $form->field($model, 'email')->textInput(['maxlength' => true])->input('email', ['placeholder' => 'Email...']) ?>
	</div>
    <div class="form-group">
		<?
		$model->phone = '+7'.$model->phone;
		?>
		<?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
			'mask' => '+7 (999) 999-99-99',
			'options' => [
				'class' => 'form-control placeholder-style',
				'id' => 'phone2',
				'placeholder' => ('Телефон')
			],
			'clientOptions' => [
				'clearIncomplete' => true
			]
        ]) ?>
    </div>
	<div class="form-group">
		<?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->input('password', ['placeholder' => 'Пароль...'])->label('Пароль') ?>
	</div>

	<div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>
