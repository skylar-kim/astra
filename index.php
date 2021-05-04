<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Astra | Home</title>
    <meta charset="UTF-8">
    <!-- BOOTSTRAP STYLING -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <!-- RESPONSIVENESS -->
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/index.css">

</head>
<body>
<div class="top-half">
    <?php include 'navbar.php'; ?>


    <div class="sticky-top hidden-spacer"></div>

    <div class="wrap">
        <div class="container my-5 py-5 mx-auto mr-auto">
            <div class="row justify-content-center my-3 slide-up">
                <h1 class="title-style col-12 col-sm-12 col-md-12 col-lg-12">A S T R A</h1>
                <h2 class="description-style col-12 col-sm-12 col-md-12 col-lg-12">discover your next astronomy photo of
                    the day</h2>
                <a href="search.php" class="btn btn-outline-light btn-lg">search for the stars</a>
            </div>
        </div>
    </div>
</div>


<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
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