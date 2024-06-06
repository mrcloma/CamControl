<?php
require_once("../model/camera.php");


class editarCameraController {

    private $editar;
    private $id;
    private $nome;
    private $cliente_nome;
    private $status;

    public function __construct($id){
        $this->id = $id;
        $this->editar = new Camera();
        $this->criarFormularioCamera();
    }

    private function criarFormularioCamera(){
        $row = $this->editar->pesquisaCamera($this->id);
        $this->nome         = $row['nome'];
        $this->cliente_nome = $row['cliente_nome'];
        $this->status       = $row['status'];
    }

    public function editarFormularioCamera2($nome, $cliente_nome, $status){
        if ($this->editar->updateCamera2($nome, $cliente_nome, $status, $this->id) == TRUE){
            echo "<script>alert('Status alterado com sucesso! Cadastre agora o motivo da alteração de Status.');document.location='../view/cadastroregistro.php?id=".$this->getId()."'</script>";
        } else {
            echo "<script>alert('Erro ao alterar status!');history.back()</script>";
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getClienteNome(){
        return $this->cliente_nome;
    }

    public function getStatus(){
        return $this->status;
    }

}

$id = isset($_POST['id']) ? $_POST['id'] : filter_input(INPUT_GET, 'id');
$editar = new editarCameraController($id);

if(isset($_POST['submit'])){
    $editar->editarFormularioCamera2(
        $_POST['nome'],
        $_POST['cliente_nome'],
        $_POST['status']
    );
}

?>

