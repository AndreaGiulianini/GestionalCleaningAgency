<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utility/Autoloader.php';
checkAuth(3);
$creator = $_SESSION['user']['id'];
$cliName = $_REQUEST["name"];
$ragSoc = $_REQUEST["ragSoc"];
$via = $_REQUEST["via"];
$city = $_REQUEST["city"];
$pv = $_REQUEST["pv"];
$cap = $_REQUEST["cap"];
$pIva = $_REQUEST["pIva"];
$codFisc = $_REQUEST["codFisc"];
$user = $_REQUEST["user"];
$pwd = $_REQUEST["pwd"];
$options = ['cost' => 11, ];
$hashPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
$mail = $_REQUEST["mail"];
$insertUser = "INSERT INTO utenti(username, password, email, ruolo, data_creazione, admin_creazione)
                VALUES (:user,:pwd,:mail,2,:date,:creator)";
$insertCli = "INSERT INTO clienti(nome, rag_soc, via, citta, provincia, cap, p_iva, cod_fisc,utente)
                      VALUES (:nome,:rag_soc,:via,:citta,:provincia,:cap,:p_iva,:cod_fisc,:utente)";
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
    $stmt = $db->prepare($insertCli);
    $stmt->bindParam(":nome", $cliName);
    $stmt->bindParam(":rag_soc", $ragSoc);
    $stmt->bindParam(":via", $via);
    $stmt->bindParam(":citta", $city);
    $stmt->bindParam(":provincia", $pv);
    $stmt->bindParam(":cap", $cap);
    $stmt->bindParam(":p_iva", $pIva);
    $stmt->bindParam(":cod_fisc", $codFisc);
    $stmt->bindParam(":utente", $lastId);
    $stmt->execute();
    $db->commit();
    echo "OK";
}
catch(PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
