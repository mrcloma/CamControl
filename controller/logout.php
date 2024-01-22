<?php
session_start();

// Destroi a sessão
session_destroy();

// Redireciona para a página de login
header("Location: ../view/login.php");
exit();
?>
