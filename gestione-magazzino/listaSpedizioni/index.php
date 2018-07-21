<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$ids = [];
$mag = [];
$selectSpe = "SELECT id, id_provenienza AS idp, id_destinazione AS idd, num_bolla, data, data_scadenza, eseguita
          FROM spedizioni
          WHERE 1
          ORDER BY id";

$selectMag = "SELECT m.id AS id, m.nome AS MagNome
             FROM magazzini AS m
             WHERE 1
             ORDER BY id";

try {
    $stmt = $db->prepare($selectMag);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mag[] = [
            "id" => $res["id"],
            "nome" => $res["MagNome"],
        ];
    }

    $stmt = $db->prepare($selectSpe);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($res["data_scadenza"] != "") {
            $css = "";
            $data = new DateTime($res["data_scadenza"]);
            $dataNow = new DateTime();
            $interval = $dataNow->diff($data);
            $anni = $interval->format('%Y');
            $mesi = $interval->format('%m');
            $giorni = $interval->format('%d');
            if ($giorni < 10 && $anni == 0 && $mesi == 0) {
                $css = 'class="text-warning" style="font-weight:700"';
            }
            if ($interval->invert) {
                $css = 'class="text-danger" style="font-weight:700"';
            }
            if ($res['eseguita']) {
                $css = 'class="text-success" style="font-weight:700"';
            }
            $data = (new DateTime($res["data_scadenza"]))->format("d/m/Y");
        } else {
            $data = "";
            $css = "";
        }
        $ids[] = [
            'id' => $res["id"],
            'nomeP' => nameMag($res["idp"], $mag),
            'nomeD' => nameMag($res["idd"], $mag),
            'bolla' => $res["num_bolla"],
            'data' => (new DateTime($res["data"]))->format("d/m/Y"),
            'dataScadenza' => $data,
            'css' => $css,
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

function nameMag($id, $mag)
{
    for ($i = 0; $i < count($mag); $i++) {
        if ($id == $mag[$i]["id"]) {
            return $mag[$i]["nome"];
        }
    }
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/magazzino/listaSpedizioni/index.php';