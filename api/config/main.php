<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                        =>  'app-api',
    'basePath'                  =>  dirname(__DIR__),
    'controllerNamespace'       =>  'api\controllers',
    'bootstrap'                 =>  ['log'],
    'modules'                   =>  [
        'v1'                        =>  [
            'basePath'                  =>  '@app/modules/v1',
            'class'                     =>  'api\modules\v1\Module',
        ]
    ],
    'components'                =>  [
        'user'                  =>  [
            'identityClass'     =>  'common\models\User',
            'enableAutoLogin'   =>  false,
        ],
        'i18n'                  =>  [
            'translations'      =>      [
                'api*'              =>  [
                    'class'             =>  'yii\i18n\PhpMessageSource',
                    'basePath'          =>  '@common/messages',
                ],
            ],
        ],
        'log'                   =>  [
            'traceLevel'            =>  YII_DEBUG ? 3 : 0,
            'targets'                   =>  [
                [
                    'class'                 =>  'yii\log\FileTarget',
                    'levels'                =>  ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler'          =>  [
            'errorAction'           =>  'site/error',
        ],
        'urlManager'            =>  [
            'enablePrettyUrl'       =>  true,
            'showScriptName'        =>  true,
            'rules'                 =>  [
                [
                    'class'         =>  'yii\rest\UrlRule',
                    'controller'    =>  'v1/base',
                    'pluralize'     =>  false,
                    'extraPatterns' =>  [
                        'GET index1'    =>  'index1',
                    ],
                ],
                [
                    'class'         =>  'yii\rest\UrlRule',
                    'controller'    =>  ['v1/category'],
                    'extraPatterns' =>  [
                        'GET index'     =>  'index',
                    ],
                ],
                [
                    'class'         =>  'yii\rest\UrlRule',
                    'controller'    =>  ['v1/vendor'],
                    'extraPatterns' =>  [
                        'GET index'     =>  'index',
                    ],
                ],
                [
                    'class'         =>  'yii\rest\UrlRule',
                    'controller'    =>  ['v1/vendor'],
                    'extraPatterns' =>  [
                        'GET arealist'     =>  'arealist',
                    ],
                ],
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
    ],
    'params'                    =>  $params,
];