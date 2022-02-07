<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Application */

$this->title = 'Создание заявки';
?>
<div class="application-create container" style="margin-top: 3.5em;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
