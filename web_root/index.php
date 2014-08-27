<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', true);
date_default_timezone_set('Asia/Calcutta');

$rootDir = dirname(dirname(__FILE__));
set_include_path($rootDir.'/library');

require_once 'Zend/Controller/Front.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

$params = array('host'		=>'localhost',
                'username'	=>'root',
				'password'  =>'',
				'dbname'	=>'u1stxen'
               );
$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
    
$DB->setFetchMode(Zend_Db::FETCH_OBJ);
Zend_Registry::set('DB',$DB);


Zend_Controller_Front::run('../application/controllers');

?>