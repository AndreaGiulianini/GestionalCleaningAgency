<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(2);

$idM = $_REQUEST["source"];
$product = [];

$query = "SELECT i.id AS id, i.quantita AS quant, a.nome AS nome 
          FROM (anagrafica AS a INNER JOIN inventario AS i ON a.id = i.id_prodotto)
          WHERE i.id_magazzino = :idM AND a.old = 0
          ORDER BY nome";

try {

    $stmt = $db->prepare($query);
    $stmt->bindParam(":idM", $idM);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product[] = [
            "id" => $res["id"],
            "quant" => $res["quant"],
            "nome" => $res["nome"],
        ];
    }

    echo json_encode($product);
} catch (PDOException $e) {
    echo $e->getMessage();
}
