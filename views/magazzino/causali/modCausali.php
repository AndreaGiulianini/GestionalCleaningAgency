<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$causale = $_REQUEST["causale"];
$id = $_REQUEST["id"];

$updateCau = "UPDATE causali
              SET causale=:causale
              WHERE id=:id";

try {
    $db->beginTransaction();

    $stmt = $db->prepare($updateCau);
    $stmt->bindParam(":causale", $causale);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
