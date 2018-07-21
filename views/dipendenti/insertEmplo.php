<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);
$creator = $_SESSION['user']['id'];
$nome = $_REQUEST["name"];
$cognome = $_REQUEST["surname"];
$codF = $_REQUEST["cod_fisc"];
$user = $_REQUEST["user"];
$pwd = $_REQUEST["pwd"];
$options = ['cost' => 11,];
$hashPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
$mail = $_REQUEST["mail"];
$insertUser = "INSERT INTO utenti(username, password, email, ruolo, data_creazione, admin_creazione)
                VALUES (:user,:pwd,:mail,1,:date,:creator)";
$insertDip = "INSERT INTO dipendenti(nome, cognome, cod_fisc, utente)
              VALUES (:nome,:cognome,:codF, :utente)";
try {
    $db->beginTransaction();
    $dateNow = (new DateTime())->format("Y-m-d H:i:s");
    $stmt = $db->prepare($insertUser);
    $stmt->bindParam(":user", $user);
    $stmt->bindParam(":mail", $mail);
    $stmt->bindParam(":date", $dateNow);
    $stmt->bindParam(":creator", $creator);
    $stmt->bindParam(":pwd", $hashPwd);
    $stmt->execute();
    $lastId = $db->lastInsertId();
    $stmt = $db->prepare($insertDip);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":cognome", $cognome);
    $stmt->bindParam(":codF", $codF);
    $stmt->bindParam(":utente", $lastId);
    $stmt->execute();
    $db->commit();
    echo "OK";
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
?>
