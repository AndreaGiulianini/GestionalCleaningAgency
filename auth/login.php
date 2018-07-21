<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';

$usr = $_REQUEST['usr'];
$pwdUsr = $_REQUEST['pwd'];

$query = "SELECT id, ruolo, password, foto
          FROM utenti
          WHERE username = :usr";

$stmt = $db->prepare($query);
$stmt->bindParam(":usr", $usr);
$stmt->execute();
if ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $res["id"];
    $role = $res["ruolo"];
    $pwdDB = $res["password"];
    $tmp_foto = $res["foto"];
}

$user = ["id" => $id, "username" => $usr, "role" => $role, "pic" => $tmp_foto];

if (password_verify($pwdUsr, $pwdDB)) {
    $_SESSION['auth'] = 1;
    $_SESSION['user'] = $user;
    unset($_SESSION['err']);
    if (isset($_SESSION['prec_url'])) {
        echo $_SESSION['prec_url'];
        unset($_SESSION['prec_url']);
    } else {
        echo "/";
    }
    $now = (new DateTime)->format("Y-m-d H:i:s");
    $query = "UPDATE utenti SET data_login = :dataLogin WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":dataLogin", $now);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}
