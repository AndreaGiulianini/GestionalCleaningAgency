<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$update = "UPDATE spedizioni SET eseguita=:bool WHERE id=:id";

try {
    $stmt = $db->prepare($update);
    $stmt->bindParam(":bool", $_REQUEST["eseguita"]);
    $stmt->bindParam(":id", $_REQUEST["id"]);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
