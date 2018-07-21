<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$prodotti = [];
$magazzini = [];
$causali = [];
$selectInner = "SELECT i.id AS inventario, i.quantita AS quant, m.nome AS mnome, a.nome AS anome
          FROM (anagrafica AS a INNER JOIN inventario AS i ON a.id = i.id_prodotto
                INNER JOIN magazzini AS m ON m.id = i.id_magazzino )
          WHERE 1";

$selectMag = "SELECT id, nome, descrizione FROM magazzini WHERE 1";
$selectCausale = "SELECT id, causale FROM `causali` WHERE 1";

try {
    $stmt = $db->prepare($selectInner);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $prodotti[] = [
            'inventario' => $res["inventario"],
            'quant' => $res["quant"],
            'mnome' => $res["mnome"],
            'anome' => $res["anome"],
        ];
    }

    $stmt = $db->prepare($selectCausale);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $causali[] = [
            'id' => $res["id"],
            'causale' => $res["causale"],
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

} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/magazzino/spedizioni/index.php';
