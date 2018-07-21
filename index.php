<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/check.php';
checkAuth(1);

$user = $_SESSION['user'];
switch ($user['role']) {
    case 1:
        header("Location: /gestione-dipendente");
        break;
    case 2:
        header("Location: /gestione-cliente");
        break;
    case 3:
        header("Location: /gestione-magazzino");
        break;
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/homepage/riepilogo.php';
