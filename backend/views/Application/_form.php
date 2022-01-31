<?php

use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $form yii\bootstrap4\ActiveForm */
$id_action = $this->context->module->requestedAction->id == 'update';
?>

<div class="application-form">
	<?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
		<?= $form->field($model, 'theme')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group">
		<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group">
		<?= $form->field($model, 'user_id')->dropDownList($model->getAllUsers(), ['id' => 'user_id', 'prompt' => 'Выберите пользователя...', 'disabled' => $id_action]); ?>
    </div>
	<? if (!$id_action): ?>
        <div class="form-group">
			<?= $form->field($model, 'organization_id')->widget(DepDrop::classname(), [
				'options' => ['id' => 'organization_id'],
				'pluginOptions' => [
					'depends' => ['user_id'],
					'placeholder' => 'Выберите организацию...',
					'url' => Url::to(['/application/get-org'])
				]
			]); ?>
        </div>

        <div class="form-group">
			<?= $form->field($model, 'manager_id')->widget(DepDrop::classname(), [
				'pluginOptions' => [
					'depends' => ['organization_id'],
					'placeholder' => 'Выберите менеджера...',
					'url' => Url::to(['/application/get-manager'])
				]
			]); ?>
        </div>
	<? else: ?>
        <div class="form-group">
			<?= $form->field($model, 'organization_id')->dropDownList([$model->organization->name], ['disabled' => true]); ?>
        </div>

        <div class="form-group">
			<?= $form->field($model, 'manager_id')->dropDownList([$model->manager->username], ['disabled' => true]); ?>
        </div>
	<? endif; ?>
    <div class="form-group">
		<?= $form->field($model, 'status_id')->widget(Select2::classname(), [
			'data' => $model->getAllStatus(),
			'options' => ['placeholder' => 'Выберите статус...'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]); ?>
    </div>
    <div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
