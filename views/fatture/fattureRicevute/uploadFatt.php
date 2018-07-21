<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/check.php';
checkAuth(3);

function num($in, $inc)
{
    $tmp = explode(".", $in);
    $ext = $tmp[count($tmp) - 1];
    unset($tmp[count($tmp) - 1]);
    $tmp = implode(".", $tmp);

    if (!$inc) {
        return $tmp . "_001." . $ext;
    }

    $tmp = explode("_", $tmp);
    $num = $tmp[count($tmp) - 1];
    unset($tmp[count($tmp) - 1]);
    $tmp = implode("_", $tmp);

    $num = intval($num);
    $num = str_pad($num + 1, 3, '0', STR_PAD_LEFT);

    return $tmp . "_" . $num . "." . $ext;
}

$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads/fatture';
if (!empty($_FILES)) {
    $name = $_FILES['file']['name'];
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $ds . $storeFolder . $ds;
    $name = num($name, 0);
    while (file_exists($targetPath . $name)) {
        $name = num($name, 1);
    }
    $targetFile = $targetPath . $name;
    move_uploaded_file($tempFile, $targetFile);
    echo $name;
}