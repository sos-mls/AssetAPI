<?php

return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    
    'name'=>'Cron',
 
    'preload'=>['log'],
 
    'import'=>[
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*',
    ],

    // We'll log cron messages to the separate files
    'components'=>[
        'log'=>[
            'class'=>'CLogRouter',
            'routes'=>[
                [
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ],
                [
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ],
            ],
        ],

        'request' => [
            'hostInfo' => 'https://domainname.com',
            'baseUrl' => '',
            'scriptUrl' => '',
        ],
 
        // Your DB connection
        'db' => [
            'connectionString' => 'mysql:host=localhost;dbname=AssetAPIDB',
            'username' => 'root',
            'password' => 'default_password',
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
    ],
    // application-level parameters that can be accessed using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
];