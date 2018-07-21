<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function checkAuth($perm)
{
    if (!isset($_SESSION['auth'])) {
        $_SESSION['err'] = 1;
        $_SESSION['prec_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        header("Location: /login.php");
        die();
    } elseif ($_SESSION['user']['role'] < $perm) {
        $_SESSION['err'] = 3;
        header("Location: /errore/403/");
        die();
    } else {
        unset($_SESSION['err']);
    }
}
