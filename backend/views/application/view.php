<?php

use backend\models\Application;
use backend\models\Roles;
use backend\models\User;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use yii\bootstrap4\Html;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */
/* @var $log backend\models\Log */
/* @var $logs backend\models\Log */
/* @var $logsUser backend\models\Log */
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
        <div class="col mb-4 mr-3">
            <div class="row ml-1 mb-3">
                <div class="d-flex justify-content-center">
                    <div class="col-xl col-md-12 p-0">
                        <div class="card user-card-full border-0">
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
									<?php if($model->rating): ?>
                                        <div class="rating-result">
                                            <span <?= ($model->rating >= 1) ? 'class="active"' : '' ?>></span>
                                            <span <?= ($model->rating >= 2) ? 'class="active"' : '' ?>></span>
                                            <span <?= ($model->rating >= 3) ? 'class="active"' : '' ?>></span>
                                            <span <?= ($model->rating >= 4) ? 'class="active"' : '' ?>></span>
                                            <span <?= ($model->rating >= 5) ? 'class="active"' : '' ?>></span>
                                        </div>
									<?php endif; ?>
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
                                        <h6 class="text-muted f-w-400" data-id="<?= $model->status_id ?>"
                                            id="status"><?= $model->getColor($model) ?></h6>
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
			<?php if (!empty($logsUser)): ?>
                <div class="row ml-1 mb-4 log-user">
                    <h5>Изменения пользователей</h5>
					<?php foreach ($logsUser as $item): ?>
                        <div class="col-12 mt-4">
							<?php if (!is_null($item->oldUser)): ?>
                                <div class="item">
                                    <div class="item-text">
                                        Был изменен пользователь на <?= $item->oldUser->username ?>
                                    </div>
                                    <div class="item-time">
										<?= date_format(date_create($item->create_time), 'd.m.Y H:i:s') ?>
                                    </div>
                                </div>
							<?php endif; ?>

							<?php if (!is_null($item->oldManager)): ?>
                                <div class="item">
                                    <div class="item-text">
                                        Был изменен менеджер на <?= $item->oldManager->username ?>
                                    </div>
                                    <div class="item-time">
										<?= date_format(date_create($item->create_time), 'd.m.Y H:i:s') ?>
                                    </div>
                                </div>
							<?php endif; ?>
                        </div>
					<?php endforeach; ?>
                </div>
			<? endif; ?>
        </div>

        <div class="col tabs mr-3 ml-3">
            <ul class="nav nav-pills mb-2 ml-1" id="pills-tab" role="tablist">
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
                <div class="tab-pane fade show history active ml-1" id="pills-history" role="tabpanel"
                     aria-labelledby="pills-history-tab">
					<?= GridView::widget([
						'dataProvider' => $logs,
						'summary' => false,
						'emptyText' => 'Записи в истории не найдены',
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
								'attribute' => 'create_time',
								'value' => function ($data) {
									return date_format(date_create($data->create_time), 'd.m.Y H:i:s');
								}
							],
						],
					]); ?>

					<?php if ($model->status_id < 4 or $model->status_id == 5): ?>
						<?php $form = ActiveForm::begin(); ?>

						<?php if ($access['item_name'] == User::MANAGER or $access['item_name'] == User::ADMIN): ?>
							<?php if ($model->status_id == 1): ?>

                                <div class="form-group">
									<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                                </div>

                                <div class="form-group">
									<?= Html::submitButton('В работу', ['class' => 'btn btn-success', 'name' => 'next']) ?>
                                </div>

							<?php elseif ($model->status_id == 2 or $model->status_id == 5): ?>

                                <div class="form-group">
									<?= $form->field($log, 'comment')->textInput(['maxlength' => true]) ?>
                                </div>

                                <div class="form-group">
									<?= Html::submitButton('Завершить', ['class' => 'btn btn-success', 'name' => 'next']) ?>
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
								<?= Html::submitButton('Закрыть', ['class' => 'btn btn-success', 'name' => 'next']) ?>
								<?= Html::submitButton('Вернуть в работу', ['class' => 'btn btn-primary', 'name' => 'back']) ?>
                            </div>


						<?php endif; ?>
						<?php ActiveForm::end(); ?>
					<?php endif; ?>
                </div>


                <div class="tab-pane fade message-block ml-1" id="pills-message" role="tabpanel"
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
	<?php if (!$model->rating and !$model->review): ?>
		<?php if ($model->status_id >= 3 and $model->user_id == $access['user_id']): ?>
			<?php Modal::begin(['title' => 'Оценка заявки', 'id' => 'modalReview']) ?>
			<?php $form = ActiveForm::begin(['action' => 'new-review?id=' . $model->id, 'method' => 'POST', 'id' => 'modal-review']); ?>
            <div class="form-group">
                <label>Ваша оценка</label>
                <div class="rating">

                    <input type="radio" id="star-5" name="rating" value="5">
                    <label for="star-5" title="Все отлично"></label>

                    <input type="radio" id="star-4" name="rating" value="4">
                    <label for="star-4" title="Сделано с ошибками"></label>

                    <input type="radio" id="star-3" name="rating" value="3">
                    <label for="star-3" title="Сделано но плохо"></label>

                    <input type="radio" id="star-2" name="rating" value="2">
                    <label for="star-2" title="Что-то сделано но очень плохо"></label>

                    <input type="radio" id="star-1" name="rating" value="1">
                    <label for="star-1" title="Ужасно, не чего не сделано"></label>

                </div>
            </div>
            <div class="review-area">
                <div class="form-group">
                    <label for="review-area">Ваш комментарий</label>
                    <textarea class="form-control" id="review-area" name="review" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group">
				<?= Html::submitButton('Закрыть', ['class' => 'btn btn-success', 'name' => 'next', 'id' => 'next']) ?>
				<?= Html::submitButton('Вернуть в работу', ['class' => 'btn btn-primary', 'name' => 'back', 'id' => 'back', 'style' => 'display: none;']) ?>
            </div>
			<?php ActiveForm::end(); ?>
			<?php Modal::end() ?>
		<?php endif; ?>
	<?php endif; ?>
</div>
