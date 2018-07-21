<?php


session_start();
if (isset($_SESSION['auth'])) {
    header("Location: /");
    die();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/login/login.php';
