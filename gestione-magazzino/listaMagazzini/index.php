<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$magazzini = [];

$selectMagazzini = "SELECT m.id AS id,  m.nome AS MagNome
             FROM magazzini AS m
             ORDER BY UPPER(MagNome)";

try {
    $stmt = $db->prepare($selectMagazzini);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $magazzini[] = [
            'id' => $res["id"],
            'n' => $res["MagNome"],
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/magazzino/listaMagazzini/index.php';
