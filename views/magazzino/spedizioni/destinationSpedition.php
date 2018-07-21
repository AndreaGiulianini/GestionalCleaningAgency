<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$idSped = "";
$inv = [];
$causale = [];
$quant = [];
$dataScadenza = DateTime::createFromFormat('d/m/Y', $_REQUEST["dataScadenza"]);
$stringData = $dataScadenza->format("Y-m-d");
$idSource = $_REQUEST["source"];
$idDest = $_REQUEST["destination"];
$today = (new DateTime())->format("Y-m-d");
for ($i = 0; $i < $_REQUEST["countCau"]; $i++) {
    $causale[] = [
        "id" => $_REQUEST["causale" . $i],
        "causale" => "",
    ];
}
for ($i = 0; $i < $_REQUEST["count"]; $i++) {
    $inv[] = [
        "id" => $_REQUEST["prod" . $i],
        "quant" => "",
        "idM" => "",
        "idP" => "",
    ];
}
for ($i = 0; $i < $_REQUEST["count"]; $i++) {
    $quant[] = $_REQUEST["quant" . $i];
}

$deleteInv = "DELETE FROM `inventario` WHERE id=:id";

$selectInv = "SELECT `id`, `quantita`, `id_magazzino`, `id_prodotto` 
            FROM `inventario` 
            WHERE id = :idInv";

$selectInv2 = "SELECT `id`, `quantita`, `id_magazzino`, `id_prodotto` 
             FROM `inventario` 
             WHERE id_magazzino=:idM AND id_prodotto=:idP";

$updateInv = "UPDATE `inventario` 
            SET `quantita`=:quant 
            WHERE id=:idInv";

$updateInv2 = "UPDATE `inventario` 
            SET `quantita`=:quant 
            WHERE id_magazzino=:idM AND id_prodotto=:idP";

$insertInv = "INSERT INTO `inventario`(`quantita`, `id_magazzino`, `id_prodotto`) 
            VALUES (:quant,:idM,:idP)";

$insertSped = "INSERT INTO `spedizioni`(`data`,`id_provenienza`, `id_destinazione`, `num_bolla`, `data_scadenza`) 
             VALUES (:data, :idS, :idD, :numB, :dataScadenza)";

$insertProdSped = "INSERT INTO `prodotti_in_spedizione`(`quantita`, `id_spedizione`, `id_anagrafica`) 
                 VALUES (:quant,:idSped,:idAna)";

$selectSped = "SELECT num_bolla FROM spedizioni ORDER BY num_bolla DESC";

$selectCausale = "SELECT causale FROM causali WHERE id = :idCausale";

$insertCauSped = "INSERT INTO `causali_spedizioni`(`id_spedizione`, `id_causale`) 
                  VALUES (:idSped,:idCausale)";


try {
    $db->beginTransaction();
    //Riempio vettore con i dati
    for ($i = 0; $i < $_REQUEST["count"]; $i++) {
        $stmt = $db->prepare($selectInv);
        $stmt->bindParam(":idInv", $inv[$i]["id"]);
        $stmt->execute();
        if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($quant[$i] > $res["quantita"]) {
                echo "Quantità maggiore del prodotto";
                die();
            }
            $inv[$i]["quant"] = $res["quantita"] - $quant[$i];
            $inv[$i]["idM"] = $res["id_magazzino"];
            $inv[$i]["idP"] = $res["id_prodotto"];
        }
    }

    //Update inventario magazzino di partenza con i nuovi dati o delete se il prodotto va a 0
    for ($i = 0; $i < $_REQUEST["count"]; $i++) {
        if ($inv[$i]["quant"] != 0) {
            $stmt = $db->prepare($updateInv);
            $stmt->bindParam(":idInv", $inv[$i]["id"]);
            $stmt->bindParam(":quant", $inv[$i]["quant"]);
            $stmt->execute();
        } else {
            $stmt = $db->prepare($deleteInv);
            $stmt->bindParam(":id", $inv[$i]["id"]);
            $stmt->execute();
        }
    }

    //Inserimento o Update del nuovo prodotto nel nuovo magazzino
    for ($i = 0; $i < $_REQUEST["count"]; $i++) {
        $stmt = $db->prepare($selectInv2);
        $stmt->bindParam(":idM", $idDest);
        $stmt->bindParam(":idP", $inv[$i]["idP"]);
        $stmt->execute();
        $tmpQua = null;
        if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tmpQua = $res["quantita"] + $quant[$i];
        }

        //Update
        if ($tmpQua) {
            $stmt = $db->prepare($updateInv2);
            $stmt->bindParam(":idM", $idDest);
            $stmt->bindParam(":idP", $inv[$i]["idP"]);
            $stmt->bindParam(":quant", $tmpQua);
            $stmt->execute();
        } else {//Inserimento
            $stmt = $db->prepare($insertInv);
            $stmt->bindParam(":idM", $idDest);
            $stmt->bindParam(":idP", $inv[$i]["idP"]);
            $stmt->bindParam(":quant", $quant[$i]);
            $stmt->execute();
        }
    }

    //Prendo ultimo numero bolla
    $numBolla = 1;
    $stmt = $db->prepare($selectSped);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $numBolla = $res["num_bolla"] + 1;
    }

    //Inserimento spedizione
    $stmt = $db->prepare($insertSped);
    $stmt->bindParam(":data", $today);
    $stmt->bindParam(":idS", $idSource);
    $stmt->bindParam(":idD", $idDest);
    $stmt->bindParam(":numB", $numBolla);
    $stmt->bindParam(":dataScadenza", $stringData);
    $stmt->execute();

    //Inserimento prodotti in spedizioni
    $idSped = $db->lastInsertId();
    for ($i = 0; $i < $_REQUEST["count"]; $i++) {
        $stmt = $db->prepare($insertProdSped);
        $stmt->bindParam(":quant", $quant[$i]);
        $stmt->bindParam(":idAna", $inv[$i]["idP"]);
        $stmt->bindParam(":idSped", $idSped);
        $stmt->execute();
    }

    //Seelezione delle Causali
    for ($i = 0; $i < $_REQUEST["countCau"]; $i++) {
        $stmt = $db->prepare($selectCausale);
        $stmt->bindParam(":idCausale", $causale[$i]["id"]);
        $stmt->execute();
        if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $causale[$i]["causale"] = $res["causale"];
        }
    }

    //Inserimento Causale_Spedizione
    for ($i = 0; $i < $_REQUEST["countCau"]; $i++) {
        $stmt = $db->prepare($insertCauSped);
        $stmt->bindParam(":idSped", $idSped);
        $stmt->bindParam(":idCausale", $causale[$i]["id"]);
        $stmt->execute();
    }

    $db->commit();
    echo $idSped;
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
