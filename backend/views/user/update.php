<?php
use kartik\select2\Select2;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Изменение пользователя: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="user-update">

    <h1><?= Html::encode($model->username) ?></h1>

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
