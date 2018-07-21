<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$magazzino = [];
$selectMagazzini = "SELECT id, nome
                    FROM magazzini
                    WHERE 1";

$fatture = [];
$selectFatt = "SELECT s.id, s.url_fattura, s.pagata, s.data_scadenza, s.costo, m.nome AS nameC
             FROM spese AS s LEFT JOIN magazzini AS m ON s.id_magazzino = m.id
             WHERE 1";
try {
    $stmt = $db->prepare($selectMagazzini);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $magazzino[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
        ];
    }

    $stmt = $db->prepare($selectFatt);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($res["data_scadenza"])) {
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
            if ($interval->invert == 1) {
                $css = 'class="text-danger" style="font-weight:700"';
            }
            $data = (new DateTime($res["data_scadenza"]))->format("d/m/Y");
        } else {
            $data = "";
            $css = "";
        }
        $fatture[] = [
            'id' => $res["id"],
            'url' => explode("/", $res["url_fattura"])[3],
            'pagata' => $res["pagata"] == 0 ? "No" : "Si",
            #'dataScadenza' => (new DateTime($res["data_scadenza"]))->format("d/m/Y"),
            'costo' => str_replace(".", ",", $res['costo']),
            'nome' => $res["nameC"],
            'dataScadenza' => $data,
            'css' => $css,
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/fatture/fattureRicevute/index.php';
