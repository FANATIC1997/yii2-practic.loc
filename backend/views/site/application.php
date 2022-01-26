<?php

/* @var $this yii\web\View */
/* @var $applications backend\models\Application */

$this->title = 'Заявки';
?>
<div class="site-index">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Тема</th>
            <th scope="col">Организация</th>
            <th scope="col">Пользователь</th>
            <th scope="col">Статус</th>
        </tr>
        </thead>
        <tbody>
		<? foreach ($applications as $key => $item): ?>
            <?
                $status = $item->status->name;
                if($status == 'Закрыто') continue;
                $class = '';
                switch ($status){
                    case 'Новая':
						$class = 'new';
                        break;
                    case 'В работе':
						$class = 'work';
                        break;
                    case 'Готово':
						$class = 'complete';
                        break;
                }
            ?>
            <tr class="line <?=$class?>">
                <th scope="row"><?= $item->id ?></th>
                <td><?= $item->theme ?></td>
                <td><?= $item->org->name ?></td>
                <td><?= $item->user->username ?></td>
                <td><?= $status ?></td>
            </tr>
		<? endforeach; ?>
        </tbody>
    </table>
</div>
