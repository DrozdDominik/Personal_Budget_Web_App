<?php
session_start();

$_SESSION['income_form_amount'] = "";

$current_date = new DateTime();

$_SESSION['income_form_date'] = $current_date->format('Y-m-d');

$_SESSION['income_form_category'] = "";

$_SESSION['income_form_comment'] = "";

header('Location: income.php');
