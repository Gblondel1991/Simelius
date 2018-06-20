<?php

require '../init.php';
require LIB_PATH . DS . 'user.php';

// echo 'Hello Ajax World';

$name = $_GET['name'] ?? '';
$data = new stdClass();
$data->hasUser = false;

if (!empty($name)) {
    $data->hasUser = isUserExists($db, $name);
}

header('Content-Type: application/json');
echo json_encode($data);