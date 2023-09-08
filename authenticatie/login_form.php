<?php
	require( '../config.php' );
	$login_form = true;
	require( '../includes/layout_header.php' );
?>

<main class="container">
   <div class="col-8">
		<div class="card">
			<div class="card-header">
				Log in
			</div>
			<div class="card-body">
				<form action="login.php" method="post">
					<div class="form-group">
						<label for="inputPassword">Username</label>
						<input type="text" class="form-control" id="inputUsername" name="username">
					</div>
					<div class="form-group">
						<label for="inputPassword">Password</label>
						<input type="password" class="form-control" id="inputPassword" name="password">
					</div>

					<?php
					if(isset($_SESSION['PROCESS_CODE']) and $_SESSION['PROCESS_CODE'] < 0)
					{
						print('<div class="alert alert-danger col-8" role="alert">'.PHP_EOL);
						print($_SESSION['PROCESS_TEXT_HEAD'].PHP_EOL);
						print($_SESSION['PROCESS_TEXT_BODY'].PHP_EOL);
						print('</div>'.PHP_EOL);
						
						$_SESSION['PROCESS_CODE'] = 0;
						$_SESSION['PROCESS_TEXT_HEAD'] = '';
						$_SESSION['PROCESS_TEXT_BODY'] = '';
					}
					?>
					
					<button type="submit" class="btn btn-primary">Log in</button>
				</form>
			</div>
		</div>
	</div>
</main>

<?php require( '../includes/layout_footer.php' ); ?>