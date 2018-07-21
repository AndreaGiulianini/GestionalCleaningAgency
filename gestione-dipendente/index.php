<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(1);

$data = [];
$selectData = "SELECT sf.descrizione AS nomeServizio, f.numero AS numero, f.aggiunta_numero AS addN, f.id_cliente, f.id_cliente_esterno, sf.data
               FROM servizi_fattura AS sf INNER JOIN fatture AS f ON f.id = sf.id_fattura
               WHERE sf.id_dipendente = :id
               ORDER BY sf.id";

$selectCli = "SELECT nome, via
                FROM clienti
                WHERE id=:id";

$selectCliE = "SELECT nome, via
                FROM clienti_esterni
                WHERE id=:id";

try {
    $stmt = $db->prepare($selectData);
    $stmt->bindParam(":id", $_SESSION['user']['id']);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'nome' => $res["nomeServizio"],
            'numero' => $res["numero"],
            'add' => $res["addN"],
            'idC' => $res["id_cliente"],
            'idCE' => $res["id_cliente_esterno"],
            'data' => (new DateTime($res["data"]))->format('d/m/Y'),
        ];
    }

    foreach ($data as $key => $d) {
        if ($d['idC'] != null) {
            $stmt = $db->prepare($selectCli);
            $stmt->bindParam(":id", $d['idC']);
            $stmt->execute();
            if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[$key][] = [
                    'nomeC' => $res["nome"],
                    'viaC' => $res["via"],
                ];
            }
        } else {
            $stmt = $db->prepare($selectCliE);
            $stmt->bindParam(":id", $d['idCE']);
            $stmt->execute();
            if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[$key][] = [
                    'nomeC' => $res["nome"],
                    'viaC' => $res["via"],
                ];
            }
        }

    }
    //var_dump($data);
    //die();

} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/dipendenti/listServices/index.php';