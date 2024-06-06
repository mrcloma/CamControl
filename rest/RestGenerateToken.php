<?php
require '../init.php';
require 'Database.php';
require 'Auth.php';

$clientSecret = 'seu_client_secret';

// Pegue os dados do corpo da requisição
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->username) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request']);
    exit();
}

$username = $data->username;
$password = $data->password;

$database = new Database();
$pdo = $database->getPdo();
$auth = new Auth($pdo, $clientSecret);
$auth->authenticate($username, $password);
?>
