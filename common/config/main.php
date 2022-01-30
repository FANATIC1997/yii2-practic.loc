<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
	    // выполнить команду yii migrate --migrationPath=@yii/rbac/migrations
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],
    ],
];
