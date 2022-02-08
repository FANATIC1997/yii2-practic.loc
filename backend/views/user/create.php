<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $orgs backend\models\Organization */

$this->title = 'Создание пользователя';
?>
<div class="user-create container" style="margin-top: 3.5em;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'orgs' => $orgs
    ]) ?>

</div>
