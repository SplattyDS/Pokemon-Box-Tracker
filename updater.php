<?php
define('TITLE', 'PokeBox Updater');

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
	
	if ($_SESSION['LOGIN_OK'])
	{
		$sql1 = 'SELECT Username, NormalData, ShinyData, NormalGmaxData, ShinyGmaxData FROM users WHERE Id = '.$_SESSION['Id'];
		
		$results1 = $dbh->query($sql1);
		
		foreach ($results1 as $resultaat)
		{
			return array
			(
				JSON_decode('['.$resultaat[1].']'),
				JSON_decode('['.$resultaat[2].']'),
				JSON_decode('['.$resultaat[3].']'),
				JSON_decode('['.$resultaat[4].']'),
			);
		}
	}
}

function StoreDatas($datas)
{
	global $dbh;
	
	$sql1 = 'SELECT Username, NormalData, ShinyData, NormalGmaxData, ShinyGmaxData FROM users WHERE Id = '.$_SESSION['Id'];
	$sql3 = 'UPDATE users SET NormalData = :normal, ShinyData = :shiny, NormalGmaxData = :normalG, ShinyGmaxData = :shinyG WHERE Id = '.$_SESSION['Id'];
	
	$results1 = $dbh->query($sql1);
	
	foreach ($results1 as $resultaat)
	{
		if ($stmt3 = $dbh->prepare($sql3))
		{
			$JS3_0 = JSON_encode($datas[0]);
			$JS3_1 = JSON_encode($datas[1]);
			$JS3_2 = JSON_encode($datas[2]);
			$JS3_3 = JSON_encode($datas[3]);
			
			$ARR3_0 = substr($JS3_0, 1, strlen($JS3_0) - 2);
			$ARR3_1 = substr($JS3_1, 1, strlen($JS3_1) - 2);
			$ARR3_2 = substr($JS3_2, 1, strlen($JS3_2) - 2);
			$ARR3_3 = substr($JS3_3, 1, strlen($JS3_3) - 2);
			
			$stmt3->bindParam(":normal", $ARR3_0, PDO::PARAM_STR);
			$stmt3->bindParam(":shiny", $ARR3_1, PDO::PARAM_STR);
			$stmt3->bindParam(":normalG", $ARR3_2, PDO::PARAM_STR);
			$stmt3->bindParam(":shinyG", $ARR3_3, PDO::PARAM_STR);
			
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
	// structure: at num type (inserts 'num' amount of new ids at 'at')
	// type: 0: normal, 1: shiny, 2: gmax, 3: shiny gmax
	$changeInfos = array
	(
		// array(669, 1, TYPE_NORMAL),
		// array(904, 9, TYPE_NORMAL),
		// array(661, 1, TYPE_SHINY),
		// array(896, 9, TYPE_SHINY),
		// array(89, 1, TYPE_NORMAL),
		// array(91, 1, TYPE_NORMAL),
		// array(148, 1, TYPE_NORMAL),
		// array(150, 1, TYPE_NORMAL),
		// array(223, 1, TYPE_NORMAL),
		// array(319, 1, TYPE_NORMAL),
		// array(689, 1, TYPE_NORMAL),
		// array(737, 1, TYPE_NORMAL),
		// array(740, 1, TYPE_NORMAL),
		// array(764, 1, TYPE_NORMAL),
		// array(766, 1, TYPE_NORMAL),
		// array(833, 1, TYPE_NORMAL),
		// array(957, 1, TYPE_NORMAL),
		// array(959, 1, TYPE_NORMAL),
		// array(973, 1, TYPE_NORMAL),
		// array(987, 1, TYPE_NORMAL),
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
	// if (!CheckLength($datas, NUM_NORMAL_POKEMON, TYPE_NORMAL)) die();
	// if (!CheckLength($datas, NUM_SHINY_POKEMON, TYPE_SHINY)) die();
	// if (!CheckLength($datas, NUM_GMAX_POKEMON, TYPE_GMAX)) die();
	// if (!CheckLength($datas, NUM_SHINY_GMAX_POKEMON, TYPE_SHINY_GMAX)) die();
	
	StoreDatas($datas);
	
	print('<p>Done.</p>');
}

?>

</body>