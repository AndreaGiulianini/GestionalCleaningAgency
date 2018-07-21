<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$product = $_REQUEST["prodotto"];
$nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : "";
$pAcq = !empty($_REQUEST["pAcq"]) ? str_replace(',', '.', $_REQUEST["pAcq"]) : NULL;
$pVen = !empty($_REQUEST["pVen"]) ? str_replace(',', '.', $_REQUEST["pVen"]) : NULL;
$categoria = isset($_REQUEST["categoria"]) ? $_REQUEST["categoria"] : "";
$magazzino = $_REQUEST["magazzino"];
$count = $_REQUEST["count"];

$insertAna = "INSERT INTO anagrafica(nome, prezzo_vendita, prezzo_acquisto, id_categoria)
              VALUES (:nome,:prezzo_vendita,:prezzo_acquisto,:id_categoria)";

$insertInv = "INSERT INTO inventario(quantita, id_magazzino, id_prodotto) 
              VALUES (:count,:id_magazzino,:id_prodotto)";

$insertInv1 = "INSERT INTO inventario(quantita, id_magazzino, id_prodotto) 
              VALUES (:quantita,:id_magazzino,:id_prodotto)";

$selectProduct = "SELECT id,quantita  FROM inventario WHERE id_prodotto = :id AND id_magazzino = :idM";

$update = "UPDATE inventario SET quantita = :val WHERE id=:id";

try {
    $db->beginTransaction();
    //Controllo se il prodotto è nuovo
    if ($product == "NP") {
        $stmt = $db->prepare($insertAna);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":prezzo_vendita", $pVen);
        $stmt->bindParam(":prezzo_acquisto", $pAcq);
        $stmt->bindParam(":id_categoria", $categoria);
        $stmt->execute();

        $lastId = $db->lastInsertId();
        $stmt = $db->prepare($insertInv);
        $stmt->bindParam(":count", $count);
        $stmt->bindParam(":id_magazzino", $magazzino);
        $stmt->bindParam(":id_prodotto", $lastId);
        $stmt->execute();
    } else {//Se il prodotto non è nuovo
        $idPI = NULL;
        $quant = 0;
        $stmt = $db->prepare($selectProduct);
        $stmt->bindParam(":id", $product);
        $stmt->bindParam(":idM", $magazzino);
        $stmt->execute();
        if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $idPI = $res["id"];
            $quant = $res["quantita"];
        }
        if ($idPI == NULL) {//Se il prodotto non è presente in quel magazzino
            $stmt = $db->prepare($insertInv1);
            $stmt->bindParam(":quantita", $count);
            $stmt->bindParam(":id_magazzino", $magazzino);
            $stmt->bindParam(":id_prodotto", $product);
            $stmt->execute();
        } else {//Se il prodotto è già presente nel magazzino
            $quant += $count;
            $stmt = $db->prepare($update);
            $stmt->bindParam(":id", $idPI);
            $stmt->bindParam(":val", $quant);
            $stmt->execute();
        }

    }
    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}