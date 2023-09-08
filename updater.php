<?php
define('TITLE', 'PokeBox Updater');

define('TYPE_NORMAL', 0);
define('TYPE_SHINY', 1);
define('TYPE_GMAX', 2);
define('TYPE_SHINY_GMAX', 3);
define('NUM_TYPES', 4);

require('config.php');
require('includes/navbar.php');

if (!$_SESSION['LOGIN_OK'])
{
	header('authenticatie/login_form.php');
}

function Backup()
{
	global $dbh;
	
	if ($stmt3 = $dbh->prepare('CREATE TABLE backup AS SELECT * FROM users;'))
	{
		$stmt3->execute();
		print('<p>Backup made.</p>');
	}
	else
	{
		print('<p>Backup failed.</p>');
		return false;
	}
	
	return true;
}

function GetDatas()
{
	global $dbh;
	
	global $list;
	global $slist;
	
	if ($_SESSION['LOGIN_OK'])
	{
		$sql1 = 'SELECT Username, NormalData, ShinyData FROM users WHERE Id = '.$_SESSION['Id'];
		$sql2 = 'UPDATE users SET NormalData = :normal, ShinyData = :shiny WHERE Id = '.$_SESSION['Id'];
		
		$results1 = $dbh->query($sql1);
		
		foreach ($results1 as $resultaat)
		{
			$enlist = $resultaat[1];
			$enslist = $resultaat[2];
			
			$list = JSON_decode('['.$enlist.']');
			$slist = JSON_decode('['.$enslist.']');
			
			return array($list, $slist, array(), array());
		}
	}
}

function StoreDatas($datas)
{
	global $dbh;
	
	$sql1 = 'SELECT Username, NormalData, ShinyData FROM users WHERE Id = '.$_SESSION['Id'];
	$sql3 = 'UPDATE users SET NormalData = :normal, ShinyData = :shiny WHERE Id = '.$_SESSION['Id'];
	
	$results1 = $dbh->query($sql1);
	
	foreach ($results1 as $resultaat)
	{
		if ($stmt3 = $dbh->prepare($sql3))
		{
			$JS3_1 = JSON_encode($datas[0]);
			$JS3_2 = JSON_encode($datas[1]);
			
			$ARR3_1 = substr($JS3_1, 1, strlen($JS3_1) - 2);
			$ARR3_2 = substr($JS3_2, 1, strlen($JS3_2) - 2);
			
			$stmt3->bindParam(":normal", $ARR3_1, PDO::PARAM_STR);
			$stmt3->bindParam(":shiny", $ARR3_2, PDO::PARAM_STR);
			
			$stmt3->execute();
		}
	}
}

function CheckLength($datas, $length, $type)
{
	if (count($datas[$type]) == $length)
		return true;
	
	print('<p>Incorrect entries for user ('.count($datas[$type]).'), expected '.$length.' (type: '.$type.')</p>');
	
	return false;
}

if (Backup())
{
	$list = array();
	$slist = array();
	
	for ($i = 0; $i < NUM_NORMAL_POKEMON; $i++)
		array_push($list, false);
	
	for ($i = 0; $i < NUM_SHINY_POKEMON; $i++)
		array_push($slist, false);
	
	// structure: at num type (inserts num amount of new ids between at and (at + 1)
	// type: 0: normal, 1: shiny, 2: gmax, 3: shiny gmax
	$changeInfos = array
	(
		// array(1200, 3, TYPE_NORMAL),
		// array(0, 1, TYPE_NORMAL),
		// array(1100, 3, TYPE_SHINY),
		// array(1200, 3, TYPE_GMAX),
		// array(1200, 3, TYPE_SHINY_GMAX),
	);
	
	$datas = GetDatas();
	
	// these are the current lenghts
	if (!CheckLength($datas, NUM_NORMAL_POKEMON, TYPE_NORMAL)) die();
	if (!CheckLength($datas, NUM_SHINY_POKEMON, TYPE_SHINY)) die();
	if (!CheckLength($datas, NUM_GMAX_POKEMON, TYPE_GMAX)) die();
	if (!CheckLength($datas, NUM_SHINY_GMAX_POKEMON, TYPE_SHINY_GMAX)) die();
	
	// do changes here
	for ($i = 0; $i < count($changeInfos); $i++)
	{
		$info = $changeInfos[$i];
		$arr = array();
		
		for ($j = 0; $j < $info[1]; $j++)
			array_push($arr, false);
		
		array_splice($datas[$info[2]], $info[0], 0, $arr);
	}
	
	// these are the new lenghts
	if (!CheckLength($datas, NUM_NORMAL_POKEMON /*+ 4*/, TYPE_NORMAL)) die();
	if (!CheckLength($datas, NUM_SHINY_POKEMON /*+ 3*/, TYPE_SHINY)) die();
	if (!CheckLength($datas, NUM_GMAX_POKEMON, TYPE_GMAX)) die();
	if (!CheckLength($datas, NUM_SHINY_GMAX_POKEMON, TYPE_SHINY_GMAX)) die();
	
	StoreDatas($datas);
}

?>

</body>