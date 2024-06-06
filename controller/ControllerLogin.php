<?php
session_start();

require_once("../model/usuario.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $usuario = new Usuario();

    if ($usuario->validarCredenciais($username, $password)) {
        // Autenticação bem-sucedida, redirecione para a página desejada
        $_SESSION['username'] = $username;
        header("Location: ../view/status.php");
        exit();
    } else {
        echo "<script>alert('Usuário ou senha incorretos.');history.back()</script>";
    }
}
?>

