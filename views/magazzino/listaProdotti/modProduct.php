<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$nome = $_REQUEST["nome"];
$pAcq = str_replace(",", ".", $_REQUEST["pAcq"]);
$pVen = str_replace(",", ".", $_REQUEST["pVen"]);
$id = $_REQUEST["id"];
$idCat = $_REQUEST["idCat"];

$insertProd = 'INSERT INTO anagrafica(nome,prezzo_vendita, prezzo_acquisto, id_categoria) 
              VALUES(:nome,:pAcq,:pVen,:idCat)';

$updateProd = "UPDATE anagrafica
              SET old=1
              WHERE id=:id";

$updateInv = "UPDATE inventario
                SET id_prodotto=:nId
                WHERE id_prodotto=:id";


try {
    $db->beginTransaction();

    $stmt = $db->prepare($updateProd);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $stmt = $db->prepare($insertProd);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":pAcq", $pAcq);
    $stmt->bindParam(":pVen", $pVen);
    $stmt->bindParam(":idCat", $idCat);
    $stmt->execute();

    $nId = $db->lastInsertId();
    $stmt = $db->prepare($updateInv);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":nId", $nId);
    $stmt->execute();

    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
