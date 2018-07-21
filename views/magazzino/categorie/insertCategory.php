<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$nome = $_REQUEST["nome"];
$descrizione = $_REQUEST["descrizione"];

$insertCat = "INSERT INTO `categoria`(`nome`, `descrizione`)
              VALUES (:nome,:descrizione)";

try {
    $db->beginTransaction();
    $stmt = $db->prepare($insertCat);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":descrizione", $descrizione);
    $stmt->execute();

    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
