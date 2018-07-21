<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$prodotti = [];
$categoria = [];
$select = "SELECT a.id, a.nome AS ana_nome, a.prezzo_vendita, a.prezzo_acquisto, c.nome AS categoria_nome
          FROM anagrafica AS a INNER JOIN categoria AS c ON c.id = a.id_categoria
          WHERE a.old=0";
$selectCat = "SELECT id, nome FROM categoria WHERE 1 ORDER BY nome";
try {
    $stmt = $db->prepare($select);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $prodotti[] = [
            'id' => $res["id"],
            'ana_nome' => $res["ana_nome"],
            'prezzo_vendita' => str_replace(".", ",", $res["prezzo_vendita"]),
            'prezzo_acquisto' => str_replace(".", ",", $res["prezzo_acquisto"]),
            'categoria_nome' => $res["categoria_nome"],
        ];
    }

    $stmt = $db->prepare($selectCat);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categoria[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/magazzino/listaProdotti/index.php';
