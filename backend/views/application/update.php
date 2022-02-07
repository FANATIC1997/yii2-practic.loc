<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->title = 'Изменение заявки: ' . $model->id;
?>
<div class="application-update container" style="margin-top: 3.5em;">

    <h1>Заявка: <?= Html::encode($model->theme) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
