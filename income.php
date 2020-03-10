<?php
session_start();

if(!isset($_SESSION['logged_id']))
{
    header('Location: index.php');
}

$current_date = new DateTime();
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
    <title>Add income</title>
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
            <h1 class="display-4 text-center">Dodaj przychód</h1>
            <hr class="my-4">
            <div class="d-flex justify-content-center">
                <img src="img/logo.png" class="header__logo img-fluid" alt="logo aplikacji">
            </div>
            <?php
            echo isset($_SESSION['add_income']) ? '<p class="display-4 text-center text-success">Przychód dodano prawidłowo!</p>': '';
            unset($_SESSION['add_income']);
            ?>
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
        <div class="card mb-2">
            <i class="fas fa-wallet card-img-top display-2 text-center"></i>
            <div class="card-body">
                <h5 class="card-title">Dodaj przychód</h5>
                <form method="post" action="add_income.php">
                    <div class="form-group">
                        <label for="amount">Kwota</label>
                        <input type="number" class="form-control" step="0.01" min="0.01" id="amount" name="income_amount" value="<?php 
                                if(isset($_SESSION['income_form_amount']))
                                {
                                   echo $_SESSION['income_form_amount'];       
                                } 
                                unset($_SESSION['income_form_amount']);
                                ?>">
                    </div>
                    <?php
                        if(isset($_SESSION['e_income_amount']))
                        {
                            echo'<div class="text-danger">'.$_SESSION['e_income_amount'].'</div>';
                            unset($_SESSION['e_income_amount']);
                        }
                        ?>
                    <div class="form-group">
                        <label for="date">Data</label>
                        <input type="date" class="form-control" id="date" name="income_date" value="<?php 
                          if(isset($_SESSION['income_form_date']))
                          {
                             echo $_SESSION['income_form_date'];  
                             unset($_SESSION['income_form_date']); 
                          }
                          else
                          {
                            echo $current_date->format('Y-m-d');     
                          }         
                         ?>">
                    </div>
                    <label class="form-check-label">Kategoria:</label>
                    <div class="form-check" id="radioInputs">
                        <input class="form-check-input" type="radio" name="income_category" id="salary" value="Salary" <?php 
                        if(isset($_SESSION['income_form_category']))
                        {
                            echo ($_SESSION['income_form_category'] == 'Salary') ?  "checked" : "";
                        }   
                        ?>>
                        <label class="form-check-label" for="salary">Wynagrodzenie</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="income_category" id="interest" value="Interest" <?php 
                        if(isset($_SESSION['income_form_category']))
                        {
                            echo ($_SESSION['income_form_category'] == 'Interest') ?  "checked" : "";
                        }   
                        ?>>
                        <label class="form-check-label" for="interest">Odsetki bankowe</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="income_category" id="allegro" value="Allegro" <?php 
                        if(isset($_SESSION['income_form_category']))
                        {
                            echo ($_SESSION['income_form_category'] == 'Allegro') ?  "checked" : "";
                        }   
                        ?>>
                        <label class="form-check-label" for="allegro">Sprzedaż na Allegro</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="income_category" id="other" value="Another" <?php
                        if(isset($_SESSION['income_form_category']))
                        { 
                        echo ($_SESSION['income_form_category'] == 'Another') ?  "checked" : ""; 
                        unset($_SESSION['income_form_category']); 
                        }
                        ?>>
                        <label class="form-check-label" for="other">Inne</label>
                    </div>
                    <?php
                        if(isset($_SESSION['e_income_category']))
                        {
                            echo'<div class="text-danger">'.$_SESSION['e_income_category'].'</div>';
                            unset($_SESSION['e_income_category']);
                        }
                        ?>
                    <textarea class="form-control my-3 textarea" placeholder="Komentarz (opcjonalnie)" name="comment" rows="4" cols="30"><?php 
                    if(isset($_SESSION['income_form_comment']))
                    {
                        echo $_SESSION['income_form_comment'];
                        unset($_SESSION['income_form_comment']);
                    } 
                    ?></textarea>
                    <?php
                        if(isset($_SESSION['e_income_comment']))
                        {
                            echo'<div class="text-danger">'.$_SESSION['e_income_comment'].'</div>';
                            unset($_SESSION['e_income_comment']);
                        }
                        ?>
                    <input type="submit" value="Dodaj!" class="btn btn-primary">
                    <a href="clean_income.php" class="btn btn-danger cancelBtn">Anuluj</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>