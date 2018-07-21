<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$id = $_REQUEST["id"];
$mag = $_REQUEST["mag"];
$count = 0;
$select = "SELECT quantita
              FROM inventario
              WHERE id_magazzino = :mag AND id_prodotto = :id";
try {
    $stmt = $db->prepare($select);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":mag", $mag);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $count = $res["quantita"];
    }

    echo $count;
} catch (PDOException $e) {
    echo $e->getMessage();
}