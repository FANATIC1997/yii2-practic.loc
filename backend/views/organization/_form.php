<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="organization-form">
    <div class="row">
		<?php $form = ActiveForm::begin(); ?>
        <div class="col">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
			<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
			<?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

		<?php ActiveForm::end(); ?>
    </div>
</div>
