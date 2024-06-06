<?php
//arquivo temporario para inserir usuarios, caso fosse utilizado em prod deveria haver uma implementacao completa
$dsn = 'mysql:host=localhost;dbname=camcontrol';
$dbUsername = 'camuser';
$dbPassword = 'senha123';

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = 'marcelo';
    $password = password_hash('marcelo', PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->execute([':username' => $username, ':password' => $password]);

    echo "Usuário registrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
