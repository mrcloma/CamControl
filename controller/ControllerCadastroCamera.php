<?php
require_once("../model/cadastroCamera.php");

class cadastroController{
    private $cadastro;

    public function __construct(){
        $this->cadastro = new Cadastro();
        $this->incluir();
    }

    private function incluir(){
        $this->cadastro->setNome($_POST['nome']);
        $this->cadastro->setClienteNome($_POST['cliente_nome']);
        $this->cadastro->setEndereco($_POST['endereco']);
        $this->cadastro->setIP($_POST['ip']);
        $this->cadastro->setDescricao($_POST['descricao']);
        $this->cadastro->setStatus($_POST['status']);

        $result = $this->cadastro->incluir();

        if($result >= 1){
            echo "<script>alert('Câmera incluída com sucesso!');document.location='../view/camera.php'</script>";
        } else {
            echo "<script>alert('Erro ao gravar câmera!, verifique se a câmera não está duplicada');history.back()</script>";
        }
    }
}

new cadastroController();
?>

