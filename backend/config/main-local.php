<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Jh2yPN4tvaEG1TX3GWE0qsyh-waN0zno',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]      = 'gii';
    $config['modules']['gii']   = [
        'class'         => 'yii\gii\Module',
        'allowedIPs'    =>  ['*'],
    ];
}

return $config;
