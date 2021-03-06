<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$ipapp_db = require(__DIR__ . '/ipapp_db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'default/doc',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'GoL3AVl-fp_htIWg_-AfIFAFKsoWbhA1',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 1,
        ],
        'errorHandler' => [
            'errorAction' => 'default/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'ipapp_db' => $ipapp_db,
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET /doc' => 'default/doc',
                'GET patents/view/<application_no:\w+>' => 'patent/view',
                'GET patents/<application_no:\w+>/change-of-bibliographic-data' => 'patent/change-of-bibliographic-data',
                'GET patents/<application_no:\w+>/unpaid-fees' => 'patent/unpaid-fees',
                'GET patents/due/<days:(\-?)\d+>' => 'patent/due',
                'GET patents/<application_no:\w+>/latest-unpaid-fee' => 'patent/latest-unpaid-fee',
                'GET patents/<application_no:\w+>/latest-unpaid-fees' => 'patent/latest-unpaid-fees',
                'GET patents/<application_no:\w+>/paid-fees' => 'patent/paid-fees',
                'GET patents/<application_no:\w+>/overdue-fees' => 'patent/overdue-fees',
                'POST patents' => 'patent/create',
                'PUT patents' => 'patent/update',
                'POST patents/<application_no:\w+>/fees' => 'patent/update-fees',
                'GET patents/list' => 'patent/list'
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
