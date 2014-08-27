<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Registry.php';

class IndexController extends Zend_Controller_Action
{
  public function indexAction()
  {
   
  $registry = Zend_Registry::getInstance();  
$DB = $registry['DB'];

$sql = "SELECT gv.gameid, SUM(gv.vote),g.hdlogo, g.gamename FROM game_votes gv,games g Where g.gameid = gv.gameid AND date > ADDDATE(CURDATE(), -7) GROUP BY gv.gameid ORDER BY SUM(gv.vote) DESC LIMIT 10";
$week = $DB->fetchAll($sql);



$this->view->assign('datas',$week);
 
 }
  
}
?>