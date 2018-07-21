<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/check.php';
checkAuth(1);

if (!isset($_REQUEST['path'])) {
    return;
}

$filePath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['path'];
$fileExt = explode(".", $filePath);
$fileName = $_REQUEST['name'] . "." . $fileExt[count($fileExt) - 1];
$fileMime = $_REQUEST['mime'];
$content = file_get_contents($filePath);

header('Content-Type: ' . $fileMime);
header("Content-length: " . filesize($filePath));
header('Content-Disposition: attachment; filename="' . $fileName . '"');
echo $content;
exit();

