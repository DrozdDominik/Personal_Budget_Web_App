<?php
session_start();
if(!isset($_SESSION['correct_registration']))
{
    header('Location: index.php');
}
else
{
    unset($_SESSION['correct_registration']);
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.2/bootstrap-float-label.min.css"/>
    <link rel="shortcut icon" type="image/ico" href="img/favicon.png">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <title>Personal Budget</title>
</head>
<body>
<div class="container">
    <header class="header">
        <div class="jumbotron">
            <h1 class="display-3 text-success text-center">Udana rejestracja!</h1>
            <p class="display-4 text-success text-center">Teraz możesz się juz zalogować</p>
            <hr class="my-4">
            <div class="d-flex justify-content-center">
            <img src="img/logo.png" class="header__logo img-fluid" alt="logo aplikacji">
            </div>
            <div class="d-flex flex-column">
                <a class="btn btn-primary stretched-link my-2" href="index.php">Kliknij by powrócić do stony logowania</a>
            </div>
        </div>
    </header>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>