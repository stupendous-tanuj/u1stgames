<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

class GamesController extends Zend_Controller_Action
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

$sql = "SELECT gameid, logo, gamename FROM games";
$games = $DB->fetchAll($sql);



$this->view->assign('datas',$games);
  }
  
}
?>