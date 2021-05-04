<?php 
session_start();

// this page is an admin-only accessible page
if ( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true 
	&& isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
	
}
else {

	// user session not active: direct to index page
	// or user session active but not admin user, direct to index page
	header("Location: index.php");
}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>ASTRA | Create Form</title>

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
					<h1 class="description-style col-12 col-sm-12 col-md-12 col-lg-12">Create Today's APOD Entry</h1>

					<div class="container ">

						<form action="create_confirmation.php" method="POST">

							<!-- URL -->
							<label for="url-id" class="col-sm-12 text-white text-center form-label-style">URL: <span class="text-danger">*</span></label>
							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<input type="text" class="form-control" id="url-id" name="url">
                                    <h3 id="url-error" class="invalid-feedback">URL is required.</h3>
								</div>
							</div> <!-- .form-group -->

							<!-- Title -->
							<label for="title-id" class="col-sm-12 text-white text-center form-label-style">Title: <span class="text-danger">*</span></label>
							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<input type="text" class="form-control" id="title-id" name="title">
                                    <h3 id="title-error" class="invalid-feedback">Title is required.</h3>
								</div>
							</div> <!-- .form-group -->

							<!-- Media Type -->
							<label for="media-type-id" class="col-sm-12 text-white text-center form-label-style">Media Type: <span class="text-danger">*</span></label>
							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<select class="custom-select" id="media-type-id" name="media">
									    <option value="" selected>Choose...</option>
									    <option value="1">image</option>
									    <option value="2">video</option>
									</select>
								</div>
                                <h3 id="media-error" class="invalid-feedback">Media Type is required.</h3>
							</div> <!-- .form-group -->
							  
							  
							<!-- Copyright -->
							<label for="copyright-id" class="col-sm-12 text-white text-center form-label-style">Copyright:</label>
							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<input type="text" class="form-control" id="copyright-id" name="copyright">
								</div>
							</div> <!-- .form-group -->

							<!-- Explanation -->
							<label for="explanation-id" class="col-sm-12 text-white text-center form-label-style">Explanation: <span class="text-danger">*</span></label>
							<div class="form-group row justify-content-center">
								<div class="col-sm-12 col-md-10 col-lg-8">
									<input type="textarea" class="form-control" id="explanation-id" name="explanation">
                                    <h3 id="explanation-error" class="invalid-feedback">Explanation is required.</h3>
								</div>
							</div> <!-- .form-group -->

                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-10 col-lg-8 ">
                                    <span class="text-danger font-italic">* Required</span>
                                </div>
                            </div> <!-- .form-group -->

							<div class="row justify-content-center">
								<button type="submit" class="btn btn-outline-light btn-lg">Create</button>
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
            if ( document.querySelector('#url-id').value.trim().length == 0 ) {
                document.querySelector('#url-id').classList.add('is-invalid');
            } else {
                document.querySelector('#url-id').classList.remove('is-invalid');
            }

            if ( document.querySelector('#title-id').value.trim().length == 0 ) {
                document.querySelector('#title-id').classList.add('is-invalid');
            } else {
                document.querySelector('#title-id').classList.remove('is-invalid');
            }

            if ( document.querySelector('#media-type-id').value == "" ) {
                document.querySelector('#media-type-id').classList.add('is-invalid');
            } else {
                document.querySelector('#media-type-id').classList.remove('is-invalid');
            }

            if ( document.querySelector('#explanation-id').value == "" ) {
                document.querySelector('#explanation-id').classList.add('is-invalid');
            } else {
                document.querySelector('#explanation-id').classList.remove('is-invalid');
            }

            return ( !document.querySelectorAll('.is-invalid').length > 0 );

        }
    </script>

</body>


</html>