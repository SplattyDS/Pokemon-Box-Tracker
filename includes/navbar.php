<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo TITLE; ?></title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="dex.php">Dex</a>
    
	<?php
	if (!isset($login_form))
	{
		print('<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item"><a class="nav-link" href="dex.php">Main</a></li>
				<li class="nav-item"><a class="nav-link" href="gmax.php">GMAX</a></li>
				<li class="nav-item"><a class="nav-link" href="unbox.php">Unboxable</a></li>
				<li class="nav-item"><a class="nav-link" href="lock.php">Locked</a></li>
				<li class="nav-item"><a class="nav-link" href="rare.php">Rare</a></li>
				<li class="nav-item"><a class="nav-link" href="updater.php">Updater</a></li>');
		
		if ($_SESSION['LOGIN_OK'])
		{
			print('
			<li class="nav-item"><a class="nav-link" href="#">'.$_SESSION['Username'].'</a></li>
			<li class="nav-item"><a class="nav-link" href="authenticatie/logout.php">Log out</a></li>');
		}
		else
		{
			print('
			<li class="nav-item"><a class="nav-link" href="authenticatie/login_form.php">Log in</a></li>
			<li class="nav-item"><a class="nav-link" href="authenticatie/signup_form.php">Register</a></li>');
		}
	}
	?>
</nav>