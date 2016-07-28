<?php
error_reporting(E_ALL &~E_NOTICE);
ini_set('display_errors',1);
ini_set('default_charset','utf-8');

defined("APPLICATION_PATH") || define("APPLICATION_PATH","./application");
defined("APPLICATION_ENV") || define("APPLICATION_ENV", "production");

set_include_path('./library/' . PATH_SEPARATOR . APPLICATION_PATH.'/modules');

require_once "Zend/Loader/Autoloader.php";
$loader = Zend_Loader_Autoloader::getInstance();
$loader->setFallbackAutoloader(true);

require_once "Zend/Application.php";
$application = new Zend_Application(
    APPLICATION_ENV,
    array(
	'phpSettings' => array('display_startup_errors' => 1, 'display_errors' => 1),
	'bootstrap'   => array('path' => APPLICATION_PATH . "/Bootstrap.php", "class" => "Bootstrap"),
    )
);

$application->bootstrap()->run();