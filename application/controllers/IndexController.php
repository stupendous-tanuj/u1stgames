<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

class IndexController extends Zend_Controller_Action
{
  public function indexAction()
  {
   
   $params = array('host'		=>'localhost',
                'username'	=>'root',
				'password'  =>'',
				'dbname'	=>'u1stxen'
               );
$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
   
$DB->setFetchMode(Zend_Db::FETCH_OBJ);

$sql = "SELECT gv.gameid, SUM(gv.vote),g.hdlogo, g.gamename FROM game_votes gv,games g Where g.gameid = gv.gameid AND date > ADDDATE(CURDATE(), -7) GROUP BY gv.gameid ORDER BY SUM(gv.vote) DESC LIMIT 10";
$week = $DB->fetchAll($sql);



$this->view->assign('datas',$week);
 
 }
  
}
?>