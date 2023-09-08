<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!-- FontAwesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
//  Session starten en initialiseren

session_start();

if(!isset($_SESSION['LOGIN_OK']))
{
	$_SESSION['LOGIN_OK'] = false;
}

	
//  Connectie met database initialiseren

define('DB_CONNECTION', 'mysql:host=localhost;port=3306;dbname=pokelist');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

try
{
	$dbh = new PDO( DB_CONNECTION, DB_USERNAME, DB_PASSWORD );
}
catch (PDOException $e)
{
	echo 'Error!<br>'.$e->getMessage().'<br>';
	die();
}

define('NUM_NORMAL_POKEMON', 1369);
define('NUM_SHINY_POKEMON', 1299);
define('NUM_GMAX_POKEMON', 33);
define('NUM_SHINY_GMAX_POKEMON', 33);

define('TYPE_NORMAL', 0);
define('TYPE_SHINY', 1);
define('TYPE_GMAX', 2);
define('TYPE_SHINY_GMAX', 3);
define('NUM_TYPES', 4);

$lockList = array
(
	array(1240),
	array(201,203,205,675,851,852,853,889,890,977,978,979,1053,1054,1065,1066,1067,1163,1164,1165,1166,1167,1168,1169,1170,1173,1174,1175),
	array(),
	array(14),
);

$otLockList = array
(
	array(/*33,34,35,36,37,38,39,40,516,842,843,878,879,953,954,955,956,1049,1054,1207*/),
	array(201,203,205,675,851,852,853,889,890,977,978,979,1053,1054,1065,1066,1067,1163,1164,1165,1166,1167,1168,1169,1170,1173,1174,1175),
	array(/*508,661,835,945,1046*/),
	array(),
);

$folders = array('normal','shiny','normal_gmax','shiny_gmax');
?>