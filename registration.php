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
        $sql_insert_user = "INSERT INTO users VALUES (NULL, :username, :password, :email)";
        $sql_insert_incomes = "INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT users.id, incomes_category_default.name FROM users, incomes_category_default WHERE users.email= :email";
        $sql_insert_expenses ="INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT users.id, expenses_category_default.name FROM users, expenses_category_default WHERE users.email= :email";
        $sql_insert_payment ="INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT users.id, payment_methods_default.name FROM users, payment_methods_default WHERE users.email= :email";
        $query_user = $db->prepare($sql_insert_user);
        $query_user->bindValue(':username', $name, PDO::PARAM_STR);
        $query_user->bindValue(':password', $password_hash, PDO::PARAM_STR);
        $query_user->bindValue(':email', $email, PDO::PARAM_STR);
        $query_user->execute();
        $query_incomes = $db->prepare($sql_insert_incomes);
        $query_incomes->bindValue(':email', $email, PDO::PARAM_STR);
        $query_incomes->execute();
        $query_expenses = $db->prepare($sql_insert_expenses);
        $query_expenses->bindValue(':email', $email, PDO::PARAM_STR);
        $query_expenses->execute();
        $query_payment = $db->prepare($sql_insert_payment);
        $query_payment->bindValue(':email', $email, PDO::PARAM_STR);
        $query_payment->execute();

        $_SESSION['correct_registration'] = true;
        unset($_SESSION['form_name']);
        unset($_SESSION['form_email']);
        unset($_SESSION['form_password']);
        header('Location: congratulation.php');
        exit();
    }
    else{
        header('Location: index.php');
        exit();
    }
}