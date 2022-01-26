<?php

/* @var $this yii\web\View */
/* @var $model \backend\models\EditInfoForm */

/* @var $form yii\bootstrap4\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Личный кабинет';
?>
<div class="site-index">
    <h2>Организации прикрепленные к вам</h2>
    <div class="container overflow-hidden">
		<? foreach (array_chunk($user->orgs, 3) as $array): ?>
            <div class="row gy-5">
				<? foreach ($array as $item): ?>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $item->name ?></h5>
                                <p class="card-text"><strong>Адрес:</strong> <?= $item->address?>
                                <br/>
                                <br/>
                                    <strong>Контакты:</strong> <?= $item->contact ?>
                                </p>
                            </div>
                        </div>
                    </div>
				<? endforeach; ?>
            </div>
		<? endforeach; ?>
    </div>
    <h2>Изменение личных данных</h2>
	<?php if (!empty($result)): ?>
        <div class="alert alert-success" role="alert"><?= $result ?></div>
	<?php endif; ?>
	<?php $form = ActiveForm::begin(['id' => 'edit-user']); ?>
    <div class="col">
		<?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => 'Псевдоним...'])->label('Псевдоним') ?>
    </div>
    <div class="col">
		<?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => 'Email...'])->label('Email') ?>
    </div>
    <div class="col">
		<?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => 'Пароль...'])->label('Пароль') ?>
    </div>
    <div class="col">
		<?= Html::submitButton('Изменить', ['class' => 'btn btn-primary btn-block', 'name' => 'edit-user-button']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>
