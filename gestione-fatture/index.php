<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$clients = [];
$employees = [];
$numero = "";
$selClients = "SELECT id,nome FROM clienti WHERE 1";
$selEmployees = "SELECT id,nome,cognome FROM dipendenti WHERE 1";
$lastInvo = "SELECT numero FROM fatture ORDER BY id DESC LIMIT 1";

try {
    $stmt = $db->prepare($selClients);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $clients[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
        ];
    }

    $stmt = $db->prepare($selEmployees);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $employees[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
            'cognome' => $res["cognome"],
        ];
    }

    $stmt = $db->prepare($lastInvo);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $numero = $res["numero"];
    }

    require $_SERVER['DOCUMENT_ROOT'] . '/views/fatture/index.php';
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}
