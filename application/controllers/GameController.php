<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Session/Namespace.php';

class GameController extends Zend_Controller_Action
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

$sql = "SELECT gv.gameid, SUM( gv.vote ) , g.logo as logo, g.gamename as gamename  FROM game_votes gv, games g WHERE g.gameid = gv.gameid GROUP BY gv.gameid ORDER BY SUM( gv.vote ) DESC LIMIT ".$start.",".$end."";
$all = $DB->fetchAll($sql);

$sql = "SELECT gv.gameid, SUM(gv.vote),g.logo, g.gamename FROM game_votes gv,games g Where g.gameid = gv.gameid AND date > ADDDATE(CURDATE(), -7) GROUP BY gv.gameid ORDER BY SUM(gv.vote) DESC LIMIT ".$start.",".$end."";
$week = $DB->fetchAll($sql);

$sql = "SELECT gv.gameid, SUM(gv.vote),g.logo, g.gamename FROM game_votes gv,games g Where g.gameid = gv.gameid AND date > DATE_SUB(CURDATE(), INTERVAL  1 MONTH) GROUP BY gv.gameid ORDER BY SUM(gv.vote) DESC LIMIT ".$start.",".$end."";
$month = $DB->fetchAll($sql);

for($i = 0; $i<= count($all)-1;$i++)
{
	$final[$i]['gameid'] = $all[$i]->gameid;
	$final[$i]['gamename'] = $all[$i]->gamename;
	$final[$i]['logo'] = $all[$i]->logo;
	$final[$i]['all'] = $i+1;  
}

for($k = 0; $k<= count($final)-1;$k++)
{
	for($j = 0; $j<= count($week)-1;$j++)
	{
		if($week[$j]->gameid == $final[$k]['gameid'])
		{
			$final[$k]['week'] = $j+1;
			break 1;
		}
		else
		{
			$final[$k]['week'] = 0;
		}
	}
	
}

for($k = 0; $k<= count($final)-1;$k++)
{
	for($j = 0; $j<= count($month)-1;$j++)
	{
		if($month[$j]->gameid == $final[$k]['gameid'])
		{
			$final[$k]['month'] = $j+1;
			break 1;
		}
		else
		{
			$final[$k]['month'] = 0;
		}
	}

}
		$this->view->assign('datas',$final);
		
 }
  }
?>