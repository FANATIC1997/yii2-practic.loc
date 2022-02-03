<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $message backend\models\Message */
/* @var $messages backend\models\Message */
/* @var $application backend\models\Application */

?>

    <div class="messages clearfix" style="font-size: 1.5em; overflow-y: auto; max-height: 500px;" id="messages-scroll">
		<? $userId = Yii::$app->user->getId(); ?>
		<? foreach ($messages as $key => $item): ?>
			<? if ($item->user_id == $userId): ?>
				<? if ($messages[$key - 1]->user_id == $item->user_id and $messages[$key - 1]->status_id == $item->status_id): ?>
                    <div class="item-message clearfix">
                        <div class="float-right">
                            <div class="badge badge-primary p-2 mb-1 text-wrap float-right text-left" style="width: auto; max-width: 21rem;">
								<?= $item->message ?>
                                <div class="clearfix"></div>
                                <span class="float-right mt-1" style="font-size: 0.6em;"><?= date('d.m.y H:i:s', $item->created_at) ?></span>
                            </div>
                        </div>
                    </div>
				<? else: ?>
                    <div class="item-message clearfix">
                        <div class="float-right">
                            <small class="text-muted clearfix">
                                <span class="float-right"><?= $item->user->username ?></span>
                                <div class="clearfix"></div>
                                <span class="float-right mb-1" style="font-size: 0.8em;">Статус заявки: <?= $item->status->name ?></span>
                            </small>
                            <div class="badge badge-primary p-2 mb-1 text-wrap float-right text-left" style="width: auto; max-width: 21rem;">
								<?= $item->message ?>
                                <div class="clearfix"></div>
                                <span class="float-right mt-1" style="font-size: 0.6em;"><?= date('d.m.y H:i:s', $item->created_at) ?></span>
                            </div>
                        </div>
                    </div>
				<? endif; ?>
			<? else: ?>
				<? if ($messages[$key - 1]->user_id == $item->user_id and $messages[$key - 1]->status_id == $item->status_id): ?>
                    <div class="item-message clearfix">
                        <div class="float-left">
                            <div class="badge badge-primary p-2 mb-1">
								<?= $item->message ?>
                                <div class="clearfix"></div>
                                <span class="float-right mt-1" style="font-size: 0.6em;"><?= date('d.m.y H:i:s', $item->created_at) ?></span>
                            </div>
                        </div>
                    </div>
				<? else: ?>
                    <div class="item-message clearfix">
                        <div class="float-left">
                            <small class="text-muted">
                                <span><?= $item->user->username ?></span>
                                <div class="clearfix"></div>
                                <span style="font-size: 0.8em;">Статус заявки: <?= $item->status->name ?></span>
                            </small><br>
                            <div class="badge badge-primary p-2 mb-1">
								<?= $item->message ?>
                                <div class="clearfix"></div>
                                <span class="float-right mt-1" style="font-size: 0.6em;"><?= date('d.m.y H:i:s', $item->created_at) ?></span>
                            </div>
                        </div>
                    </div>
				<? endif; ?>
			<? endif; ?>
		<? endforeach; ?>
    </div>

	<?php $form = ActiveForm::begin(['action' => 'message-create', 'id' => 'message-form', 'enableAjaxValidation' => false]); ?>
    <div class="form-group d-none">
		<?
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
    <div class="form-group">
		<?= Html::Button('Отправить', ['class' => 'btn btn-success', 'id'=>'button-submit']) ?>
    </div>

	<?php ActiveForm::end(); ?>
