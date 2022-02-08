<?php

use backend\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */
/* @var $users User */

$this->title = 'Добавление информации об организации';
?>
<div class="organization-create container" style="margin-top: 3.5em;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'users' => $users,
    ]) ?>

</div>
