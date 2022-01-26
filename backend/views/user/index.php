<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Пользователь';
function getAccess($id): string
{
	$roles = Yii::$app->authManager->getRolesByUser($id);
	$access = 'Пользователь';
	if(isset($roles['admin']))
		$access = 'Администратор';
	if(isset($roles['manager']))
		$access = 'Менеджер';

	return $access;
}
?>
<div class="site-index">
	<? echo Html::a('<img src="../web/image/edit.svg" width="37" title="Изменить">', Url::to(['user/edit', 'id' => $user->id]), ['style' => 'float: right;']) ?>
    <? if(count($user->orgs) > 0): ?>
    <h2>Приклепленные организации</h2>
    <div class="container overflow-hidden">
		<? foreach (array_chunk($user->orgs, 3) as $array): ?>
            <div class="row gy-5">
				<? foreach ($array as $item): ?>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $item->name ?></h5>
                                <p class="card-text"><strong>Адрес:</strong> <?= $item->address?>
                                    <br/>
                                    <br/>
                                    <strong>Контакты:</strong> <?= $item->contact ?>
                                </p>
                            </div>
                        </div>
                    </div>
				<? endforeach; ?>
            </div>
		<? endforeach; ?>
    </div>
    <? else: ?>
    <h2>Прикрепленные организации не найдены</h2>
    <? endif; ?>
    <h2>Личные данные пользователя</h2>
    <div class="col">
        <div class="row">
            <p><strong>Псевдоним:</strong> <?= $user->username ?></p>
        </div>
        <div class="row">
			<p><strong>Email:</strong> <?= $user->email ?></p>
        </div>
        <div class="row">
			<p><strong>Уровень доступа:</strong> <?= getAccess($user->id) ?></p>
        </div>
    </div>
	<? echo Html::a('Назад', Url::to(['site/users', 'id' => $user->id]), ['style'=>'float: right;']) ?>
</div>