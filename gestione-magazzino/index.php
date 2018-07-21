<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$categorie = [];
$magazzini = [];
$prodotti = [];

$selectCat = "SELECT id, nome, descrizione FROM categoria WHERE 1";
$selectMag = "SELECT id, nome, descrizione FROM magazzini WHERE 1";
$selectAna = "SELECT id, nome FROM anagrafica WHERE old=0";

try {
    $stmt = $db->prepare($selectCat);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categorie[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
            'descrizione' => $res["descrizione"]
        ];
    }

    $stmt = $db->prepare($selectMag);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $magazzini[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
            'descrizione' => $res["descrizione"],
        ];
    }

    $stmt = $db->prepare($selectAna);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $prodotti[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
        ];
    }
    require $_SERVER['DOCUMENT_ROOT'] . '/views/magazzino/index.php';
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}
