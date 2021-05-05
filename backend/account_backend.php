<?php
/* PURPOSE: if there is an active user session, this php file will return a
 * JSON array of JSON objects that contain information about each APOD photo or video
 * that the user favorited. The JSON array will be formatted in the following manner:
 * return JSON array format:
 * [
 *  {
 *      "media_type": "image",
 *      "photo_id": 29,
 *      "title": "The Pelican Nebula in Red and Blue",
 *      "url": "https://apod.nasa.gov/apod/image/2102/Pelican_PetraskoEtAl_960.jpg"
 *  },
 *  {
 *      "media_type": "video",
 *      "photo_id": 43,
 *      "title": "Flying Over the Earth at Night II",
 *      "url": "https://www.youtube.com/embed/zIqG42AD4Gw?rel=0"
 *  }
 * ]
 */

require("../config/config.php");

// check if user session is active
if ( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true ) {

	// make DB connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_errno) {
		//echo $mysqli->connect_error;
        $mysqli->close();
		exit();
		// there's an error in the connection just redirect to home page
        header("Location: index.php");
	}

	
	// get the username from the session 
	$username = $_SESSION["username"];

	// execute SQL SELECT statement to find user_id
	// SELECT user_id FROM users WHERE username = ?;
    // prepare statement
	$sqlSelectUser = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?;");

	// bind parameters
	$sqlSelectUser->bind_param("s", $username);

	// execute statement
	$sqlSelectUser->execute();

	// get result
	$resultUser = $sqlSelectUser->get_result();

	// get row
	$rowUser = $resultUser->fetch_assoc();

	// get user_id data
	$userId = $rowUser["user_id"];

	// close connection when finished
    // see at the end

    // end SQL SELECT statement to find user_id

    // execute SQL SELECT statement to query DB for user's
	// list of photos associated to their user id
    // prepare statement
	$sqlFav = $mysqli->prepare("SELECT * FROM users_has_photos WHERE users_user_id = ?;");

	// bind parameters
	$sqlFav->bind_param("i", $userId);

	// execute statement
	$sqlFav->execute();

	// get result
	$resultFav = $sqlFav->get_result();

	// for each row in resultset, add photos_photo_id to an array
	$photoIdArray = array();
	while ($row = $resultFav->fetch_assoc()) {
		//echo "<hr>" . $row["photos_photo_id"];
		$photoIdArray[] = $row["photos_photo_id"];
	}

	// loop through the photos_photo_id array 
	// for each photos_photo_id, call DB to get the photo associated with that photos_photo_id
	// and build an array of json objects to send to frontend
	$jsonArray = array();
	foreach($photoIdArray as $key => $photo_id) {
	    // prepare statement
		$sqlSelectPhoto = $mysqli->prepare("SELECT * FROM photos WHERE photo_id = ?;");

		// bind parameters
		$sqlSelectPhoto->bind_param("i", $photo_id);

		// execute statement
		$sqlSelectPhoto->execute();

		// get result
		$photoResult = $sqlSelectPhoto->get_result();

		// get row of result
		$photoRow = $photoResult->fetch_assoc();

		// echo "<hr>" . $photoRow["photo_id"];
		// echo "<hr>" . $photoRow["url"];

        // build JSON object with the data
        // JSON object format:
        /*
         * {
         *  "media_type": "image",
         *  "photo_id": 29,
         *  "title": "The Pelican Nebula in Red and Blue",
         *  "url": "https://apod.nasa.gov/apod/image/2102/Pelican_PetraskoEtAl_960.jpg"
         *  "photo_date": "2020-01-01"
         * }
         */
		$jsonObject = array(
			"photo_id" => $photoRow["photo_id"],
			"url" => $photoRow["url"],
			"media_type" => $photoRow["media_type"],
			"title" => $photoRow["title"],
            "photo_date" => $photoRow["photo_date"]
		);

		// add JSON object to JSON array
		$jsonArray[] = $jsonObject;

	}
	/*
	 * return JSON array format:
	 * [
	 *  {
            "media_type": "image",
            "photo_id": 29,
            "title": "The Pelican Nebula in Red and Blue",
            "url": "https://apod.nasa.gov/apod/image/2102/Pelican_PetraskoEtAl_960.jpg"
        },
	    {
            "media_type": "video",
            "photo_id": 43,
            "title": "Flying Over the Earth at Night II",
            "url": "https://www.youtube.com/embed/zIqG42AD4Gw?rel=0"
        }
	 * ]
	 */

	// returning JSON data
	header('Content-Type: application/json');
    echo json_encode($jsonArray);

    // closing DB connections
    $sqlSelectUser->close();
    $sqlFav->close();
    $sqlSelectPhoto->close();
	$mysqli->close();
}
else {

	// user session not active: direct to index page
	header("Location: index.php");

	// $response = array("message" => "user session not active");

	// echo json_encode($response);
}



?>