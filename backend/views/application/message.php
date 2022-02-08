<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $message backend\models\Message */
/* @var $messages backend\models\Message */
/* @var $application backend\models\Application */

?>

<div class="messages clearfix" style="font-size: 1.5em; overflow-y: auto; max-height: 440px; padding: 20px;"
     id="messages-scroll">
	<?php $userId = Yii::$app->user->getId(); ?>
	<?php if (!empty($messages)): ?>
		<?php foreach ($messages as $key => $item): ?>
            <hr/>
            <div class="item mb-3">
				<?= $item->user->username ?>
                <div class="status float-right">
					<?= $application->getColor($item) ?>
                </div>
                <div class="message w-75">
					<span class="text-message"><?= $item->message ?></span>
					<?php if ($item->create_time != $item->update_time): ?>
                        <span class="edit">Изменено</span>
					<?php endif; ?>
                </div>
                <div class="message-time">
					<?= date_format(date_create($item->update_time), 'd.m.Y H:i:s') ?>
					<?php if ($message->isEditMessage($item->create_time) and $userId == $item->user_id): ?>
                        <a class="float-right" id="update-message" href="<?= Url::toRoute(['message-update']) ?>"
                           data-id="<?= $item->id ?>">Изменить</a>
					<?php endif; ?>
                </div>
            </div>
		<?php endforeach; ?>

	<?php else: ?>
        <div class="alert alert-info" role="alert">
            Сообщения не найдены
        </div>
	<?php endif; ?>
</div>

<?php if ($application->status_id < 4): ?>
	<?php $form = ActiveForm::begin(['action' => '/application/message-create', 'id' => 'message-form', 'enableAjaxValidation' => false]); ?>
    <div class="form-group d-none">
		<?php
		$message->application_id = $application->id;
		$message->user_id = Yii::$app->user->getId();
		$message->status_id = $application->status_id;
		?>
		<?= $form->field($message, 'application_id')->hiddenInput()->label('') ?>
		<?= $form->field($message, 'user_id')->hiddenInput()->label('') ?>
		<?= $form->field($message, 'status_id')->hiddenInput()->label('') ?>
    </div>

    <div class="form-group">
		<?= $form->field($message, 'message')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group" id="button-message">
		<?= Html::Button('Отправить', ['class' => 'btn btn-success', 'id' => 'button-submit']) ?>
    </div>

	<?php ActiveForm::end(); ?>
<?php endif; ?>
