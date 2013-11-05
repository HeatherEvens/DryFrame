<?php
define('SYSTEM_PATH','../system');
define('DEFAULT_CONTROLLER','form');
include (SYSTEM_PATH.'/config/config.php');

spl_autoload_register(function($class_name) {
  $class_name = str_replace('\\','/',$class_name);
  if (strpos($class_name,'/') !== 0)
    $class_name = '/'.$class_name;
  include_once SYSTEM_PATH.'/core'.$class_name.'.php';
});
spl_autoload_register(function($class_name) {
  $class_name = str_replace('\\','/',$class_name);
  if (strpos($class_name,'/') !== 0)
    $class_name = '/'.$class_name;
  include_once SYSTEM_PATH . $class_name . '.php';
});

$dry = DryFrame::getInstance();

$dry->go();