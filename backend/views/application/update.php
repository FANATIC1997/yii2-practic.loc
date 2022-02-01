<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->title = 'Изменение заявки: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->theme, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="application-update">

    <h1>Заявка: <?= Html::encode($model->theme) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
