<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Alert;
use yii\bootstrap4\Html;

$this->title = 'Авторизация';
?>
<div class="site-login">
    <div class="mt-5 offset-lg-3 col-lg-6">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Для продолжения пожалуйста авторизуйтесь:</p>
        <? if(!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            Вы не являетесь администратором
        </div>
        <? endif; ?>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

            <div style="color:#999;margin:1em 0">
                Для регистрации пройдите по <?= Html::a('ссылке', ['site/signup']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Авторизация', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
