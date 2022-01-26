<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $organizations \backend\models\organization */
/* @var $model \backend\models\CreateOrgForm */
/* @var $org \backend\models\CreateOrgForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Организации';
?>
<div class="site-user">
	<? if (!empty($result)): ?>
        <div class="alert alert-success" role="alert"><?= $result ?></div>
	<? endif; ?>
    <div class="row">
		<?php $form = ActiveForm::begin(['id' => 'create-org', 'options' => ['style' => 'display: flex']]); ?>
        <div class="col">
			<?= $form->field($model, 'name')->textInput()->input('name', ['placeholder' => 'Наименование...'])->label('') ?>
        </div>
        <div class="col">
			<?= $form->field($model, 'address')->textInput()->input('address', ['placeholder' => 'Адрес...'])->label('')?>
        </div>
        <div class="col">
			<?= $form->field($model, 'contact')->passwordInput()->input('contact', ['placeholder' => 'Контакты...'])->label('')?>
        </div>
        <div class="col">
			<?= Html::submitButton('Добавить', ['class' => 'btn btn-primary btn-block', 'name' => 'create-org-button', 'style' => 'margin-top: 13.5%']) ?>
        </div>
		<?php ActiveForm::end(); ?>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Наименование</th>
            <th scope="col">Адрес</th>
            <th scope="col">Контакты</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
		<? foreach ($organizations as $key => $item): ?>
            <tr class="line">
                <th scope="row"><?= $item->id ?></th>
                <td><?= $item->name ?></td>
                <td><?= $item->address ?></td>
                <td><?= $item->contact ?></td>
                <td>
					<? echo Html::a('<img src="../web/image/delete.svg" width="30" title="Удалить">', Url::to(['organization/delete', 'id' => $item->id])) ?>
                </td>
            </tr>
		<? endforeach; ?>
        <? if(!is_null($org)): ?>
            <tr class="line">
                <th scope="row"><?= $org->id ?></th>
                <td><?= $org->name ?></td>
                <td><?= $org->address ?></td>
                <td><?= $org->contact ?></td>
                <td>
					<? echo Html::a('<img src="../web/image/delete.svg" width="30" title="Удалить">', Url::to(['organization/delete', 'id' => $org->id])) ?>
                </td>
            </tr>
        <? endif; ?>
        </tbody>
    </table>
</div>