<?php
session_start();

if(isset($_POST['user_name']))
{
    $all_correct = true;

    $name = $_POST['user_name'];

    if((strlen(($name)) < 2) || (strlen(($name)) > 12))
    {
        $all_correct =  false;
        $_SESSION['e_registration'] = true;
        $_SESSION['e_name'] = "Imię musi posiadać od 2 do 12 znaków";
    }

    $expresion = '/^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ\s]+$/';
    if(preg_match($expresion, $name) == false)
    {
        $all_correct =  false;
        $_SESSION['e_registration'] = true;
        $_SESSION['e_name'] = "Imię nie może zawierać znaków innych niż litery";
    }

    $email = $_POST['email'];
    $email_save = filter_var($email, FILTER_SANITIZE_EMAIL);

    if((filter_var($email_save,FILTER_VALIDATE_EMAIL)== false) || ($email_save != $email))
    {
        $all_correct =  false;
        $_SESSION['e_registration'] = true;
        $_SESSION['e_email'] = "Podaj poprawny adres email";
    }

    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    if((strlen($password) < 8) || (strlen($password) > 20))
    {
        $all_correct =  false;
        $_SESSION['e_registration'] = true;
        $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
    }

    if($password != $password_repeat)
    {
        $all_correct =  false;
        $_SESSION['e_registration'] = true;
        $_SESSION['e_password'] = "Podane hasła nie są identyczne";
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $_SESSION['form_name'] = $name;
    $_SESSION['form_email'] = $email;
    $_SESSION['form_password'] = $password;

    require_once 'database.php';
    $sql_select = 'SELECT id FROM users WHERE email = :email';
    $query = $db->prepare($sql_select);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch();

    if($user)
    {
        $all_correct =  false;
        $_SESSION['e_registration'] = true;
        $_SESSION['e_email'] = "Konto przypisane do podanego adresu email już istnieje";
    }

    if($all_correct)
    {
        $sql_insert = "INSERT INTO users VALUES (NULL, :username, :password, :email)";
        $query = $db->prepare($sql_insert);
        $query->bindValue(':username', $name, PDO::PARAM_STR);
        $query->bindValue(':password', $password_hash, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['correct_registration'] = true;
        header('Location: congratulation.php');
        exit();
    }
    else{
        header('Location: index.php');
        exit();
    }
}