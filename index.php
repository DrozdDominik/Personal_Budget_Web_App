<?php
session_start();

if(isset($_SESSION['logged_id']))
{
    header('Location: menu.php');
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
            <h1 class="display-4 text-center">Witaj w aplikacji Personal Budget</h1>
            <p class="lead">Ta aplikacja pozwoli Ci usystematyzować Twój budżet domowy. Dzięki temu będziesz miał kontrolę nad swoimi finansami.</p>
            <hr class="my-4">
            <div class="d-flex justify-content-center">
                <img src="img/logo.png" class="header__logo img-fluid" alt="logo aplikacji">
            </div>
            <?php
            echo isset($_SESSION['err_email']) ? '<p class="display-4 text-center text-danger">Błąd logowania! Spróbuj ponownie!</p>': '';
            echo isset($_SESSION['bad_attempt']) ? '<p class="display-4 text-center text-danger">Błędny email lub hasło! Spróbuj ponownie!</p>': '';
            unset($_SESSION['bad_attempt']);
            echo isset($_SESSION['e_registration']) ? '<p class="display-4 text-center text-danger">Błąd rejestracji! Spróbuj ponownie!</p>': '';
            unset($_SESSION['e_registration']);
            ?>
        </div>
    </header>
    <div class="row">
        <div class="col-12 text-center col-md-6">
            <p>
                <button class="btn btn-primary w-100" type="button" data-toggle="collapse" data-target="#collapseSingUp" aria-expanded="false" aria-controls="collapseSingUp">
                    Nowy? Zarejestruj się!
                </button>
            </p>
            <div class="collapse" id="collapseSingUp">
                <div class="card card-body mb-2">
                    <form method="post" action="registration.php" class="card card-block bg-faded">
                        <label class="form-control-lg text-xs-center">Zarejestruj się</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon my-1"><i class="fas fa-user"></i></span>
                            <label class="has-float-label">
                                <input class="form-control" id="first" type="text" name="user_name" placeholder="Imię" value="<?php
                                if(isset($_SESSION['form_name']))
                                {
                                    echo $_SESSION['form_name'];
                                }
                                unset($_SESSION['form_name']);
                                ?>" required/>
                                <span>Imię</span>
                            </label>
                        </div>
                        <?php
                        if(isset($_SESSION['e_name']))
                        {
                            echo'<div class="text-danger">'.$_SESSION['e_name'].'</div>';
                            unset($_SESSION['e_name']);
                        }
                        ?>
                        <div class="form-group input-group">
                            <span class="input-group-addon my-1"><i class="fas fa-envelope"></i></span>
                            <label class="has-float-label">
                                <input class="form-control" type="email" name="email" placeholder="email@example.com" value="<?php
                                if(isset($_SESSION['form_email']))
                                {
                                    echo $_SESSION['form_email'];
                                }
                                unset($_SESSION['form_email']);
                                ?>" required/>
                                <span>Email</span>
                            </label>
                        </div>
                        <?php
                        if(isset($_SESSION['e_email']))
                        {
                            echo'<div class="text-danger">'.$_SESSION['e_email'].'</div>';
                            unset($_SESSION['e_email']);
                        }
                        ?>
                        <div class="form-group input-group">
                            <span class="input-group-addon my-1"><i class="fas fa-lock"></i></span>
                            <label class="has-float-label">
                                <input class="form-control" type="password" name="password" placeholder="••••••••" value="<?php
                                if(isset($_SESSION['form_password']))
                                {
                                    echo $_SESSION['form_password'];
                                }
                                unset($_SESSION['form_password']);
                                ?>" required/>
                                <span>Hasło</span>
                            </label>
                        </div>
                        <?php
                        if(isset($_SESSION['e_password']))
                        {
                            echo'<div class="text-danger">'.$_SESSION['e_password'].'</div>';
                            unset($_SESSION['e_password']);
                        }
                        ?>
                        <div class="form-group input-group">
                            <span class="input-group-addon my-1"><i class="fas fa-lock"></i></span>
                            <label class="has-float-label">
                                <input class="form-control" type="password" name="password_repeat" placeholder="••••••••" required/>
                                <span>Powtórz hasło</span>
                            </label>
                        </div>
                        <button class="btn btn-block btn-primary" type="submit">Zarejestruj się!</button>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-12 text-center col-md-6">
            <p>
                <button class="btn btn-primary w-100" type="button" data-toggle="collapse" data-target="#collapseSingIn" aria-expanded="false" aria-controls="collapseSingIn">
                    Masz już konto? Zaloguj się!
                </button>
            </p>
            <div class="collapse" id="collapseSingIn">
                <div class="card card-body">
                    <form method="post" action="login.php" class="card card-block bg-faded">
                        <label class="form-control-lg text-xs-center">Zaloguj się</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon my-1"><i class="fas fa-envelope"></i></span>
                            <label class="has-float-label">
                                <input class="form-control" type="email" name="email" placeholder="email@example.com" <?= isset($_SESSION['given_email']) ? 'value="'.$_SESSION['given_email'].'"' : '';
                                unset($_SESSION['given_email']);
                                ?> required/>
                                <span>Email</span>
                            </label>
                        </div>
                        <?php
                        if(isset($_SESSION['err_email']))
                        {
                            echo'<div class="text-danger">Podano niepoprawny format adresu email</div>';
                            unset($_SESSION['err_email']);
                        }
                        ?>
                        <div class="form-group input-group">
                            <span class="input-group-addon my-1"><i class="fas fa-lock"></i></span>
                            <label class="has-float-label">
                                <input class="form-control" type="password" name="password" placeholder="••••••••" required/>
                                <span>Hasło</span>
                            </label>
                        </div>
                        <button class="btn btn-block btn-primary" type="submit">Zaloguj się!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
