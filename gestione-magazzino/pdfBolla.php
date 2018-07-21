<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

use setasign\Fpdi;

$idSped = $_REQUEST["idSped"];
$prezzo = $_REQUEST["prezzo"];
$type = $_REQUEST["type"];

$numBolla = "";
$data = "";
$idSor = "";
$idDest = "";
$sor = [];
$dest = [];
$prod = [];
$causale = [];

$querySped = "SELECT data, id_provenienza, id_destinazione, num_bolla FROM spedizioni WHERE id=:idSped";

$queryProdSped = "SELECT ps.quantita, a.nome, a.prezzo_vendita, a.prezzo_acquisto
                FROM prodotti_in_spedizione AS ps INNER JOIN anagrafica AS a ON ps.id_anagrafica = a.id
                WHERE id_spedizione=:idSped";

$queryMag = "SELECT id,nome,descrizione,indirizzo
           FROM magazzini WHERE id=:id";

$queryCant = "SELECT nome, indirizzo FROM cantieri WHERE id = :idM";

$queryCausale = "SELECT c.causale
                FROM (causali AS c INNER JOIN causali_spedizioni AS cs ON c.id = cs.id_causale)
                WHERE cs.id_spedizione = :idS";

try {
    //Dati spedizione
    $stmt = $db->prepare($querySped);
    $stmt->bindParam(":idSped", $idSped);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data = $res["data"];
        $numBolla = $res["num_bolla"];
        $idSor = $res["id_provenienza"];
        $idDest = $res["id_destinazione"];
    }
    //Prodotti in spedizione
    $stmt = $db->prepare($queryProdSped);
    $stmt->bindParam(":idSped", $idSped);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $prod[] = [
            "nome" => $res["nome"],
            "quantita" => $res["quantita"],
            "pvendita" => $res["prezzo_vendita"],
            "pacquisto" => $res["prezzo_acquisto"],
        ];
    }
    //Sorgente
    $stmt = $db->prepare($queryMag);
    $stmt->bindParam(":id", $idSor);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sor = [
            "id" => $res["id"],
            "nome" => $res["nome"],
            "descrizione" => $res["descrizione"],
            "indirizzo" => $res["indirizzo"],
        ];
    }
    //Destinazione
    $stmt = $db->prepare($queryMag);
    $stmt->bindParam(":id", $idDest);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dest = [
            "id" => $res["id"],
            "nome" => $res["nome"],
            "descrizione" => $res["descrizione"],
            "indirizzo" => $res["indirizzo"],
        ];
    }

    //Seleziono Causali
    $stmt = $db->prepare($queryCausale);
    $stmt->bindParam(":idS", $idSped);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $causale[] = [
            "causale" => $res["causale"],
        ];
    }

    $logo = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/loghi/db.png";
    $style = array('R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(36, 36, 36)));
    $pdf = new Fpdi\Fpdi();

    //Disegni
    $pdf->AddPage();
    $pdf->setSourceFile($_SERVER['DOCUMENT_ROOT'] . '/assets/img/BollaNew.pdf');
    $tplidx = $pdf->importPage(1);
    $pdf->useTemplate($tplidx, 0, 0, 210, 297);
    $pdf->Rect(10, 4, 95, 40, 'DF', $style, array(36, 36, 36));
    $pdf->Image($logo, 35, 4, 40, 40, 'PNG', '', '', false, 300, '', false, false, 0, '', false, false);

    //Dettagli Bolla
    $pdf->SetFont('arial', 'B', 9, '', false);
    $pdf->SetXY(12, 53);
    $pdf->Write(0, "Documento di Trasporto");
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(12, 63);
    $pdf->Write(0, "N.");
    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->SetXY(22, 63);
    $pdf->Write(0, strtoupper($numBolla));
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(52, 63);
    $pdf->Write(0, "del:");
    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->SetXY(64, 63);
    $pdf->Write(0, strtoupper($data));

    //Parte Superiore Destra
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(120, 9);
    $pdf->Write(0, "Deposito");
    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->SetXY(180, 9);
    $pdf->Write(0, "Cod." . $sor["id"]);
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(120, 17);
    $pdf->Write(0, strtoupper($sor["nome"]));
    $pdf->SetFont('arial', '', 9, '', true);
    $expSor = explode(",", $sor["indirizzo"]);
    $pdf->SetXY(120, 24);
    $pdf->Write(0, strtoupper($expSor[0]));
    /* $pdf->SetXY(120, 28);
    $pdf->Write(0, strtoupper($expSor[1])); */

    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(120, 43);
    $pdf->Write(0, "Destinazione");
    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->SetXY(180, 43);
    $pdf->Write(0, "Cod." . $dest["id"]);
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(120, 50);
    $pdf->Write(0, strtoupper($dest["nome"]));
    $pdf->SetFont('arial', '', 9, '', true);
    $expDest = explode(",", $dest["indirizzo"]);
    $pdf->SetXY(120, 57);
    $pdf->Write(0, strtoupper($expDest[0]));
    /* $pdf->SetXY(120, 61);
    $pdf->Write(0, strtoupper($expDest[1])); */

    //Causali
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(12, 83);
    $pdf->Write(0, "Causale del Trasporto: ");
    $pdf->SetFont('arial', '', 9, '', true);
    $y = 90;
    foreach ($causale as $value) {
        $pdf->SetXY(12, $y);
        $pdf->Write(0, strtoupper($value["causale"]));
        $y += 5;
    }

    //Merce con Prezzi
    $pdf->SetFont('arial', 'B', 9, '', true);
    $pdf->SetXY(12, 113);
    $pdf->Write(0, $type == "ven" ? "Merce (Prezzi di Vendita)" : "Merce (Prezzi d'Acquisto)");
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
    foreach ($prod as $p) {
        if ($y > 250) {
            $pdf->AddPage();
            $x = 20;
            $y = 120;
        }
        $pdf->SetXY($x, $y);
        $pdf->Write(0, strtoupper($p["nome"]));
        $pdf->SetXY($x + 88, $y);
        $pdf->Write(0, $p["quantita"]);
        if ($prezzo == "con" && $type == "ven") {
            $pdf->SetXY($x + 118, $y);
            $pdf->Write(0, number_format($p["pvendita"], 2, ',', '') . chr(128));
            $pdf->SetXY($x + 155, $y);
            $pdf->Write(0, number_format($p["quantita"] * $p["pvendita"], 2, ',', '') . chr(128));
            $totaleP += $p["quantita"] * $p["pvendita"];
        }
        if ($prezzo == "con" && $type == "acq") {
            $pdf->SetXY($x + 118, $y);
            $pdf->Write(0, number_format($p["pacquisto"], 2, ',', '') . chr(128));
            $pdf->SetXY($x + 155, $y);
            $pdf->Write(0, number_format($p["quantita"] * $p["pacquisto"], 2, ',', '') . chr(128));
            $totaleP += $p["quantita"] * $p["pacquisto"];
        }
        //$pdf->Line(10, $y-2, 195, $y-2, $style);
        $y = $y + 10;
    }
    //$pdf->Line(10, $y-2, 195, $y-2, $style);
    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->SetXY($x + 140, 276);
    $pdf->Write(0, number_format($totaleP, 2, ',', '') . chr(128));

    $pdf->Output('Bolla' . $numBolla . '.pdf', 'I');
} catch (PDOException $e) {
    echo $e->getMessage();
}
