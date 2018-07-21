<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

use setasign\Fpdi;

$idFatt = $_REQUEST["idFatt"];

$info = [];
$services = [];

$selectInfo = " SELECT f.id, f.numero, f.aggiunta_numero AS addN, f.totale,
                c.nome AS nomeInterno, ce.nome AS nomeEsterno,
                c.via AS viaI, c.citta AS cittaI, c.cap AS capI, c.provincia AS pvI,
                ce.via viaE, ce.citta AS cittaE, ce.cap AS capE, ce.provincia AS pvE

                FROM fatture AS f LEFT JOIN clienti AS c ON f.id_cliente = c.id
                LEFT JOIN clienti_esterni AS ce ON ce.id = f.id_cliente_esterno
                WHERE f.id = :idFatt
                ORDER BY f.numero";

$selectServices = " SELECT iva, descrizione, prezzo_unitario, quantita
                    FROM servizi_fattura
                    WHERE id_fattura=:idFatt";

try {
    $stmt = $db->prepare($selectInfo);
    $stmt->bindParam(":idFatt", $idFatt);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $info[] = [
            'id' => $res["id"],
            'numero' => $res["numero"],
            'add' => $res["addN"],
            'totale' => $res["totale"],
            'nomeInterno' => $res["nomeInterno"],
            'nomeEsterno' => $res["nomeEsterno"],

            'viaI' => $res["viaI"],
            'cittaI' => $res["cittaI"],
            'capI' => $res["capI"],
            'pvI' => $res["pvI"],

            'viaE' => $res["viaE"],
            'cittaE' => $res["cittaE"],
            'capE' => $res["capE"],
            'pvE' => $res["pvE"],
        ];
    }

    $stmt = $db->prepare($selectServices);
    $stmt->bindParam(":idFatt", $idFatt);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $services[] = [
            'iva' => $res["iva"] == 1 ? "si" : "no",
            'descrizione' => $res["descrizione"],
            'quant' => $res["quantita"],
            'pre_un' => $res["prezzo_unitario"],
        ];
    }

    $logo = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/loghi/db.png";
    $style = array('R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 36, 36)));
    $pdf = new Fpdi\Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile($_SERVER['DOCUMENT_ROOT'] . '/assets/img/BollaNew.pdf');
    $tplidx = $pdf->importPage(1);
    $pdf->useTemplate($tplidx, 0, 0, 210, 297);
    $pdf->Rect(10, 4, 95, 40, 'DF', $style, array(36, 36, 36));
    $pdf->Image($logo, 35, 4, 40, 40, 'PNG', '', '', false, 300, '', false, false, 0, '', false, false);
    $pdf->SetFont('arial', 'B', 9, '', false);

    //Numero Fattura
    $pdf->SetXY(12, 53);
    $pdf->Write(0, "Fattura");
    $pdf->SetXY(12, 64);
    $pdf->Write(0, "N. " . $info[0]["numero"] . " " . $info[0]["add"]);

    //Dati cliente
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(120, 43);
    $pdf->Write(0, "Cliente");
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(120, 50);
    $pdf->Write(0, strtoupper($info[0]["nomeInterno"] . $info[0]["nomeEsterno"]));
    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->SetXY(120, 57);
    $pdf->Write(0, strtoupper($info[0]["viaI"] . $info[0]["viaE"]));
    $pdf->SetXY(120, 61);
    $pdf->Write(0, strtoupper($info[0]["capI"] . $info[0]["capE"] . " " . $info[0]["cittaI"] . $info[0]["cittaE"] . " " . $info[0]["pvI"] . $info[0]["pvE"]));

    //Merce con Prezzi
    $pdf->SetXY(12, 113);
    $pdf->Write(0, "Attivita'/Servizio");
    $pdf->SetXY(100, 113);
    $pdf->Write(0, "Qta'");
    $pdf->SetXY(125, 113);
    $pdf->Write(0, "Prz. Unitario");
    $pdf->SetXY(165, 113);
    $pdf->Write(0, "Val Riga");

    $pdf->SetFont('arial', '', 9, '', true);
    $x = 13;
    $y = 125;
    $totaleP = 0;
    $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
    foreach ($services as $s) {
        if ($y > 250) {
            $pdf->AddPage();
            $x = 20;
            $y = 120;
        }
        $pdf->SetXY($x, $y);
        $pdf->Write(0, strtoupper($s["descrizione"]));
        $pdf->SetXY($x + 88, $y);
        $pdf->Write(0, $s["quant"]);
        $pdf->SetXY($x + 118, $y);
        $pdf->Write(0, $s["pre_un"] . chr(128));
        $pdf->SetXY($x + 155, $y);
        $pdf->Write(0, number_format($s["quant"] * $s["pre_un"], 2, ',', '') . chr(128));
        $totaleP += $s["quant"] * $s["pre_un"];
        $y = $y + 10;
    }
    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->SetXY($x + 140, 276);
    $pdf->Write(0, number_format($totaleP, 2, ',', '') . chr(128));
    $pdf->Output('Bolla' . $info[0]["numero"] . '.pdf', 'I');
} catch (PDOException $e) {
    echo $e->getMessage();
}
