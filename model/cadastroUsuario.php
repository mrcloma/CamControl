<?php
require_once("usuario.php");

class CadastroUsuario extends Usuario {

    private $username;
    private $password;

    // Métodos Set
    public function setUsername($string){
        $this->username = $string;
    }

    public function setPassword($string){
        // Certifique-se de usar uma técnica segura para armazenar senhas, como o uso de funções de hash
        $this->password = $string;
    }

    // Métodos Get
    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function incluir(){
        return $this->setUsuario($this->getUsername(), $this->getPassword());
    }
}
?>
