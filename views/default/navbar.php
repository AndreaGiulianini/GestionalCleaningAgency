<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Navbar.php';
$nav = new Navbar();
echo $nav->initialize($_SESSION['user']);
