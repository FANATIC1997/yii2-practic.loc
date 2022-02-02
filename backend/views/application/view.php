<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $log backend\models\Log */

$this->title = $model->theme;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->theme;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($model->theme) ?></h1>

    <p>
		<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Вы уверены что хотите удалить?',
				'method' => 'post',
			],
		]) ?>
    </p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'theme',
			'description',
			[
				'attribute' => 'organization',
				'value' => function ($data) {
					return $data->organization->name;
				}
			],
			[
				'attribute' => 'user',
				'value' => function ($data) {
					return $data->user->username;
				}
			],
			[
				'attribute' => 'Телефон',
				'value' => function ($data) {
					return '+7' . $data->user->phone;
				}
			],
			[
				'attribute' => 'manager',
				'value' => function ($data) {
					return $data->manager->username;
				}
			],
			[
				'attribute' => 'status',
				'value' => function ($data) {
					return $data->status->name;
				}
			],
		],
	]) ?>

    <p>
		<? if ($model->status_id < 4): ?>
		    <?php $form = ActiveForm::begin(); ?>
                <div class="form-group">
                    <?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                </div>
                <?= $form->field($log, 'application_id')->hiddenInput(['value'=> $model->id])->label(false); ?>
                <?= $form->field($log, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false); ?>

                <? if (Yii::$app->user->can('manager')): ?>
                    <? if ($model->status_id == 1): ?>

						<?= $form->field($log, 'status_id')->hiddenInput(['value'=> 2])->label(false); ?>

                        <div class="form-group">
							<?= Html::submitButton('В работу', ['class' => 'btn btn-success']) ?>
                        </div>

                    <? elseif ($model->status_id == 2): ?>

						<?= $form->field($log, 'status_id')->hiddenInput(['value'=> 3])->label(false); ?>

                        <div class="form-group">
							<?= Html::submitButton('Завершить', ['class' => 'btn btn-success']) ?>
                        </div>

                    <? endif; ?>
                <? endif; ?>

                <? if (Yii::$app->user->can('user')): ?>
                    <? if ($model->status_id == 3): ?>

						<?= $form->field($log, 'status_id')->hiddenInput(['value'=> 4])->label(false); ?>

                        <div class="form-group">
							<?= Html::submitButton('Закрыть', ['class' => 'btn btn-success']) ?>
                        </div>

                    <? endif; ?>
                <? endif; ?>
            <?php ActiveForm::end(); ?>
        <? endif; ?>
    </p>

</div>
