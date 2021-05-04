<?php 

require 'config/config.php';
/*
 * PURPOSE: This PHP file logs in the user. If there is a successful login, the SESSION data is set to the
 * logged in user and the user is redirected to the home page. If there is not a successful login, then an error
 * message is displayed. If a logged in user tries to access this page manually and they are already logged in,
 * the user is automatically redirected to the home page.
 */
// If user is logged in, don't show them this page. Redirect them somewhere else.
// if not logged in, do the usual thing
if ( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]  ) {


	// Check if a username and password has been submitted via POST method.
	// will not go into if statement if user simply got to the login page.
	// only if username and password was actually submitted
	if ( isset($_POST['username']) && isset($_POST['password']) ) {

		// check if username and password has been filled out or not
		if ( empty($_POST['username']) || empty($_POST['password']) ) {

			$error = "Please enter username and password.";

		}
		else {
			// This means user has filled out something for username and password.
			// So let's check if this username/password combo exists in the DB and that it is correct!
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				exit();
			}

			// hash whatever user typed in for the password field and then compare that with the hashed pw in the db
			$passwordInput = hash("sha256", $_POST["password"]);

			// make prepared statement
			$sqlLogin = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = ?;");

			// bind parameters
			$sqlLogin->bind_param("ss", $_POST["username"], $passwordInput);

			// execute query
			$sqlLogin->execute();

			// store result from query
			$sqlLogin->store_result();


			if(!$sqlLogin) {
				echo $mysqli->error;
				exit();
			}

			// if we get one match, that means this username/pw combo exists!
			// num_rows tells us how many results we obtained from the above sql query
			if($sqlLogin->num_rows > 0) {
				// log in success
				// set session variables to remember the username
				$_SESSION["username"] = $_POST["username"];
				$_SESSION["logged_in"] = true;

				// redirect logged in user to the home page
				header("Location: index.php");
			
			}
			else {
				$error = "Invalid username or password.";
			}

			// close statement
            $sqlLogin->close();

			// close connection
            $mysqli->close();
		} 
	}
}
else {
	// user is already logged in, so redirect them to another page
	header("Location:  index.php");
}


 ?>


<!DOCTYPE html>
<html>
<head>
	<title>ASTRA | Register</title>

	<meta charset="UTF-8">
	<!-- BOOTSTRAP STYLING -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- FONT -->
	<link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
	<!-- RESPONSIVENESS -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

	<div class="top-half">
		<?php include 'navbar.php'; ?>

		<div class="sticky-top hidden-spacer"> </div>

		<div class="form-div">
			<div class="container register-container my-2 py-4 mr-auto">
				<div class="row justify-content-center">
					<h1 class="description-style col-12 col-sm-12 col-md-12 col-lg-12">Login</h1>

					<div class="container">

						<form action="login.php" method="POST">

							<div class="form-group row justify-content-center">
								<div class="font-italic col-sm-12 col-md-10 col-lg-8 text-white text-center">
									<?php if (  isset($error) && !empty($error) ) {
										echo $error;
									}
									?>
								</div>
							</div>

							<!-- Username -->
							
							<div class="form-group row justify-content-center">
								<label for="username-id" class="col-sm-12 text-white text-center form-label-style">Username: <span class="text-danger">*</span></label>
								<div class="col-sm-12 col-md-8 col-lg-6">
									<input type="text" class="form-control" id="username-id" name="username">
                                    <h3 id="username-error" class="invalid-feedback">Username is required.</h3>
								</div>
							</div> <!-- .form-group -->

							<!-- password -->
							
							<div class="form-group row justify-content-center">
								<label for="password-id" class="col-sm-12 text-white text-center form-label-style">Password: <span class="text-danger">*</span></label>
								<div class="col-sm-12 col-md-8 col-lg-6">
									<input type="password" class="form-control" id="password-id" name="password">
                                    <h3 id="password-error" class="invalid-feedback">Password is required.</h3>
								</div>
							</div> <!-- .form-group -->

                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-8 col-lg-6">
                                    <span class="text-danger font-italic">* Required</span>
                                </div>
                            </div> <!-- .form-group -->
							
							<div class="row justify-content-center">
								<button type="submit" class="btn btn-outline-light btn-lg">Login</button>
							</div> <!-- .row -->
						</form>

						

					</div> <!-- .container -->


				</div>
			</div>
		</div>
	</div>

	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<!-- POPPERS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<!-- BOOTSTRAP -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        document.querySelector('form').onsubmit = function(){
            if ( document.querySelector('#username-id').value.trim().length == 0 ) {
                document.querySelector('#username-id').classList.add('is-invalid');
            } else {
                document.querySelector('#username-id').classList.remove('is-invalid');
            }

            if ( document.querySelector('#password-id').value.trim().length == 0 ) {
                document.querySelector('#password-id').classList.add('is-invalid');
            } else {
                document.querySelector('#password-id').classList.remove('is-invalid');
            }

            return ( !document.querySelectorAll('.is-invalid').length > 0 );


        }
    </script>
</body>
</html>