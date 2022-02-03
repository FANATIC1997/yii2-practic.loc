<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'homeUrl' => '/adminpanel',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
			'baseUrl' => '/adminpanel',
        ],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
				'username' => 'shrammamb1997@gmail.com',
				'password' => 'Vbk.rjd4',
				'port' => '587', // Port 25 is a very common port too
				'encryption' => 'tls', // It is often used, check your provider or mail server specs
				'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]
			],
		],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
	'name' => 'Application',
    'params' => $params,
];
