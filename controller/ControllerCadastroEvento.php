<?php
require_once("../model/cadastroEvento.php");

class cadastroController{
    private $cadastro;

    public function __construct(){
        $this->cadastro = new Cadastro();
        $this->incluir();
    }

    private function incluir(){
        $this->cadastro->setEvento($_POST['evento']);
        $this->cadastro->setCameraId($_POST['camera_id']);
        $this->cadastro->setIt2m($_POST['it2m']);
        $this->cadastro->setFman($_POST['fman']);
        $this->cadastro->setVmanut($_POST['vmanut']);
        $this->cadastro->setDataAbertura($_POST['data_abertura']);
        $this->cadastro->setDataFechamento($_POST['data_fechamento']);
        $this->cadastro->setResponsavel($_POST['responsavel']);
        $this->cadastro->setProblema($_POST['problema']);
        $this->cadastro->setAcao($_POST['acao']);

        $result = $this->cadastro->incluir();

        if($result >= 1){
            echo "<script>alert('Registro incluído com sucesso!');document.location='../view/status.php'</script>";
        } else {
            echo "<script>alert('Erro ao gravar registro!, verifique se a câmera não está duplicada');history.back()</script>";
        }
    }
}

new cadastroController();
?>

