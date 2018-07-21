<?php

// Authentication
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/check.php';

// Utility
require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Decoder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Navbar.php';

// Database
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbParams.php';

// Libs
require_once $_SERVER['DOCUMENT_ROOT'] . '/libs/pdf/tcpdf_import.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/libs/fpdf/fpdf.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/libs/fpdi/src/autoload.php';

// Vendor
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

//Init vars
try {
    $db = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbDatabase . ';charset=utf8', $dbUsername, $dbPassword, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
} catch (PDOException $e) {
    $title = 'Errore';
    $desc = 'Errore di connessione al server. Riprovare.';
    require $_SERVER['DOCUMENT_ROOT'] . '/views/errore/generico.php';
    die();
}
