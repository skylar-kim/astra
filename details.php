<?php 
require("config/config.php");
/*
 * PURPOSE: This PHP file displays the details of the APOD entry when clicked from account.php.
 * This file checks if there is a user session active. If there is an active user session, this program
 * will fetch the APOD details from the DB and display it.
 * If there is no active user session, this program will redirect the viewer to the home page.
 */
// check if user session is active
if ( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true 
	&& isset($_GET["photo_id"]) && !empty($_GET["photo_id"])) 
{

	// get the photo id from url
	$photo_id = $_GET["photo_id"];
	// echo $photo_id;

	// make DB connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_errno) {
		exit();
	}

	// get photo information from database
    // prepare statement
	$sqlSelect = $mysqli->prepare("SELECT * FROM photos WHERE photo_id = ?;");

	// bind parameters
	$sqlSelect->bind_param("i", $photo_id);

	// execute statement
	$sqlSelect->execute();

	if (!$sqlSelect) {
		exit();
	}

	// get result
	$result = $sqlSelect->get_result();

	// get row from result
	$row = $result->fetch_assoc();

	// close statements and connections
	$sqlSelect->close();
	$mysqli->close();


}
else {
	header("Location: index.php");
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>ASTRA | Details</title>

	<meta charset="UTF-8">
	<!-- BOOTSTRAP STYLING -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- FONT -->
	<link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
	<!-- RESPONSIVENESS -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<!-- LIGHTBOX -->
	<link href="lightbox2-dev/src/css/lightbox.css" rel="stylesheet" />
	<!-- Custom Scripts -->
	<script type="text/javascript" src="js/details.js"></script>
	<link rel="stylesheet" type="text/css" href="css/details.css">

</head>
<body>
	<?php include 'navbar.php'; ?>
	<div class="container">
		<div class="row justify-content-center">

			<?php if ( $row["media_type"] == "video") : ?>

				<div class="col-12 col-sm-12 col-md-12 col-lg-7">
					<div class="embed-responsive embed-responsive-16by9">
				   		<iframe class="embed-responsive-item" src="<?php echo $row["url"]; ?>" allowfullscreen></iframe>
					</div>
				</div>

			<?php else: ?>

				<div class="col-12 col-sm-12 col-md-12 col-lg-7">
					<a href="<?php echo $row["url"]; ?>" data-lightbox="<?php echo $row["title"]; ?>" data-title="<?php echo $row["title"]; ?>" >
						<img src="<?php echo $row["url"]; ?>" class="img-fluid" alt="<?php echo $row["title"]; ?>">
					</a>
				</div>

			<?php endif; ?>

			<div class="col-12 col-sm-12 col-md-12 col-lg-5">
				
				<h2 class="picture-title"><?php echo $row["title"]; ?></h2>

				<button type="button" class="btn btn-outline-light delete-button" value="<?php echo $_GET["photo_id"];?>">Delete From Favorites</button>
				
				<h5 id="photo-date" class="picture-title py-2"><?php echo $row["photo_date"]; ?></h5>
				<h5 class="picture-title">Copyright: <?php echo $row["copyright"]; ?></h5>
				<p class="picture-title"><?php echo $row["explanation"]; ?></p>
			</div>
		</div>
		
	</div>

	<!-- POPPERS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<!-- BOOTSTRAP -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- LIGHTBOX -->
	<script src="lightbox2-dev/src/js/lightbox.js"></script>

</body>
</html>