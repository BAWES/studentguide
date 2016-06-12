<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=studentguide',
            'username' => 'stguide',
            'password' => 'rj66J3QVTKtMZSPj',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'slack' => [
            'class' => 'understeam\slack\Client',
            'url' => 'https://hooks.slack.com/services/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',
            'username' => 'studentguideq8.com',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'common\components\SlackLogger',
                    'logVars' => [],
                    'levels' => ['info', 'error', 'warning'],
                    'categories' => ['backend\*', 'api\*', 'frontend\*', 'common\*', 'console\*'],
                ],
            ],
        ],
    ],
];
