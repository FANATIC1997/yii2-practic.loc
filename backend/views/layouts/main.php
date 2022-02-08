<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
	<?php $this->beginBody() ?>

    <header>
		<?php
		NavBar::begin([
			'brandLabel' => Yii::$app->name,
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'class' => 'navbar navbar-expand-xl navbar-dark bg-dark fixed-top',
			],
		]);
		$logout = '<a class="dropdown-item">'
			. Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
			. Html::submitButton(
				'Выйти',
				['class' => 'btn btn-link logout', 'style' => 'color: #212529; text-decoration: none; padding: 0px;']
			)
			. Html::endForm()
			. '</a>';
		$menuItems = [];
		if (Yii::$app->user->isGuest) {
			$menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
		} else {
			$menuItems = [
				['label' => 'Dashboard', 'url' => ['/site/index']],
				['label' => 'Заявки', 'url' => ['/application/index']],
			];
			if (Yii::$app->user->can('admin')) {
				$menuItems[] = ['label' => 'Справочники', 'items' => [
					['label' => 'Пользователи', 'url' => ['/user/index']],
					['label' => 'Организации', 'url' => ['/organization/index']]
				]];
			}

			$menuItems[] = ['label' => Yii::$app->user->identity->username, 'items' => [
				['label' => 'Личный кабинет', 'url' => ['/cabinet/index']],
				$logout
			]];

		}
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav ml-auto'],
			'items' => $menuItems,
		]);
		NavBar::end();
		?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container-xxl">
			<?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

	<?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
