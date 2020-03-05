<?php
session_start();

unset($_SESSION['logged_id']);
unset($_SESSION['logged_user']);

header('Location: index.php');