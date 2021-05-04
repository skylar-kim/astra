<?php 
/*
  * PURPOSE: log users out.
  * If there is a user session active, then destroy the session and set session data to false.
  * If there is no user session active and a guest tries to access this page, direct them back to the home page.
  */
session_start();

if ( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    $_SESSION["logged_in"] = false;
    session_destroy();
}
else {
    header("Location: index.php");
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>ASTRA | Logout</title>

	<meta charset="UTF-8">
	<!-- BOOTSTRAP STYLING -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- FONT -->
	<link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
	<!-- RESPONSIVENESS -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<style type="text/css">
		body {
			color: white;
		}
	</style>
</head>
<body>
	<div class="top-half">
		<?php include 'navbar.php'; ?>

		<div class="sticky-top hidden-spacer"> </div>

		<div class="container">
			<div class="row justify-content-center">
				<h1 class="col-12">Logout</h1>
				<div class="col-12">You are now logged out.</div>
				<div class="col-12 mt-3">You can go to <a href="index.php">home page</a> or <a href="login.php">log in</a> again.</div>
			</div>
		</div>
	</div>

	

	
	<!-- POPPERS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<!-- BOOTSTRAP -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>