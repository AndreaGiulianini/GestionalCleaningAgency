<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$causali = [];
$selectCausali = "SELECT id,causale FROM causali WHERE 1";

try {
    $stmt = $db->prepare($selectCausali);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $causali[] = [
            'id' => $res["id"],
            'causale' => $res["causale"],
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/magazzino/causali/index.php';
