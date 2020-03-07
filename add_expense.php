<?php
session_start();

$all_correct = true;

$_SESSION['expense_form_amount'] = $_POST['expense_amount'];
$_SESSION['expense_form_date'] = filter_input(INPUT_POST, 'expense_date');
$_SESSION['expense_form_payment'] = filter_input(INPUT_POST, 'payment', FILTER_SANITIZE_STRING);
$_SESSION['expense_form_category'] = filter_input(INPUT_POST, 'expense_category', FILTER_SANITIZE_STRING);
if(strlen(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING)) > 0)
{
    $_SESSION['expense_form_comment'] = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
}

$expense_amount = $_POST['expense_amount'];

$expense_amount = str_replace(',', '.', $expense_amount);

if($expense_amount <= 0)
{
    $all_correct = false;
    $_SESSION['e_expense_amount'] = "Wartość wydatku musi być większa od 0";
    header('Location: expense.php');
    exit();
}

$expense_date = filter_input(INPUT_POST, 'expense_date');

$payment = filter_input(INPUT_POST, 'payment', FILTER_SANITIZE_STRING);

if(strlen($payment) == 0) 
{
    $all_correct = false;
    $_SESSION['e_payment'] = "Należy wybrać sposób płatności";
    header('Location: expense.php');
    exit();
}

$expense_category = filter_input(INPUT_POST, 'expense_category', FILTER_SANITIZE_STRING);

if(strlen($expense_category) == 0) 
{
    $all_correct = false;
    $_SESSION['e_expense_category'] = "Należy wybrać kategorię wydatku";
    header('Location: expense.php');
    exit();
}

$expense_comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

if(strlen($expense_comment) > 30)
{
    $all_correct = false;
    $_SESSION['e_expense_comment'] = "Komentarz może mieć maksimum 30 znaków";
    header('Location: expense.php');
    exit();
}

if($all_correct)
{
    $user_id = $_SESSION['logged_id'];

    require_once 'database.php';

    $sql_select_payment = "SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND name = :payment";
    $query_select_payment = $db->prepare($sql_select_payment);
    $query_select_payment->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query_select_payment->bindValue(':payment', $payment, PDO::PARAM_STR);
    $query_select_payment->execute();

    $payment_result = $query_select_payment->fetch();

    $payment_id = $payment_result[0];

    $sql_select_category = "SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :expense_category";
    $query_select_category = $db->prepare($sql_select_category);
    $query_select_category->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query_select_category->bindValue(':expense_category', $expense_category, PDO::PARAM_STR);
    $query_select_category->execute();

    $category_result = $query_select_category->fetch();

    $expense_category_number = $category_result[0];

    $sql_insert_expense = "INSERT INTO expenses VALUES(NULL, :id_user, :expense_category, :payment, :expense_amount, :expense_date, :expense_comment)"; 
    $query_expense = $db->prepare($sql_insert_expense);
    $query_expense->bindValue(':id_user', $user_id, PDO::PARAM_INT);
    $query_expense->bindValue(':expense_category', $expense_category_number, PDO::PARAM_INT);
    $query_expense->bindValue(':payment', $payment_id, PDO::PARAM_INT);
    $query_expense->bindValue(':expense_amount', $expense_amount, PDO::PARAM_STR);
    $query_expense->bindValue(':expense_date', $expense_date, PDO::PARAM_STR);
    $query_expense->bindValue(':expense_comment', $expense_comment, PDO::PARAM_STR);
    $query_expense->execute();

    $_SESSION['add_expense'] = true;
    unset($_SESSION['expense_form_amount']);
    unset($_SESSION['expense_form_date']);
    unset($_SESSION['expense_form_payment']);
    unset($_SESSION['expense_form_category']);
    if(isset($_SESSION['expense_form_comment']))
    {
        unset($_SESSION['expense_form_comment']);
    }
    header('Location: expense.php');
    exit();
}