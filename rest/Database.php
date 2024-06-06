<?php

class Database {
    private $dsn;
    private $username;
    private $password;
    private $pdo;

    public function __construct() {
        $this->dsn = 'mysql:host=' . BD_SERVIDOR . ';dbname=' . BD_BANCO;
        $this->username = BD_USUARIO;
        $this->password = BD_SENHA;
        $this->connect();
    }

    private function connect() {
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
            exit();
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
?>
