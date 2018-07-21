<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(2);

$data = [];
$selectFatt = "SELECT id, numero, aggiunta_numero, totale
               FROM fatture
               WHERE id_cliente = :id
               ORDER BY id";

$id = 0;
$selectId = "SELECT id
             FROM clienti
             WHERE utente = :id";

try {
    //Prendo l'id del cliente 
    $stmt = $db->prepare($selectId);
    $stmt->bindParam(":id", $_SESSION['user']['id']);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $res["id"];
    }

    $stmt = $db->prepare($selectFatt);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'id' => $res["id"],
            'numero' => $res["numero"],
            'aggiunta' => $res["aggiunta_numero"],
            'totale' => $res["totale"],
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/cliente/index.php';