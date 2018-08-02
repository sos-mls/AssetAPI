<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

require_once($yiit);

$files = array_merge(
    glob(dirname(__FILE__) . '/../vendor/fufu70/reflection-class/src/*.php'),
    glob(dirname(__FILE__) . '/../vendor/fufu70/file-class/src/*.php'),
    glob(dirname(__FILE__) . '/../vendor/fufu70/file-class/src/file/*.php'),
    glob(dirname(__FILE__) . '/../vendor/milf/common-php/src/*.php'),
    glob(dirname(__FILE__) . '/../vendor/milf/asset-library/src/*.php'),
    glob(dirname(__FILE__) . '/../vendor/milf/asset-library/src/action/*.php'),
    glob(dirname(__FILE__) . '/../vendor/milf/asset-library/src/file/*.php'),
    ['TestController.php']
);

foreach ($files as $file) {
    require_once($file);
}

Yii::createWebApplication($config);