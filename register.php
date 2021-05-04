<?php
session_start();
/*
 * PURPOSE: Register form. Directs logged in users back to the home page is there is an active user session.
 */
if ( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]  ) {

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
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="css/register.css">

</head>
<body>

	<div class="top-half">
		<?php include 'navbar.php'; ?>

		<div class="sticky-top hidden-spacer"> </div>

		<div class="form-div">
			<div class="container register-container my-2 py-4 mx-auto mr-auto">
				<div class="row justify-content-center">
					<h1 class="description-style col-12 col-sm-12 col-md-12 col-lg-12">Register</h1>

					<div class="container ">

						<form action="register_confirmation.php" method="POST">

							<!-- Email -->
							<label for="email-id" class="col-sm-12 text-white text-center form-label-style">Email: <span class="text-danger">*</span></label>

							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<input type="text" class="form-control" id="email-id" name="email">
                                    <h3 id="email-error" class="invalid-feedback">Email is required.</h3>
								</div>
							</div> <!-- .form-group -->

							<!-- Username -->
							<label for="username-id" class="col-sm-12 text-white text-center form-label-style">Username: <span class="text-danger">*</span></label>
							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<input type="text" class="form-control" id="username-id" name="username">
                                    <h3 id="username-error" class="invalid-feedback">Username is required.</h3>
								</div>
							</div> <!-- .form-group -->

							<!-- password -->
							<label for="password-id" class="col-sm-12 text-white text-center form-label-style">Password: <span class="text-danger">*</span></label>
							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<input type="password" class="form-control" id="password-id" name="password">
                                    <h3 id="password-error" class="invalid-feedback">Password is required.</h3>
								</div>
							</div> <!-- .form-group -->

                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-10 col-lg-8 ">
                                    <span class="text-danger font-italic">* Required</span>
                                </div>
                            </div> <!-- .form-group -->
							
							<div class="row justify-content-center">
								<button type="submit" class="btn btn-outline-light btn-lg">Register</button>
							</div> <!-- .row -->
							
						</form>

						

					</div> <!-- .container -->


				</div>
			</div>
		</div>
	</div>

	
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

            if ( document.querySelector('#email-id').value.trim().length == 0 ) {
                document.querySelector('#email-id').classList.add('is-invalid');
            } else {
                document.querySelector('#email-id').classList.remove('is-invalid');
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