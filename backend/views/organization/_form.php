<?php

use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="organization-form">
		<?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
			<?
			$model->usersConnect = $model->getUserOrgsArray();
			?>
			<?= $form->field($model, 'usersConnect')->widget(Select2::classname(), [
				'data' => $users,
				'size' => Select2::MEDIUM,
				'options' => ['placeholder' => ' Выберите пользователей...', 'multiple' => true],
				'pluginOptions' => [
					'allowClear' => true,
				],
			])->label('Привязанные пользователи'); ?>
        </div>

        <div class="form-group">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true])->input('name', ['placeholder' => 'Наименование...']) ?>
        </div>
        <div class="form-group">
			<?= $form->field($model, 'address')->textInput(['maxlength' => true])->input('address', ['placeholder' => 'Адрес...']) ?>
        </div>
        <div class="form-group">
			<?= $form->field($model, 'contact')->textInput(['maxlength' => true])->input('contact', ['placeholder' => 'Контакты...']) ?>
        </div>
        <div class="form-group">
			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

		<?php ActiveForm::end(); ?>
    </div>
</div>
