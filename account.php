<?php 
session_start();
/*
 * PURPOSE: If there is an active user session, the user's list of favorite APOD pictures and videos
 * are displayed here. If there is no active user session, the viewer will be redirected to the home page.
 */
if ( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true ) {
}
else {
	// user session not active: direct to index page
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>ASTRA | Account</title>

	<meta charset="UTF-8">
	<!-- BOOTSTRAP STYLING -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- FONT -->
	<link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
	<!-- RESPONSIVENESS -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<!-- SCROLL REVEAL -->
	<script src="https://unpkg.com/scrollreveal"></script>
	<!-- CUSTOM SCRIPT -->
	<script type="text/javascript" src="js/account.js"></script>
	<!-- CUSTOM STYLE SHEET -->
	<link rel="stylesheet" type="text/css" href="css/account.css">
	
</head>
<body>

	<?php include 'navbar.php'; ?>

	<div class="container">
		<div class="row justify-content-center py-5">
			<h1 class="col-12 text-center header-animation"><em>Ad Astra</em>. . ."to the stars"</h1>
			<h2 class="col-12 text-center header-animation"><?php echo $_SESSION["username"]; ?>'s gallery</h2>
		</div>

		<div class="row justify-content-center card-row d-none">

			<div class="col-12 col-sm-12 col-md-6 col-lg-4 my-4 card-div" >
				<div class="card">
					<a href=""><img src="" class="img-fluid" alt=""></a>
					<span class="photo-id d-none"></span>
				</div>
			</div>

			<div class="col-12 col-sm-12 col-md-6 col-lg-4 my-4 card-div" >
				<div class="card">
					<a href="">
						<img src="" class="img-fluid" alt="a">
					</a>
					<span class="photo-id d-none"></span>
				</div>
			</div>
		
		</div>
		
	</div>

	<!-- POPPERS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<!-- BOOTSTRAP -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>