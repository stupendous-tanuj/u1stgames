<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', true);
date_default_timezone_set('Asia/Calcutta');

$rootDir = dirname(dirname(__FILE__));
set_include_path($rootDir . '\library');

require_once 'Zend/Controller/Front.php';
Zend_Controller_Front::run('../application/controllers');

?>