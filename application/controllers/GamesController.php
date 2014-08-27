<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Registry.php';

class GamesController extends Zend_Controller_Action
{
  public function indexAction()
  {
   
   
$registry = Zend_Registry::getInstance();  
$DB = $registry['DB'];

$sql = "SELECT gameid, logo, gamename FROM games";
$games = $DB->fetchAll($sql);



$this->view->assign('datas',$games);
  }
  
}
?>