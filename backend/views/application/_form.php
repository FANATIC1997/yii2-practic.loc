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
$isUpdate = $this->context->module->requestedAction->id == 'update';
$access = Yii::$app->user->can('admin');
?>

<div class="application-form">
	<?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
		<?= $form->field($model, 'theme')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group">
		<?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => '6']) ?>
    </div>
	<? if ($access): ?>
        <div class="form-group">
            <? if($isUpdate):?>
				<?= $form->field($model, 'user_id')->widget(Select2::className(), [
					'data' => [],
					'options' => ['prompt' => 'Выберите пользователя...', 'disabled' => false]
				]); ?>
            <? else: ?>
				<?= $form->field($model, 'user_id')->widget(Select2::className(), [
					'data' => $model->getAllUsers(),
					'options' => ['prompt' => 'Выберите пользователя...', 'disabled' => false]
				]); ?>
            <? endif; ?>
        </div>
	<? else: ?>

		<? $model->user_id = Yii::$app->user->getId(); ?>

	<? endif; ?>


	<? if (!$isUpdate): ?>
        <div class="form-group">
			<? if ($access): ?>
				<?= $form->field($model, 'organization_id')->widget(DepDrop::classname(), [
					'type' => DepDrop::TYPE_SELECT2,
					'select2Options' => ['pluginOptions' => ['allowClear' => true]],
					'pluginOptions' => [
						'depends' => ['application-user_id'],
						'placeholder' => 'Выберите организацию...',
						'url' => Url::to(['/application/get-org'])
					]
				]); ?>
			<? else: ?>
				<?
				$user = User::findOne($model->user_id);

				?>
				<?= $form->field($model, 'organization_id')->dropDownList($user->getOrgDropList(), ['id' => 'organization_id', 'prompt' => 'Выберите организацию...', 'disabled' => $isUpdate]); ?>
			<? endif; ?>
        </div>

        <div class="form-group">
			<? if ($access): ?>
				<?= $form->field($model, 'manager_id')->widget(DepDrop::classname(), [
					'type' => DepDrop::TYPE_SELECT2,
					'select2Options' => ['pluginOptions' => ['allowClear' => true]],
					'pluginOptions' => [
						'depends' => ['application-organization_id'],
						'placeholder' => 'Выберите менеджера...',
						'url' => Url::to(['/application/get-manager-ajax']),
					]
				]); ?>
			<? endif; ?>
        </div>
	<? else: ?>
        <div class="form-group">
			<?= $form->field($model, 'organization_id')->dropDownList([$model->organization->name], ['disabled' => true]); ?>
        </div>

        <div class="form-group">
			<?= $form->field($model, 'manager_id')->widget(Select2::className(), [
				'data' => $model->getManagerArray($model->organization_id),
				'options' => ['prompt' => 'Выберите менеджера   ...', 'disabled' => false]
			]); ?>
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
