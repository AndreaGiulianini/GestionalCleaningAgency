<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(2);
$user = $_SESSION['user'];
$magazzini = [];
$selectMag = "SELECT id, nome, descrizione FROM magazzini WHERE utente=" . $user['id'];

try {
    $stmt = $db->prepare($selectMag);
    $stmt->execute();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $magazzini[] = [
            'id' => $res["id"],
            'nome' => $res["nome"],
            'descrizione' => $res["descrizione"]
        ];
    }
} catch (PDOExeptcion $e) {
    echo $e->getMessage();
}

require $_SERVER['DOCUMENT_ROOT'] . '/views/cliente/creazioneMag/index.php';