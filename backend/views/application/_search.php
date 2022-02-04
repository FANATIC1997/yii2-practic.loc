<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ApplicationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?
	$valueFilter = '';
	$selectedValue = 'ApplicationSearch[theme]';
    $idInput = 'applicationsearch-theme';
	if (isset($_GET['ApplicationSearch'])) {
		if (isset($_GET['ApplicationSearch']['theme'])) {
			$valueFilter = $_GET['ApplicationSearch']['theme'];
		} elseif (isset($_GET['ApplicationSearch']['status'])) {
			$valueFilter = $_GET['ApplicationSearch']['status'];
			$selectedValue = 'ApplicationSearch[status]';
			$idInput = 'applicationsearch-status';
		} elseif (isset($_GET['ApplicationSearch']['user'])) {
			$valueFilter = $_GET[ 'ApplicationSearch']['user'];
			$selectedValue = 'ApplicationSearch[user]';
			$idInput = 'applicationsearch-user';
		} elseif (isset($_GET['ApplicationSearch']['organization'])) {
			$valueFilter = $_GET['ApplicationSearch']['organization'];
			$selectedValue = 'ApplicationSearch[organization]';
			$idInput = 'applicationsearch-organization';
		} elseif (isset($_GET['ApplicationSearch']['manager'])) {
			$valueFilter = $_GET['ApplicationSearch']['manager'];
			$selectedValue = 'ApplicationSearch[manager]';
			$idInput = 'applicationsearch-manager';
		}
	}
    ?>

    <div class="form-group" style="display: none;">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="mb-2 d-flex justify-content-between align-items-center">
        <div class="position-relative w-50">
            <span class="position-absolute search"><i class="fa fa-search"></i></span>
            <input id="<?=$idInput?>" class="form-control w-100" type="text" style="border: none; padding-left: 32px;"
                   placeholder=" Поиск..." name="<?=$_GET['filter']?>" value="<?=$valueFilter?>">
        </div>
        <div class="px-2">
			<?
			$items = [
				'ApplicationSearch[theme]' => 'Тема',
				'ApplicationSearch[status]' => 'Статус',
				'ApplicationSearch[user]' => 'Пользователь',
				'ApplicationSearch[organization]' => 'Организация',
				'ApplicationSearch[manager]' => 'Менеджер'
			];
			?>
			<?= Html::dropDownList('filter', $selectedValue, $items, ['id' => 'filter_drop']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
