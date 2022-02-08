<?php

use backend\models\Application;
use backend\models\Roles;
use backend\models\User;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap4\Html;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $log backend\models\Log */
/* @var $logs backend\models\Log */
/* @var $message backend\models\Message */
/* @var $messages backend\models\Message */

$this->title = $model->theme;
YiiAsset::register($this);
$role = new Roles();
$access = $role->getRole();
?>
<div class="application-view container-fluid" style="padding-top: 5em;">

	<?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
			<?= $error ?>
        </div>
	<?php endif; ?>

    <div class="row mb-4">
        <div class="col mb-4">
            <div class="d-flex justify-content-center">
                <div class="col-xl col-md-12 p-0">
                    <div class="card user-card-full">
                        <div class="card-block">
                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">
								<?= Html::encode($model->theme) ?>
                                ID: <?= $model->id ?>
                                <div class="float-right clearfix" style="margin-top: -15px;">
									<?php if ($access['item_name'] == User::ADMIN or $access['item_name'] == User::MANAGER): ?>
										<?php if ($access['user_id'] == $model->user_id or $access['item_name'] == User::ADMIN): ?>
											<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mb-2']) ?>
											<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
												'class' => 'btn btn-danger mb-2',
												'data' => [
													'confirm' => 'Вы уверены что хотите удалить?',
													'method' => 'post',
												],
											]) ?>
										<?php endif; ?>
									<?php endif; ?>
									<?php if ($access['item_name'] == User::USER): ?>
										<?php if ($access['user_id'] == $model->user_id): ?>
											<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mb-2']) ?>
										<?php endif; ?>
									<?php endif; ?>
                                </div>
                            </h6>
                            <div class="row w-100">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600" style="font-size: 1.4em">Тема</p>
                                    <h6 class="text-muted f-w-400"><?= $model->theme ?></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600" style="font-size: 1.4em">Организация</p>
                                    <h6 class="text-muted f-w-400"><?= $model->organization->name ?></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600" style="font-size: 1.4em">Пользователь</p>
                                    <h6 class="text-muted f-w-400"><?= $model->user->username ?></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600" style="font-size: 1.4em">Номер</p>
                                    <h6 class="text-muted f-w-400"><?= '+7' . $model->user->phone ?></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600" style="font-size: 1.4em">Менеджер</p>
                                    <h6 class="text-muted f-w-400"><?= $model->manager->username ?></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600" style="font-size: 1.4em">Статус</p>
                                    <h6 class="text-muted f-w-400"><?= $model->getColor($model) ?></h6>
                                </div>
                                <div class="col-sm-12">
                                    <p class="m-b-10 f-w-600" style="font-size: 1.4em">Описание</p>
                                    <h6 class="text-muted f-w-400"><?= $model->description ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                <li class="nav-item">
					<?= Html::a('История', '#pills-history', [
						'class' => 'nav-link active',
						'id' => 'pills-history-tab',
						'data-toggle' => 'pill',
						'role' => 'tab',
						'aria-controls' => 'pills-history',
						'aria-selected' => 'true'
					]) ?>
                </li>
                <li class="nav-item">
					<?= Html::a('Чат', '#pills-message', [
						'class' => 'nav-link',
						'id' => 'pills-message-tab',
						'data-toggle' => 'pill',
						'role' => 'tab',
						'aria-controls' => 'pills-message',
						'aria-selected' => 'false'
					]) ?>
                </li>
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

					<?php if ($model->status_id < 4): ?>
						<?php $form = ActiveForm::begin(); ?>

						<?php if ($access['item_name'] == User::MANAGER or $access['item_name'] == User::ADMIN): ?>
							<?php if ($model->status_id == 1): ?>

                                <div class="form-group">
									<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                                </div>

                                <div class="form-group">
									<?= Html::submitButton('В работу', ['class' => 'btn btn-success']) ?>
                                </div>

							<?php elseif ($model->status_id == 2): ?>

                                <div class="form-group">
									<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                                </div>

                                <div class="form-group">
									<?= Html::submitButton('Завершить', ['class' => 'btn btn-success']) ?>
                                </div>

							<?php elseif ($model->status_id == 3 and $access['user_id'] == $model->user_id): ?>

                                <div class="form-group">
									<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                                </div>

                                <div class="form-group">
									<?= Html::submitButton('Закрыть', ['class' => 'btn btn-success', 'name' => 'next']) ?>
									<?= Html::submitButton('Вернуть в работу', ['class' => 'btn btn-primary', 'name' => 'back']) ?>
                                </div>

							<?php endif; ?>
						<?php endif; ?>

						<?php if ($access['item_name'] == User::USER and $model->status_id == 3): ?>


                            <div class="form-group">
								<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                            </div>

                            <div class="form-group">
								<?= Html::submitButton('Закрыть', ['class' => 'btn btn-success']) ?>
								<?= Html::submitButton('Вернуть в работу', ['class' => 'btn btn-primary']) ?>
                            </div>


						<?php endif; ?>
						<?php ActiveForm::end(); ?>
					<?php endif; ?>
                </div>


                <div class="tab-pane fade message-block" id="pills-message" role="tabpanel"
                     aria-labelledby="pills-message-tab" style="min-width: 300px;">
					<?= $this->render('message', [
						'message' => $message,
						'messages' => $messages,
						'application' => $model,
					]) ?>
                </div>

            </div>
        </div>
    </div>
</div>
