<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$id = $_REQUEST["id"];
$payments = $_REQUEST["pay"] == "true" ? 1 : 0;

$query = "UPDATE `spese` 
          SET `pagata`= :pay
          WHERE `id` = :id";

try {
    $db->beginTransaction();
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pay", $payments);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $db->commit();
    echo "OK";
} catch (PDOExeptcion $e) {
    $db->rollBack();
    echo $e->getMessage();
}
