<?php

/* @var $this yii\web\View */
/* @var $applications backend\models\Application */

$this->title = 'Заявки';
?>
<div class="site-index">
    <pre>
        <?= var_dump($applications); ?>
    </pre>
    <? foreach ($applications as $item): ?>
        <?=$item->user->username ?>
        <?=$item->org->name ?>
        <?=$item->status->name?>
    <? endforeach; ?>
	Hello
</div>
