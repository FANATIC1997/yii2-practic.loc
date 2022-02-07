<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Личный кабинет';
?>
<div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'username',
			[
				'attribute' => 'phone',
				'value' => function ($data) {
					return '+7'.$data->phone;
				}
			],
			'email:email',
			'role'
		],
	]) ?>

    <!--<div class="cabinet">
        <div class="d-flex justify-content-center">
            <div class="col-xl col-md-12">
                <h1><?= Html::encode($this->title) ?></h1>
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"><img src="https://img.icons8.com/bubbles/100/000000/user.png"
                                                         class="img-radius" alt="User-Profile-Image"></div>
                                <h6 class="f-w-600"><?=$model->username?></h6>
                                <p><?=$model->role?></p>
								<?= Html::a('<i class="mdi mdi-square-edit-outline feather icon-edit"></i>', ['update', 'id' => $model->id], ['style'=>'color: white;']) ?>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Информация</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400"><?=$model->email?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Телефон</p>
                                        <h6 class="text-muted f-w-400"><?='+7'.$model->phone?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>!-->
</div>
