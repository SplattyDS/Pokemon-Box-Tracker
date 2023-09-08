<?php 
require( '../config.php');

$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT users.Id, users.Username, users.Password FROM users WHERE users.Username = :username";

if($stmt = $dbh->prepare($sql))
{
	// Bind variables to the prepared statement as parameters
	$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

	// Set parameters
	$param_username = trim($_POST["username"]);
	if($stmt->execute())
	{
		if($stmt->rowCount() == 1)
		{
			if($row = $stmt->fetch())
			{
				$id = $row["Id"];
				$username = $row["Username"];
				$hashedPassword = $row["Password"];
				$normalList = $row["NormalData"];
				$shinyList = $row["ShinyData"];
				if (password_verify($password, $hashedPassword))
				{
					$_SESSION['Id'] = $id;
					$_SESSION['Username'] = $username;
					$_SESSION['LOGIN_OK'] = true;
					$_SESSION['Normal_List'] = $normalList;
					$_SESSION['Shiny_List'] = $shinyList;
					$_SESSION['PROCESS_CODE'] = 1;
					$_SESSION['PROCESS_TEXT_HEAD'] = 'Logged in';
					$_SESSION['PROCESS_TEXT_BODY'] = 'You have succesfully logged in!';
					
					header('location:../dex.php');
				}
				else
				{
					$_SESSION['Id'] = 0;
					$_SESSION['Username'] = '';
					$_SESSION['LOGIN_OK'] = false;
					$_SESSION['Normal_List'] = "";
					$_SESSION['Shiny_List'] = "";
					$_SESSION['PROCESS_CODE'] = -2;
					$_SESSION['PROCESS_TEXT_HEAD'] = '';
					$_SESSION['PROCESS_TEXT_BODY'] = 'Wrong password!';
					
					header('location:login_form.php');
				}
			}
		}
		else
		{
			$_SESSION['Id'] = 0;
			$_SESSION['Username'] = '';
			$_SESSION['LOGIN_OK'] = false;
			$_SESSION['Normal_List'] = "";
			$_SESSION['Shiny_List'] = "";
			$_SESSION['PROCESS_CODE'] = -1;
			$_SESSION['PROCESS_TEXT_HEAD'] = '';
			$_SESSION['PROCESS_TEXT_BODY'] = 'Unknown username!';
			
			header('location:login_form.php');
		}
	}
}
?>