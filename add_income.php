<?php
session_start();

$all_correct = true;

$_SESSION['income_form_amount'] = $_POST['income_amount'];
$_SESSION['income_form_date'] = filter_input(INPUT_POST, 'income_date');
$_SESSION['income_form_category'] = filter_input(INPUT_POST, 'income_category', FILTER_SANITIZE_STRING);
if(strlen(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING)) > 0)
{
    $_SESSION['income_form_comment'] = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
}

$income_amount = $_POST['income_amount'];

$income_amount = str_replace(',', '.', $income_amount);

if($income_amount <= 0)
{
    $all_correct = false;
    $_SESSION['e_income_amount'] = "Wartość przychodu musi być większa od 0";
    header('Location: income.php');
    exit();
}

$income_date = filter_input(INPUT_POST, 'income_date');

$income_category = filter_input(INPUT_POST, 'income_category', FILTER_SANITIZE_STRING);

if(strlen($income_category) == 0)
{
    $all_correct = false;
    $_SESSION['e_income_category'] = "Należy wybrać kategorię przychodu";
    header('Location: income.php');
    exit();
}

$income_comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

if(strlen($income_comment) > 30)
{
    $all_correct = false;
    $_SESSION['e_income_comment'] = "Komentarz może mieć maksimum 30 znaków";
    header('Location: income.php');
    exit();
}

if($all_correct)
{
    $user_id = $_SESSION['logged_id'];

    require_once 'database.php';

    $sql_select_category = "SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :income_category";
    $query_select = $db->prepare($sql_select_category);
    $query_select->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query_select->bindValue(':income_category', $income_category, PDO::PARAM_STR);
    $query_select->execute();

    $result = $query_select->fetch();

    $income_category_number = $result[0];

    $sql_insert_income = "INSERT INTO incomes VALUES(NULL, :id_user, :income_category, :income_amount, :income_date, :income_comment)"; 
    $query_income = $db->prepare($sql_insert_income);
    $query_income->bindValue(':id_user', $user_id, PDO::PARAM_INT);
    $query_income->bindValue(':income_category', $income_category_number, PDO::PARAM_INT);
    $query_income->bindValue(':income_amount', $income_amount, PDO::PARAM_STR);
    $query_income->bindValue(':income_date', $income_date, PDO::PARAM_STR);
    $query_income->bindValue(':income_comment', $income_comment, PDO::PARAM_STR);
    $query_income->execute();

    $_SESSION['add_income'] = true;
    unset($_SESSION['income_form_amount']);
    unset($_SESSION['income_form_date']);   
    unset($_SESSION['income_form_category']);
    if(isset($_SESSION['income_form_comment']))
    {
        unset($_SESSION['income_form_comment']);
    }
    header('Location: income.php');
}