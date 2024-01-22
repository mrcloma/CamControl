<?php
require_once("camera.php");

class Cadastro extends Camera {

    private $nome;
    private $cliente_nome;
    private $endereco;
    private $ip;
    private $descricao;
    private $status;

    // Métodos Set
    public function setNome($string){
        $this->nome = $string;
    }

    public function setClienteNome($string){
        $this->cliente_nome = $string;
    }

    public function setEndereco($string){
        $this->endereco = $string;
    }

    public function setIP($string){
        $this->ip = $string;
    }

    public function setDescricao($string){
        $this->descricao = $string;
    }

    public function setStatus($int){
        $this->status = $int;
    }

    // Métodos Get
    public function getNome(){
        return $this->nome;
    }

    public function getClienteNome(){
        return $this->cliente_nome;
    }

    public function getEndereco(){
        return $this->endereco;
    }

    public function getIP(){
        return $this->ip;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function getStatus(){
        return $this->status;
    }

    public function incluir(){
        return $this->setCamera(
            $this->getNome(),
            $this->getClienteNome(),
            $this->getEndereco(),
            $this->getIP(),
            $this->getDescricao(),
            $this->getStatus()
        );
    }
}
?>

