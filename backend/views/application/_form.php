<?php

use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\depdrop\DepDrop;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $form yii\bootstrap4\ActiveForm */
$id_action = $this->context->module->requestedAction->id == 'update';
$access = Yii::$app->user->can('admin');
?>

<div class="application-form">
	<?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
		<?= $form->field($model, 'theme')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group">
		<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    </div>
	<? if ($access): ?>
        <div class="form-group">
			<?= $form->field($model, 'user_id')->dropDownList($model->getAllUsers(), ['id' => 'user_id', 'prompt' => 'Выберите пользователя...', 'disabled' => $id_action]); ?>
        </div>
	<? else: ?>

		<? $model->user_id = Yii::$app->user->getId(); ?>

	<? endif; ?>
	<? if (!$id_action): ?>
        <div class="form-group">
			<? if ($access): ?>
				<?= $form->field($model, 'organization_id')->widget(DepDrop::classname(), [
					'options' => ['id' => 'organization_id'],
					'pluginOptions' => [
						'depends' => ['user_id'],
						'placeholder' => 'Выберите организацию...',
						'url' => Url::to(['/application/get-org'])
					]
				]); ?>
			<? else: ?>
				<?
				$user = User::findOne($model->user_id);

				?>
				<?= $form->field($model, 'organization_id')->dropDownList($user->getOrgDropList(), ['id' => 'organization_id', 'prompt' => 'Выберите организацию...', 'disabled' => $id_action]); ?>
			<? endif; ?>
        </div>

        <div class="form-group">
			<? if ($access): ?>
				<?= $form->field($model, 'manager_id')->widget(DepDrop::classname(), [
					'pluginOptions' => [
						'depends' => ['organization_id'],
						'placeholder' => 'Выберите менеджера...',
						'url' => Url::to(['/application/get-manager'])
					]
				]); ?>
			<? endif; ?>
        </div>
	<? else: ?>
        <div class="form-group">
			<?= $form->field($model, 'organization_id')->dropDownList([$model->organization->name], ['disabled' => true]); ?>
        </div>

        <div class="form-group">
			<?= $form->field($model, 'manager_id')->dropDownList([$model->manager->username], ['disabled' => true]); ?>
        </div>
	<? endif; ?>
	<? if ($access): ?>
        <div class="form-group">
			<?= $form->field($model, 'status_id')->widget(Select2::classname(), [
				'data' => $model->getAllStatus(),
				'options' => ['placeholder' => 'Выберите статус...'],
				'pluginOptions' => [
					'allowClear' => true
				],
			]); ?>
        </div>
    <? else: ?>
        <div class="form-group">
			<?= $form->field($model, 'status_id')->dropDownList([$model->getAllStatus()], ['disabled' => true]); ?>
        </div>
	<? endif; ?>
    <div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
