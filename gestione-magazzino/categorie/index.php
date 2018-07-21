<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$categorie = [];
$selectCat = "SELECT id, nome, descrizione FROM categoria WHERE 1";
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
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/magazzino/categorie/index.php';
