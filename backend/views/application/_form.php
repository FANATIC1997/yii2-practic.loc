<?php

use backend\models\Organization;
use backend\models\Roles;
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
$role = new Roles();
$access = $role->getRole();
?>

<div class="application-form">
	<?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
		<?= $form->field($model, 'theme')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group">
		<?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => '6']) ?>
    </div>


	<?php if ($isUpdate): ?>
		<?php if ($access['item_name'] == User::ADMIN): ?>
            <div class="form-group">
				<?php $organization = Organization::findOne($model->organization_id); ?>
				<?= $form->field($model, 'user_id')->widget(Select2::className(), [
					'data' => $organization->getUsersOrg(),
					'options' => ['prompt' => 'Выберите пользователя...', 'disabled' => false]
				]); ?>
            </div>
			<?php $user = User::findOne($model->user_id); ?>
            <div class="form-group">
				<?= $form->field($model, 'organization_id')->dropDownList($user->getOrgDropList(), ['id' => 'organization_id', 'prompt' => 'Выберите организацию...', 'disabled' => true]); ?>
            </div>
            <div class="form-group">
				<?= $form->field($model, 'manager_id')->widget(Select2::className(), [
					'data' => $model->getManagerArray($model->organization_id),
					'options' => ['prompt' => 'Выберите менеджера...', 'disabled' => false]
				]); ?>
            </div>
            <div class="form-group">
				<?= $form->field($model, 'status_id')->widget(Select2::classname(), [
					'data' => $model->getAllStatus(),
					'options' => ['placeholder' => 'Выберите статус...']
				]); ?>
            </div>
		<?php endif; ?>
	<?php else: ?>
		<?php if ($access['item_name'] == User::ADMIN): ?>
            <div class="form-group">
                <?php
				$organization = new Organization();
				?>
				<?= $form->field($model, 'organization_id')->widget(Select2::className(), [
					'data' => $organization->getAllOrganization(),
					'options' => ['prompt' => 'Выберите организацию...', 'disabled' => false],
					'pluginOptions' => [
						'allowClear' => true
					]
				]); ?>
            </div>
        <?php else: ?>
            <div class="form-group">
				<?php $user = User::findOne($access['user_id']); ?>
				<?= $form->field($model, 'organization_id')->dropDownList($user->getOrgDropList(), ['id' => 'organization_id', 'prompt' => 'Выберите организацию...', 'disabled' => false]); ?>
            </div>
		<?php endif; ?>
	<?php endif; ?>


    <div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
