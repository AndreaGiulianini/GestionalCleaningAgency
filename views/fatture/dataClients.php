<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';

$id = $_REQUEST["id"];
$clients = [];
$idMag = [];
$sped = [];
$idUtente = 0;
$selClients = "SELECT * FROM clienti WHERE id=:id";
$selMag = "SELECT id FROM magazzini WHERE utente=:id";
$selSped = "SELECT * FROM spedizioni WHERE id_destinazione IN (:ids) AND fatturata = 0";

try {
    $stmt = $db->prepare($selClients);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $clients[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
            'rag_soc' => $res["rag_soc"],
            'via' => $res["via"],
            'citta' => $res["citta"],
            'provincia' => $res["provincia"],
            'cap' => $res["cap"],
            'p_iva' => $res["p_iva"],
            'cod_fisc' => $res["cod_fisc"],
        ];
        $idUtente = $res['utente'];
    }

    $stmt = $db->prepare($selMag);
    $stmt->bindParam(":id", $idUtente);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idMag[] = $res["id"];
    }

    //Secure bind fatto a mano, PDO non supporta nativamente il WHERE IN
    $in = implode(',', array_map('intval', $idMag));
    $stmt = $db->prepare($selSped);
    $stmt->bindParam(":ids", $in);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sped[] = [
            'id' => $res["id"],
            'data' => $res["data"],
            'data_scadenza' => $res["data_scadenza"],
            'num_bolla' => $res["num_bolla"],
        ];
    }
    $data['client'] = $clients;
    $data['sped'] = $sped;

    echo json_encode($data);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>