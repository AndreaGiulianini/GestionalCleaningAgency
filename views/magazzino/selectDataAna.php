<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);

$id = $_REQUEST["id"];
$data = [];
$query = "SELECT a.prezzo_vendita AS pv, a.prezzo_acquisto AS pa, a.nome AS nome, c.nome AS cnome 
          FROM (anagrafica AS a INNER JOIN categoria AS c ON a.id_categoria = c.id)
          WHERE a.id=:id";

try {
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'nome' => $res["nome"],
            'prezzo_vendita' => $res["pv"],
            'prezzo_acquisto' => $res["pa"],
            'cnome' => $res["cnome"],
        ];
    }
    echo json_encode($data);
} catch (PDOException $e) {
    echo $e->getMessage();
}