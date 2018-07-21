<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(2);
$user = $_SESSION['user'];
$nome = $_REQUEST["name"];
$desc = $_REQUEST["desc"];
$street = $_REQUEST["street"];
$insertMag = "INSERT INTO magazzini(nome, descrizione, indirizzo,utente)
              VALUES (:nome,:desc,:street,:utente)";
try {
    $db->beginTransaction();
    $stmt = $db->prepare($insertMag);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":desc", $desc);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":utente", $user['id']);
    $stmt->execute();
    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
