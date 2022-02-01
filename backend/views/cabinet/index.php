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
			'email:email',
			'role'
		],
	]) ?>
</div>
