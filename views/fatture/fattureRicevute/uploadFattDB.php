<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$dataScadenza = DateTime::createFromFormat('d/m/Y', $_REQUEST["dataScadenza"])->format("Y-m-d");
$idMag = $_REQUEST["cantiere"] == 0 ? null : $_REQUEST["cantiere"];
$costo = str_replace(",", ".", $_REQUEST["costo"]);
$pagata = empty($_REQUEST["pagata"]) ? 0 : 1;
$url = $_REQUEST["url"];

$selClients = "INSERT INTO `spese`(`url_fattura`, `pagata`, `data_scadenza`, `costo`, `id_cantiere`)
               VALUES (:url,:pagata,:dataScadenza,:costo,:idMag)";

try {
    $db->beginTransaction();

    $stmt = $db->prepare($selClients);
    $stmt->bindParam(":url", $url);
    $stmt->bindParam(":pagata", $pagata);
    $stmt->bindParam(":dataScadenza", $dataScadenza);
    $stmt->bindParam(":costo", $costo);
    $stmt->bindParam(":idMag", $idMag);

    $stmt->execute();

    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
?>