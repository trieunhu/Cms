<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'posts' => [
            'class' => 'backend\modules\posts\PostModule',
        ],
        'backup' => [
            'class' => 'spanjeta\modules\backup\Module',
        ],
        'config' => [
            'class' => 'backend\modules\config\ConfigModule',
        ],
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'd-m-Y',
            'datetimeFormat' => 'd-m-Y H:i:s',
            'timeFormat' => 'H:i:s',
            'locale' => 'vi', //your language locale
            'defaultTimeZone' => 'Asia/Ho_Chi_Minh', // time zone
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'language' => 'vi',
    'params' => $params,
];
