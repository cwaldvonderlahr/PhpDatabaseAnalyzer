<?php
$config = array(
    'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
            'PhpDatabaseAnalyzer' => dirname(__FILE__) . "/../libs/"
        )
    )
);

require_once 'Zend/Loader/AutoloaderFactory.php';
require_once 'Zend/Loader/StandardAutoloader.php';
require_once 'Zend/Loader/ClassMapAutoloader.php';
Zend\Loader\AutoloaderFactory::factory($config);
