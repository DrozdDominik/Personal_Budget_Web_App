<?php
session_start();

$_SESSION['expense_form_amount'] = "";

$current_date = new DateTime();

$_SESSION['expense_form_date'] = $current_date->format('Y-m-d');

$_SESSION['expense_form_payment'] = "";

$_SESSION['expense_form_category'] = "";

$_SESSION['expense_form_comment'] = "";

header('Location: expense.php');
