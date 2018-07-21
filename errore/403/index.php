<?php


session_start();
if (!isset($_SESSION['err']) || $_SESSION['err'] != 3) {
    $_SESSION['err'] = 0;
    header("Location: /");
}
$_SESSION['err'] = 0;
$user = $_SESSION['user'];

require $_SERVER['DOCUMENT_ROOT'] . '/views/errore/403.php';
