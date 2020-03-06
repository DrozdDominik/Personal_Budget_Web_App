<?php
session_start();

if(!isset($_SESSION['logged_id']))
{
    if(isset( $_POST['email']))
    {
        $password = filter_input(INPUT_POST, 'password');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if(empty($email))
        {
            $_SESSION['err_email'] = true;
            $_SESSION['given_email'] = $_POST['email'];
            header('Location: index.php');
            exit();
        } else {
            require_once 'database.php';
            $sql = 'SELECT id, username, password FROM `users` WHERE email = :email';
            $query = $db->prepare($sql);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();

            $user = $query->fetch();

            if($user && password_verify($password, $user['password']))
            {
                $_SESSION['logged_id'] = $user['id'];
                $_SESSION['logged_user'] = $user['username'];
                unset($_SESSION['bad_attempt']);
                header('Location: menu.php');
                exit();
            }else{
                $_SESSION['bad_attempt'] = true;
                $_SESSION['given_email'] = $_POST['email'];
                header('Location: index.php');
                exit();
            }
        }
    } else {
        header('Location: index.php');
        exit();
    }
}





