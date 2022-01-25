<?php

/* @var $this yii\web\View */
/* @var $organizations \backend\models\organization */

$this->title = 'Организации';
?>
<div class="site-user">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Наименование</th>
            <th scope="col">Адрес</th>
            <th scope="col">Контакты</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
		<? foreach ($organizations as $key => $item): ?>
            <tr>
                <th scope="row"><?= $item->id ?></th>
                <td><?= $item->name ?></td>
                <td><?= $item->address ?></td>
                <td><?= $item->contact ?></td>
                <td>Изменить</td>
            </tr>
		<? endforeach; ?>
        </tbody>
    </table>
</div>