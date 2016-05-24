<?php
return [
    'components' => [
        'db'        => [
            'class'             =>  'yii\db\Connection',
            'dsn'               =>  'mysql:host=192.168.1.179;dbname=student_guide',
            'username'          =>  'svnuser',
            'password'          =>  'pXc9nbmrnC',
            'charset'           =>  'utf8',
            'tablePrefix'       =>  'sg_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'sivabalan.s@technoduce.com',
                'password' => 'NattaGuru02323447!',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
    ],
];
