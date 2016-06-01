<?php
return [
    'vendorPath' 	=> dirname(dirname(__DIR__)) . '/vendor',
    'components' 	=> [
    	'resourceManager' 	=> [
            'class' 		=> 'common\components\S3ResourceManager',
            'key' 			=> 'AKIAIQDHFFLB54ESCRYQ',
            'secret' 		=> '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',
            'bucket'		=> 'studentguide',
        ],
        'cache'				=> [
            'class' 			=> 'yii\caching\FileCache',
        ],
    ],
];
