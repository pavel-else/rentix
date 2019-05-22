<?php

error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Europe/Moscow');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');


$postDataJSON = file_get_contents('php://input');
$dataJSON = json_decode($postDataJSON, true);

$data = [
    'response' => 'OK'
];

echo json_encode($data);
