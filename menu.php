<?php
session_start();

if(!isset($_SESSION['logged_id']))
{
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.2/bootstrap-float-label.min.css"/>
    <link rel="shortcut icon" type="image/ico" href="img/favicon.png">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <title>Main menu</title>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <p class="text-primary">Personal Budget</p>
            <p class="ml-auto">Zalogowany jako:
                <span class="text-success"><?= $_SESSION['logged_user'] ?></span>
            </p>
            <a href="logout.php" class="btn btn-danger ml-2">Wyloguj</a>
        </div>
    </nav>
    <header class="header"></header>
    <div class="jumbotron">
        <h1 class="display-4 text-center">Witaj w menu głównym</h1>
        <p class="lead text-center">Zalogowany prawidłowo!</p>
        <hr class="my-4">
        <div class="d-flex justify-content-center">
            <img src="img/logo.png" class="header__logo img-fluid" alt="logo aplikacji">
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="income.php" class="nav-link"><i class="fas fa-wallet mr-1"></i>Dodaj przychód</a>
                    </li>
                    <li class="nav-item">
                        <a href="expense.php" class="nav-link"><i class="fas fa-shopping-cart mr-1"></i>Dodaj wydatek</a>
                    </li>
                    <li class="nav-item">
                        <a href="balance.php" class="nav-link"><i class="fas fa-balance-scale mr-1"></i>Przeglądaj bilans</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-wrench mr-1"></i>Ustawienia</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt mr-1"></i>Wyloguj się</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
