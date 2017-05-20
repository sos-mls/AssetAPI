<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    
    'name'=>'Cron',
 
    'preload'=>array('log'),
 
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*',
    ),

    // We'll log cron messages to the separate files
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),

        'request' => array(
            'hostInfo' => 'https://domainname.com',
            'baseUrl' => '',
            'scriptUrl' => '',
        ),
 
        // Your DB connection
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=AssetAPIDB',
            'username' => 'root',
            'password' => 'default_password',
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
    ),
    // application-level parameters that can be accessed using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);