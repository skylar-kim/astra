<?php
require 'config/config.php';
/*
 * PURPOSE: This PHP file is an admin-only accessible page. This file does the server side validation and either
 * Update or Creation of a new APOD Entry for today's date.
 * If the user session active is an admin session and the create_form.php sent over all required fields,
 * the PHP program checks if there is already a APOD entry in the DB for today's date.
 * If an APOD entry for today's date already exists, then the PHP program will write over the existing data.
 * If an APOD entry for today's date does not already exist, then the PHP program will create a new APOD entry for
 * today's date.
 *
 * The status of the update/creation will be shown in the HTML div.
 */
// this page is an admin-only accessible page
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true
    && isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {

//    var_dump($_POST);
    // server side validation of input fields
    if (!isset($_POST["url"]) || empty($_POST["url"])
        || !isset($_POST["title"]) || empty($_POST["title"])
        || !isset($_POST["media"]) || empty($_POST["media"])
        || !isset($_POST["explanation"]) || empty($_POST["explanation"])) {
        $error = "Please fill out all required fields.";
    } else {
        // Connect to DB
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_errno) {
            exit();
        }

        // Basically, we are either creating a new APOD entry for today's date OR
        // if an entry for today's date was already requested from the API and stored into our DB
        // then just overwrite the data

        // Check if an APOD entry for today's date already exists
        date_default_timezone_set('America/Los_Angeles');

        // get today's date
        $date = date('Y-m-d', time());
        //echo $date;

        // search DB to see if there is a photo entry with today's date
        $sqlSelect = $mysqli->prepare("SELECT * FROM photos WHERE photo_date = ?;");

        $sqlSelect->bind_param("s", $date);

        $sqlSelect->execute();

        if (!$sqlSelect) {
            exit();
        }

        $result = $sqlSelect->get_result();

        // entry already exists, must overwrite
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $photoId = $row["photo_id"];

            $url = $_POST["url"];
            $title = $_POST["title"];
            $media_type = "";
            if ($_POST["media"] == "1") {
                $media_type = "image";
            } else if ($_POST["media"] == "2") {
                $media_type = "video";
            }
            $copyright = "";
            $explanation = $_POST["explanation"];

            // Copyright is not set
            if (!isset($_POST["copyright"]) && empty($_POST["copyright"])) {

                $sqlUpdate = $mysqli->prepare("UPDATE photos SET url = ?, title = ?, media_type = ?, explanation = ? WHERE photo_id = ?");

                $sqlUpdate->bind_param("ssssi",
                    $url,
                    $title,
                    $media_type,
                    $explanation,
                    $photoId
                );

                $sqlUpdate->execute();

                if (!$sqlUpdate) {
                    exit();
                }

                $success = "Update Photo Success";

                // close statement
                $sqlUpdate->close();

            }
            // Copyright is set
            else {

                $copyright = $_POST["copyright"];

                $sqlUpdate = $mysqli->prepare("UPDATE photos SET url = ?, title = ?, media_type = ?, copyright = ?, explanation = ? WHERE photo_id = ?;");


                $sqlUpdate->bind_param("sssssi",
                    $url,
                    $title,
                    $media_type,
                    $copyright,
                    $explanation,
                    $photoId
                );


                $sqlUpdate->execute();

                if (!$sqlUpdate) {
                    exit();
                }

                // close statement
                $sqlUpdate->close();

                $success = "Update Photo Success";
            }

        } // entry does not exist, must insert new entry
        else if ($result->num_rows == 0) {

            $url = $_POST["url"];
            $title = $_POST["title"];
            $media_type = "";
            if ($_POST["media"] == "1") {
                $media_type = "image";
            } else if ($_POST["media"] == "2") {
                $media_type = "video";
            }
            $copyright = "";
            if (!isset($_POST["copyright"]) && empty($_POST["copyright"])) {
                $copyright = null;
            } else {
                $copyright = $_POST["copyright"];
            }
            $explanation = $_POST["explanation"];

            $sqlInsert = $mysqli->prepare("INSERT INTO photos (url, photo_date, title, media_type, copyright, explanation) VALUES (?,?,?,?,?,?);");

            $sqlInsert->bind_param("ssssss",
                $url,
                $date,
                $title,
                $media_type,
                $copyright,
                $explanation
            );

            $sqlInsert->execute();

            if (!$sqlInsert) {
                exit();
            }

            // close statement
            $sqlInsert->close();

            $success = "Insert Photo Success";
        } // this is bad. means there was more than 1 entry of the same date
        else {
            $error = "There was more than 1 entry.";
        }

        // Close Statements
        $sqlSelect->close();

        // Close Connection
        $mysqli->close();
    }

} else {
    // user session not active: direct to index page
    // or user session active but not admin user, direct to index page
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ASTRA | Create Form Confirmation</title>

    <meta charset="UTF-8">
    <!-- BOOTSTRAP STYLING -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <!-- RESPONSIVENESS -->
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <style type="text/css">
        .confirmation-message {
            color: white;
        }
    </style>
</head>
<body>

<div class="top-half">
    <?php include 'navbar.php'; ?>

    <div class="sticky-top hidden-spacer"></div>

    <div class="container">
        <div class="row justify-content-center">
            <?php if (isset($error) && !empty($error) && !isset($success) && empty($success)): ?>
                <h1 class="col-12 text-center confirmation-message"><?php echo $error; ?></h1>
            <?php elseif (!isset($error) && empty($error) && isset($success) && !empty($success)): ?>
                <h1 class="col-12 text-center confirmation-message">Successfully Added</h1>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- POPPERS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<!-- BOOTSTRAP -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>
</html>