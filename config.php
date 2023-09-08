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
define( 'DB_PASSWORD', '' );

try
{
	$dbh = new PDO( DB_CONNECTION, DB_USERNAME, DB_PASSWORD );
}
catch (PDOException $e)
{
	echo 'Error!<br>'.$e->getMessage().'<br>';
	die();
}

define('NUM_NORMAL_POKEMON', 1211);
define('NUM_SHINY_POKEMON', 1147);

define('NUM_GMAX_POKEMON', 0);
define('NUM_SHINY_GMAX_POKEMON', 0);
?>