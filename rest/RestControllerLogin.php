<?php
require_once("../model/usuario.php");
include 'ValidaToken.php';

class AuthController {
    protected $user;

    public function __construct() {
        $this->user = new Usuario();
    }

    public function registerUser($username, $password) {
        return $this->user->setUsuario($username, $password);
    }

    public function loginUser($username, $password) {
        return $this->user->validarCredenciais($username, $password);
    }

    public function getUserInfo($user_id) {
        return $this->user->pesquisaUsuario($user_id);
    }

    public function startSession($user_id) {
        session_start();
        $_SESSION['user_id'] = $user_id;
    }

    public function isAuthenticated() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
}

$authAPI = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_data = json_decode(file_get_contents('php://input'), true);

    if (isset($input_data['register'])) {
        $username = $input_data['username'];
        $password = $input_data['password'];

        $result = $authAPI->registerUser($username, $password);

        if ($result) {
            echo json_encode(array("message" => "Usuário registrado com sucesso."));
        } else {
            echo json_encode(array("message" => "Erro ao registrar o usuário."));
        }
    }

    if (isset($input_data['login'])) {
    $username = $input_data['username'];
    $password = $input_data['password'];

    // Valida as credenciais do usuário
    $userData = $authAPI->loginUser($username, $password);

    if ($userData !== false) {
        echo json_encode(array("message" => "Login bem-sucedido."));
    } else {
        echo json_encode(array("message" => "Credenciais inválidas."));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        $userData = $authAPI->getUserInfo($user_id);

        if ($userData) {
            echo json_encode($userData);
        } else {
            echo json_encode(array("message" => "Usuário não encontrado."));
        }
    } else {
        echo json_encode(array("message" => "ID do usuário não fornecido."));
    }
}
}
?>
