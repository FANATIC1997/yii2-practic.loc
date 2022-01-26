<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \backend\models\CreateUserForm */
/* @var $user \backend\models\CreateUserForm */

/* @var $users \backend\models\user */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Пользователи';
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
<div class="site-user">
	<? if (!empty($result)): ?>
        <div class="alert alert-success" role="alert"><?= $result ?></div>
	<? endif; ?>
    <div class="row">
		<?php $form = ActiveForm::begin(['id' => 'create-user', 'options' => ['style' => 'display: flex']]); ?>
        <div class="col">
			<?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => 'Псевдоним...'])->label('') ?>
        </div>
        <div class="col">
			<?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => 'Email...'])->label('')?>
        </div>
        <div class="col">
			<?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => 'Пароль...'])->label('')?>
        </div>
        <div class="col">
            <?= $form->field($model, 'role')->dropDownList([
				'1' => 'Администратор',
				'2' => 'Менеджер',
				'3'=>'Пользователь'
			], ['prompt' => 'Выберите уровень...'])->label(''); ?>
        </div>
        <div class="col">
				<?= Html::submitButton('Добавить', ['class' => 'btn btn-primary btn-block', 'name' => 'create-user-button', 'style' => 'margin-top: 13.5%']) ?>
        </div>
    </div>

	<?php ActiveForm::end(); ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Псевдоним</th>
            <th scope="col">Email</th>
            <th scope="col">Уровень доступа</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
		<? foreach ($users as $key => $item): ?>
            <tr class="line">
                <th scope="row"><?= $item->id ?></th>
                <td><?= $item->username ?></td>
                <td><?= $item->email ?></td>
                <td><?= getAccess($item->id) ?></td>
                <td>
					<? echo Html::a('Удалить', Url::to(['user/delete', 'id' => $item->id])) ?>
					<? echo Html::a('Просмотр', Url::to(['user/view', 'id' => $item->id])) ?>
					<? echo Html::a('Изменить', Url::to(['user/edit', 'id' => $item->id])) ?>
                </td>
            </tr>
		<? endforeach; ?>
        <? if(!is_null($user)): ?>
            <tr class="line">
                <th scope="row"><?= $user->id ?></th>
                <td><?= $user->username ?></td>
                <td><?= $user->email ?></td>
                <td><?= getAccess($user->id) ?></td>
                <td>
					<? echo Html::a('Удалить', Url::to(['user/delete', 'id' => $user->id])) ?>
					<? echo Html::a('Просмотр', Url::to(['user/view', 'id' => $user->id])) ?>
					<? echo Html::a('Изменить', Url::to(['user/edit', 'id' => $user->id])) ?>
                </td>
            </tr>
        <? endif; ?>
        </tbody>
    </table>
</div>