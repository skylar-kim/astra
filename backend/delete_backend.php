<?php
/*
 * PURPOSE: If there is an active user session, then this php file deletes the specified photo
 * from the logged in user's list of favorited pictures/videos. Upon action, a JSON message will
 * return whether it was successful or not. If there is no active user session, this file will redirect
 * the guest to index.php
 * JSON return data:
 * { "message": "failure to find user" }
 * { "message": "failure to delete favorites" }
 * { "message": "delete success" }
 * { "message": "delete failure" }
 */
require "../config/config.php";

// make sure user session is active
if ( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true ) {
	// make DB connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_errno) {
		//echo $mysqli->connect_error;
        $mysqli->close();
		exit();
        header("Location: ../index.php");
	}

	// get the POST data
	$photo_id = $_POST["photo_id"];

	// get the username from the session to get the user id
	$username = $_SESSION["username"];

	// execute SQL SELECT statement to find user_id
	// SELECT user_id FROM users WHERE username = ?;
    // prepare statement
	$sqlSelectUser = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?;");

	// bind parameters
	$sqlSelectUser->bind_param("s", $username);

	// execute
	$sqlSelectUser->execute();

	// if there is an error
	if (!$sqlSelectUser) {
		$jsonMessage = array("message" => "failure to find user");
		echo json_encode($jsonMessage);
		exit();
	}

	// get the result
	$resultUser = $sqlSelectUser->get_result();

	// get the result's row
	$rowUser = $resultUser->fetch_assoc();

	// get the user_id
	$user_id = $rowUser["user_id"];


	// delete the favorite entry from users_has_photos
    // prepare statement
	$sqlDelete = $mysqli->prepare("DELETE FROM users_has_photos WHERE users_user_id = ? AND photos_photo_id = ?;");

	// bind parameters
	$sqlDelete->bind_param("ii", $user_id, $photo_id);

	// execute
	$sqlDelete->execute();

	// if something goes wrong
	if (!$sqlDelete) {
		$jsonMessage = array("message" => "failure to delete favorites");
		echo json_encode($jsonMessage);
		exit();
	}

    // if there was only 1 affected row, return successful JSON message
	if ($sqlDelete->affected_rows == 1) {
		$jsonResponse = array("message" => "delete success");
		echo json_encode($jsonResponse);

	}
	// if there were 0 affected rows, return not successful JSON message
	else if ($sqlDelete->affected_rows == 0) {
		// nothing was deleted?
		$jsonResponse = array("message" => "delete failure");
		echo json_encode($jsonResponse);
	}
	else {
		// uh oh this is bad. it means that there was more than 1 entry was deleted which shouldn't happen
		$jsonResponse = array("message" => "delete failure");
		echo json_encode($jsonResponse);

	}

    // close DB connections
    $sqlSelectUser->close();
	$sqlDelete->close();
    $mysqli->close();
}
else {
	header("Location: ../index.php");
}

 ?>