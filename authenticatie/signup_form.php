<?php
require( '../config.php' );
$login_form = true;
require( '../includes/layout_header.php' );

// Initialiseer variabelen
$username = $password = $confirm_password = "";

$username_err = $password_err = $confirm_password_err = "";

// Het formulier verwerken als het ingedient werd
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$username = trim($_POST["username"]);
	
	$sql = "SELECT Id FROM users WHERE Username = :Username";
	
	if ($stmt = $dbh->prepare($sql))
	{
		// Verbind username met parameters voor de query
		$stmt->bindParam(":Username", $param_username, PDO::PARAM_STR);
		
		$param_username = trim($_POST["username"]);
		
		// Probeer de query uit te voeren
		if ($stmt->execute())
		{
			if ($stmt->rowCount() == 1)
			{
				$username_err = "This username is already taken.";
			}
			else
			{
				$username = trim($_POST["username"]);
			}
		}
		else
		{
			echo "Er ging iets verkeerd. Probeer het later opnieuw.";
		}

		unset($stmt);
	}
    
    // Password valideren
    if (strlen(trim($_POST["password"])) < 8)
	{
        $password_err = "Your password needs to contain at least 8 characters.";
    }
	else
	{
        $password = trim($_POST["password"]);
    }
    
    // Wachtwoord bevestigen valideren

	$confirm_password = trim($_POST["confirm_password"]);
	if (empty($password_err) && ($password != $confirm_password))
	{
		$confirm_password_err = "Passwords don't match.";
	}
    
    // Controleer op fouten voor je de klant in de database steekt
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err))
	{
        $sql = "INSERT INTO users VALUES (NULL, :username, :password, NULL, NULL)";
         
        if($stmt = $dbh->prepare($sql))
		{
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Probeer de klant in de database toe te voegen
            if($stmt->execute())
			{
				header("location: login_form.php");
            }
			else
			{
                echo "Er ging iets verkeerd. Probeer het later opnieuw.";
            }

            unset($stmt);
        }
    }
    
    unset($dbh);
}
?>

<div class="wrapper">
	<h2>Register</h2>
	<p>Enter a username and password to make an account.</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
		
		<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
			<label>Username</label>
			<input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
			<span class="help-block"><?php echo $username_err; ?></span>
		</div>
		
		
		<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
			<label>Password</label>
			<input type="password" name="password" class="form-control" value="<?php echo $password; ?>" required>
			<span class="help-block"><?php echo $password_err; ?></span>
		</div>
		
		
		<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
			<label>Confirm Password</label>
			<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" required>
			<span class="help-block"><?php echo $confirm_password_err; ?></span>
		</div>
		
		
		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Create account">
			<input type="reset" class="btn btn-default" value="Clear all">
		</div>
		
		<p>Already have an account? <a href="login_form.php">Log in here</a>!</p>
	</form>
</div>

<?php require( '../includes/layout_footer.php' ); ?>