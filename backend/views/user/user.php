<?php
/* @var $this yii\web\View */

use yii\bootstrap4\ActiveForm;
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
	<? if(count($user->orgs) > 0): ?>
        <h2>Управление прикрепленными организациями</h2>
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
									<? echo Html::a('Удалить', Url::to(['user/delete-con', 'idorg' => $item->id, 'iduser' => $user->id]), ['style' => 'float: right;']) ?>
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
    <?
    $username = $user->username;
    $email = $user->email;
    ?>
	<h2>Изменение личных данных пользователя</h2>
	<?php if (!empty($result)): ?>
		<div class="alert alert-success" role="alert"><?= $result ?></div>
	<?php endif; ?>
	<?php $form = ActiveForm::begin(['id' => 'edit-user']); ?>
	<div class="col">
		<?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => 'Псевдоним...'])->label('Новый псевдоним ('.$username.')') ?>
	</div>
	<div class="col">
		<?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => 'Email...'])->label('Новый Email ('.$email.')') ?>
	</div>
	<div class="col">
		<?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => 'Пароль...'])->label('Новый пароль') ?>
	</div>
    <div class="col">
		<?= $form->field($model, 'role')->dropDownList([
			'1' => 'Администратор',
			'2' => 'Менеджер',
			'3' => 'Пользователь'
		], ['prompt' => 'Выберите уровень...'])->label('Новый уровень доступа ('.getAccess($user->id).')'); ?>
    </div>
	<div class="col">
		<?= Html::submitButton('Изменить', ['class' => 'btn btn-primary btn-block', 'name' => 'edit-user-button']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
