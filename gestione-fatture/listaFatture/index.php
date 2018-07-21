<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$fatture = [];
$selectFatt = "SELECT f.id, f.numero, f.aggiunta_numero AS addN, f.totale, c.nome AS nomeInterno, ce.nome AS nomeEsterno
          FROM fatture AS f LEFT JOIN clienti AS c ON f.id_cliente = c.id
          LEFT JOIN clienti_esterni AS ce ON ce.id = f.id_cliente_esterno
          ORDER BY f.numero";
try {
    $stmt = $db->prepare($selectFatt);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fatture[] = [
            'id' => $res["id"],
            'numero' => $res["numero"],
            'add' => $res["addN"],
            'totale' => str_replace(".", ",", $res['totale']),
            'nomeInterno' => $res["nomeInterno"],
            'nomeEsterno' => $res["nomeEsterno"],
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/fatture/listaFatture/index.php';
