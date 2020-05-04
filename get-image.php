<?php
require_once 'include/functions.php';

$id = $_GET['id'] ?? 0;

$result = getResult("SELECT * FROM image WHERE id = $id");

if (!$result || !$result->num_rows) {
    header('Location: index.php');
    exit();
}

$image = $result->fetch_object();

header("Content-Type: $image->filetype");
echo $image->filedata;
exit();