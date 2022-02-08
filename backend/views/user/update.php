<?php

use backend\models\Organization;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $error backend\controllers\UserController */
/* @var $orgs Organization */

$this->title = 'Изменение пользователя: ' . $model->id;
?>
<div class="user-update container" style="margin-top: 3.5em;">

    <? if(!is_null($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
    <? endif; ?>
    <h2>Изменение личных данных пользователя</h2>
    <?= $this->render('_form', [
        'model' => $model,
        'orgs' => $orgs,
    ]) ?>

</div>
