<?php

use backend\models\Application;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $log backend\models\Log */
/* @var $logs backend\models\Log */
/* @var $message backend\models\Message */
/* @var $messages backend\models\Message */

$this->title = $model->theme;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->theme;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($model->theme) ?></h1>
	<? if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
			<?= $error ?>
        </div>
	<? endif; ?>
    <div class="row">
        <div class="col mb-2">
			<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mb-2']) ?>
			<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger mb-2',
				'data' => [
					'confirm' => 'Вы уверены что хотите удалить?',
					'method' => 'post',
				],
			]) ?>

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
        </div>
    </div>


    <div class="row">
        <div class="col mb-2">
            <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                <li class="nav-item">
					<?= Html::a('История', '#pills-history', ['class' => 'nav-link active', 'id' => 'pills-history-tab', 'data-toggle' => 'pill', 'role' => 'tab', 'aria-controls' => 'pills-history', 'aria-selected' => 'true']) ?>
                </li>
				<? if ($model->status_id < 4): ?>
                    <li class="nav-item">
						<?= Html::a('Чат', '#pills-message', ['class' => 'nav-link', 'id' => 'pills-message-tab', 'data-toggle' => 'pill', 'role' => 'tab', 'aria-controls' => 'pills-message', 'aria-selected' => 'false']) ?>
                    </li>
				<? endif; ?>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-history" role="tabpanel"
                     aria-labelledby="pills-history-tab">
					<?= GridView::widget([
						'dataProvider' => $logs,
						'summary' => false,
						'columns' => [
							[
								'attribute' => 'user_id',
								'value' => function ($data) {
									return $data->user->username;
								}
							],
							[
								'attribute' => 'status_id',
								'content' => function ($data) {
									$ap = new Application();
									$str = $ap->getColor($data);
									$react = $data->getBackStatus($data);
									return $str . $react;
								}
							],
							'comment',
							[
								'attribute' => 'created_at',
								'value' => function ($data) {
									return date('d.m.Y H:i:s', $data->created_at);
								}
							],
						],
					]); ?>

                    <p>
						<? if ($model->status_id < 4): ?>
						<?php $form = ActiveForm::begin(); ?>

						<? if (Yii::$app->user->can('manager')): ?>
						<? if ($model->status_id == 1): ?>

                    <div class="form-group">
						<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="form-group">
						<?= Html::submitButton('В работу', ['class' => 'btn btn-success']) ?>
                    </div>

				<? elseif ($model->status_id == 2): ?>

                    <div class="form-group">
						<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="form-group">
						<?= Html::submitButton('Завершить', ['class' => 'btn btn-success']) ?>
                    </div>

				<? elseif ($model->status_id == 3 and Yii::$app->user->getId() == $model->user_id): ?>

                    <div class="form-group">
						<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
						<?= Html::submitButton('Закрыть', ['class' => 'btn btn-success']) ?>
                    </div>

				<? endif; ?>
				<? endif; ?>

				<? if (Yii::$app->user->can('user')): ?>
					<? if ($model->status_id == 3): ?>

                        <div class="form-group">
							<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="form-group">
							<?= Html::submitButton('Закрыть', ['class' => 'btn btn-success']) ?>
                        </div>

					<? endif; ?>
				<? endif; ?>
				<?php ActiveForm::end(); ?>
				<? endif; ?>
                    </p>
                </div>
				<? if ($model->status_id < 4): ?>
                <div class="tab-pane fade" id="pills-message" role="tabpanel" aria-labelledby="pills-message-tab">
					<?= $this->render('message', [
						'message' => $message,
						'messages' => $messages,
						'application' => $model,
					]) ?>
					<? endif; ?>
                </div>

            </div>
        </div>
    </div>


</div>
