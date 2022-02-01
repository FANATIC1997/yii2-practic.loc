<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="site-signup">
    <div class="mt-5 offset-lg-3 col-lg-6">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Пожалуйста заполните все данные для регистрации:</p>
		<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

		<?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

		<?= $form->field($model, 'email')->label('Email') ?>

		<?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

        <div class="form-group">
			<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

		<?php ActiveForm::end(); ?>
    </div>
</div>
