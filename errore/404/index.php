<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(1);
$user = $_SESSION['user'];
require $_SERVER['DOCUMENT_ROOT'] . '/views/errore/404.php';
