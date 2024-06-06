<?php

require_once("../init.php");

class Usuario {

    protected $mysqli;

    public function __construct(){
        $this->conexao();
    }

    private function conexao(){
        $this->mysqli = new mysqli(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);
    }

    public function setUsuario($username, $password){
        $stmt = $this->mysqli->prepare("INSERT INTO users (`username`, `password`) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute() == TRUE){
            return true;
        } else {
            return false;
        }
    }

    public function getUsuario(){
        $result = $this->mysqli->query("SELECT * FROM users");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)){
            $array[] = $row;
        }
        return $array;
    }

    public function deleteUsuario($id){
        if ($this->mysqli->query("DELETE FROM `users` WHERE `id` = '".$id."';") == TRUE){
            return true;
        } else {
            return false;
        }
    }

    public function pesquisaUsuario($id){
        $result = $this->mysqli->query("SELECT * FROM users WHERE id='$id'");
        return $result->fetch_array(MYSQLI_ASSOC);
    }

    public function updateUsuario($username, $password, $id){
        $stmt = $this->mysqli->prepare("UPDATE `users` SET `username` = ?, `password` = ? WHERE `id` = ?");
        $stmt->bind_param("ssi", $username, $password, $id);
        if ($stmt->execute() == TRUE){
            return true;
        } else {
            return false;
        }
    }

    public function validarCredenciais($username, $password){
        $result = $this->mysqli->prepare("SELECT password FROM users WHERE username = ?");
        $result->bind_param("s", $username);
        $result->execute();
        $result->bind_result($hashedPassword);
        $result->fetch();

        if ($hashedPassword && password_verify($password, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }
}
?>

