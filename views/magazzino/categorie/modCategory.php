<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$nome = $_REQUEST["nome"];
$descrizione = $_REQUEST["desc"];
$id = $_REQUEST["id"];

$updateCat = "UPDATE categoria
              SET nome=:nome, descrizione=:descrizione
              WHERE id=:id";

try {
    $db->beginTransaction();

    $stmt = $db->prepare($updateCat);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":descrizione", $descrizione);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
