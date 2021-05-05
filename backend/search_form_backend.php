<?php
require("../config/nasa-creds.php");
require("../config/db_config.php");
/*
 * PURPOSE: This PHP file handles the search functionality. The search functionality works in 2 steps.
 * First, this file will check if a photo exists in the DB with the same photo date as $_GET["searchDate"].
 * If a photo exists, then the PHP file sends back a JSON formatted response with the photo data cached from the DB.
 *
 * Second, if a photo does not exist in the DB with the same photo date as $_GET["searchDate"],
 * then this PHP file will call the NASA APOD API for the photo data.
 * Then, this PHP will will "cache" the NASA APOD JSON into our DB so that the next time a user searches for the
 * same photo date, we can just pull from the DB and not have to call the API.
 * After caching the NASA APOD API data into our DB, this PHP file will send the JSON response from the API
 * as JSON formatted data to the frontend.
 *
 * return JSON format (when 1st time calling the date):
 * [
 *  {
 *      "date: "2005-01-01",
 *      "explanation": "Explanation here",
 *      "hdurl": "https://apod.nasa.gov/apod/image/2105/EarthMoonSpaceship_Apollo11Ord_960.jpg",
 *      "media_type": "image",
 *      "service_version": "v1",
 *      "title": "Title",
 *      "url": "https://apod.nasa.gov/apod/image/2105/EarthMoonSpaceship_Apollo11Ord_960.jpg"
 *  }
 * ]
 *
 * return JSON format (not 1st time calling the date):
 * [
 * {
 *      "url": "https://apod.nasa.gov/apod/image/2105/EarthMoonSpaceship_Apollo11Ord_960.jpg",
 *      "title": "Title",
 *      "date": "2005-01-01",
 *      "media_type": "image",
 *      "copyright": "",
 *      "explanation": "explanation"
 * }
 * ]
 *
 * return JSON format for messages
 * {"message": "Date is required."}
 * {"message": "You are only allowed to input dates up to and including today."}
 */

// server side validation
if (!isset($_GET["searchDate"]) || empty($_GET["searchDate"])) {
    $response = array("message" => "Date is required.");
    header('Content-Type: application/json');
    echo json_encode($response);
}
else {
    // check if the date is before or on today
    // Check if an APOD entry for today's date already exists
    date_default_timezone_set('America/Los_Angeles');

    // get today's date
    $date = date('Y-m-d', time());

    // grab the GET searchDate and format to proper format
    $mysqldate = date('Y-m-d', strtotime($_GET["searchDate"]));

    if ($mysqldate <= $date) {
        // Establish DB Connection
        $mysqli = new mysqli(DB_HOST2, DB_USER2, DB_PASS2, DB_NAME2);

        if ($mysqli->connect_errno) {
            exit();
        }

        // Dummy Data
        // $_GET["searchDate"] = "2020-01-01";


        // echo $mysqldate;

        // Check database to see if the search result is already in the DB
        // prepare statement
        $sqlSelect = $mysqli->prepare("SELECT * FROM photos WHERE photo_date = ?;");

        // prepare statements
        $sqlSelect->bind_param("s", $mysqldate);

        // execute statement
        $sqlSelect->execute();

        if (!$sqlSelect) {
            echo $mysqli->error();
            exit();
        }

        $result = $sqlSelect->get_result();


        if ($result->num_rows == 1) {
            // photo data is already cached in DB
            $sqlSelect->execute();

            // get the result
            $result = $sqlSelect->get_result();

            // grab the photo row
            $row = $result->fetch_assoc();

            // grab the relevant data to send back formatted as JSON response
            $url = $row["url"];
            $title = $row["title"];
            $photoDate = $row["photo_date"];
            $mediaType = $row["media_type"];
            $copyright = "";
            if (isset($row["copyright"]) && !empty($row["copyright"])) {
                $copyright = $row["copyright"];
            }
            $explanation = $row["explanation"];

            $jsonResponse = array();
            $jsonResponse[] = array("url" => $url, "title" => $title, "date" => $photoDate, "media_type" => $mediaType, "copyright" => $copyright, "explanation" => $explanation);

            // send back JSON data
            header('Content-Type: application/json');
            echo json_encode($jsonResponse);

        }
        else {
            // photo data is new - must grab from API

            // 1. Create Data
            $data = array(
                "api_key" => $api_key,
                "start_date" => $_GET["searchDate"],
                "end_date" => $_GET["searchDate"]
            );

            // Dummy Data
            // $data = array ( "api_key" => $api_key, "start_date" => "2020-01-01", "end_date" => "2020-01-01");

            // 2. Determine URL
            $url = "https://api.nasa.gov/planetary/apod?" . http_build_query($data);

            // 3. Make request
            // initialize curl session
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
            ));

            // 4. Parse Response
            $response = curl_exec($curl);

            // get the response
            $responseCopy = json_decode($response, true);

            $filteredResponse = array();

            // This will parse out result from the JSON data and store into associative array
            foreach ($responseCopy as $key => $result) {
                foreach ($result as $key => $value) {
                    $filteredResponse[$key] = $value;

                }
            }

            $jsonArrayResponse = array();
            $jsonArrayResponse[] = $filteredResponse;


            // add the API JSON response to the database to "cache" it
            $url = $filteredResponse["url"];
            $title = $filteredResponse["title"];
            $media_type = $filteredResponse["media_type"];
            $copyright = "";
            if (!isset($filteredResponse["copyright"]) && empty($filteredResponse["copyright"])) {
                $copyright = null;
            } else {
                $copyright = $filteredResponse["copyright"];
            }

            $explanation = $filteredResponse["explanation"];

            $sqlInsert = $mysqli->prepare("INSERT INTO photos (url, photo_date, title, media_type, copyright, explanation) VALUES (?,?,?,?,?,?);");

            $sqlInsert->bind_param("ssssss",
                $url,
                $mysqldate,
                $title,
                $media_type,
                $copyright,
                $explanation
            );

            $sqlInsert->execute();

            if (!$sqlInsert) {
                //echo $mysqli->error;
                exit();
            }




            // send JSON response to frontend
            header('Content-Type: application/json');
//            echo json_encode($response);
            echo json_encode($jsonArrayResponse);

            // close statement
            $sqlInsert->close();

        }
        // close statements
        $sqlSelect->close();

        // close DB connection
        $mysqli->close();
    }
    else {
        // return some error message
        header('Content-Type: application/json');
        $jsonMessage = array("message" => "You are only allowed to input dates up to and including today.");
        echo json_encode($jsonMessage);
    }

}


?>