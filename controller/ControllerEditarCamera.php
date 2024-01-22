<?php
require_once("../model/camera.php");


class editarCameraController {

    private $editar;
    private $id;
    private $nome;
    private $cliente_nome;
    private $endereco;
    private $ip;
    private $descricao;
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
        $this->endereco     = $row['endereco'];
        $this->ip           = $row['ip'];
        $this->descricao    = $row['descricao'];
        $this->status       = $row['status'];
    }

    public function editarFormularioCamera($nome, $cliente_nome, $endereco, $ip, $descricao, $status){
        if ($this->editar->updateCamera($nome, $cliente_nome, $endereco, $ip, $descricao, $status, $this->id) == TRUE){
            echo "<script>alert('Registro incluído com sucesso!');document.location='../view/camera.php'</script>";
        } else {
            echo "<script>alert('Erro ao gravar registro!');history.back()</script>";
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

}

$id = isset($_POST['id']) ? $_POST['id'] : filter_input(INPUT_GET, 'id');
$editar = new editarCameraController($id);

if(isset($_POST['submit'])){
    $editar->editarFormularioCamera(
        $_POST['nome'],
        $_POST['cliente_nome'],
        $_POST['endereco'],
        $_POST['ip'],
        $_POST['descricao'],
        $_POST['status']
    );
}

?>

