<?php 
require( '../config.php' );

$_SESSION['Id'] = 0;
$_SESSION['Username'] = "";
$_SESSION['LOGIN_OK'] = false;
$_SESSION['Normal_List'] = "";
$_SESSION['Shiny_List'] = "";
$_SESSION['PROCESS_CODE'] = 2;
$_SESSION['PROCESS_TEXT_HEAD'] = 'Logged out';
$_SESSION['PROCESS_TEXT_BODY'] = 'You are no longer logged in!';

header('location:../dex.php');
?>