<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(1);

$title = null;
$desc = null;
$user = $_SESSION['user'];

require $_SERVER['DOCUMENT_ROOT'] . '/views/errore/generico.php';
