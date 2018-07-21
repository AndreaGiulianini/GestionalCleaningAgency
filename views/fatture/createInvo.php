<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$numInvo = $_REQUEST["numInvo"];
$nameAddInvo = empty($_REQUEST["nameAddInvo"]) ? null : $_REQUEST["nameAddInvo"];
$client = empty($_REQUEST["cli"]) ? null : $_REQUEST["cli"];
$extern = empty($_REQUEST["extern"]) ? null : $_REQUEST["extern"];
if ($client == null && $extern == null) {
    echo "KO";
    die();
}

$cliName = empty($_REQUEST["name"]) ? null : $_REQUEST["name"];
$ragSoc = empty($_REQUEST["ragSoc"]) ? null : $_REQUEST["ragSoc"];
$via = empty($_REQUEST["via"]) ? null : $_REQUEST["via"];
$city = empty($_REQUEST["city"]) ? null : $_REQUEST["city"];
$pv = empty($_REQUEST["pv"]) ? null : $_REQUEST["pv"];
$cap = empty($_REQUEST["cap"]) ? null : $_REQUEST["cap"];
$pIva = empty($_REQUEST["pIva"]) ? null : $_REQUEST["pIva"];
$codFisc = empty($_REQUEST["codFisc"]) ? null : $_REQUEST["codFisc"];
$services = $_REQUEST["services"];
$spedition = empty($_REQUEST["idSped"]) ? null : $_REQUEST["idSped"];

for ($i = 0; $i < count($services); $i++) {
    $services[$i]["cost"] = str_replace(",", ".", $services[$i]["cost"]);
}

$tot = 0;
foreach ($services as $key => $value) {
    $tot += $value["cost"] * $value["quant"];
}

$insertExternClients = "INSERT INTO clienti_esterni(nome, rag_soc, via, citta, provincia, cap, p_iva, cod_fisc) 
                      VALUES (:nome,:rag_soc,:via,:citta,:provincia,:cap,:p_iva,:cod_fisc)";

$insertFatt = "INSERT INTO fatture(numero, aggiunta_numero, totale, id_cliente, id_cliente_esterno) 
                   VALUES (:num,:add,:tot,:id_cliente,:id_cliente_esterno)";

$insertService = "INSERT INTO servizi_fattura(iva, descrizione, prezzo_unitario,quantita,data,id_fattura,id_dipendente) 
                VALUES (:iva,:desc,:cost,:quant,:data,:id_fatt,:id_dip)";

$insertSped = "INSERT INTO fatture_spedizioni(fattura_id,spedizone_id) 
                 VALUES (:id_fatt,:id_sped)";

$checkDateServices = "SELECT id FROM servizi_fattura WHERE id_dipendente = :id_dip AND data = :data";

$updateSped = "UPDATE spedizioni 
            SET fatturata=1 
            WHERE id=:id";
try {
    $db->beginTransaction();
    $lastIdFatt = null;
    $lastIdClient = null;
    $null = null;
    if ($extern == "si") {
        //Inserimento nuovo Cliente
        $stmt = $db->prepare($insertExternClients);
        $stmt->bindParam(":nome", $cliName);
        $stmt->bindParam(":rag_soc", $ragSoc);
        $stmt->bindParam(":via", $via);
        $stmt->bindParam(":citta", $city);
        $stmt->bindParam(":provincia", $pv);
        $stmt->bindParam(":cap", $cap);
        $stmt->bindParam(":p_iva", $pIva);
        $stmt->bindParam(":cod_fisc", $codFisc);
        $stmt->execute();
        $lastIdClient = $db->lastInsertId();

        //Inserimento nuova fattura con cliente esterno
        $stmt = $db->prepare($insertFatt);
        $stmt->bindParam(":num", $numInvo);
        $stmt->bindParam(":add", $nameAddInvo);
        $stmt->bindParam(":tot", $tot);
        $stmt->bindParam(":id_cliente", $null);
        $stmt->bindParam(":id_cliente_esterno", $lastIdClient);
        $stmt->execute();
        $lastIdFatt = $db->lastInsertId();
    } else {
        //Inserimento nuova fattura con cliente interno
        $stmt = $db->prepare($insertFatt);
        $stmt->bindParam(":num", $numInvo);
        $stmt->bindParam(":add", $nameAddInvo);
        $stmt->bindParam(":tot", $tot);
        $stmt->bindParam(":id_cliente", $client);
        $stmt->bindParam(":id_cliente_esterno", $null);
        $stmt->execute();
        $lastIdFatt = $db->lastInsertId();
    }

    //Inserimento servizi
    foreach ($services as $value) {
        //Controllo se in quella data il dipendente non ha altri servizi in lavorazione
        $stmt = $db->prepare($checkDateServices);
        $stmt->bindParam(":id_dip", $value["emplo"]);
        $stmt->bindParam(":data", $value["date"]);
        $stmt->execute();
        if (!($res = $stmt->fetch(PDO::FETCH_ASSOC))) {
            $iva = empty($value["iva"]) ? 0 : 1;
            $stmt = $db->prepare($insertService);
            $stmt->bindParam(":iva", $iva);
            $stmt->bindParam(":desc", $value["name"]);
            $stmt->bindParam(":cost", $value["cost"]);
            $stmt->bindParam(":quant", $value["quant"]);
            $stmt->bindParam(":data", $value["date"]);
            $stmt->bindParam(":id_fatt", $lastIdFatt);
            $stmt->bindParam(":id_dip", $value["emplo"]);

            $stmt->execute();
        } else {
            echo "Dipendente con codice " . $value["emplo"] . " già occupato";
            die();
        }
    }

    //Inserimento spedizioni e relativo update collegate alla fattura
    foreach ($spedition as $value) {
        $stmt = $db->prepare($insertSped);
        $stmt->bindParam(":id_sped", $value);
        $stmt->bindParam(":id_fatt", $lastIdFatt);
        $stmt->execute();

        $stmt = $db->prepare($updateSped);
        $stmt->bindParam(":id", $value);
        $stmt->execute();
    }

    $db->commit();
    echo "OK";
} catch (PDOExeptcion $e) {
    $db->rollBack();
    echo "Controllare che i dati che stai inserendo siano corretti";
}

?>
