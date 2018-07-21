<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$causale = $_REQUEST["nome"];

$insertCau = "INSERT INTO `causali`(`causale`)
              VALUES (:causale)";

try {
    $db->beginTransaction();
    $stmt = $db->prepare($insertCau);
    $stmt->bindParam(":causale", $causale);
    $stmt->execute();

    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
