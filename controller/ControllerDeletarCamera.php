<?php
require_once("../model/camera.php");
class deleta {
    private $deleta;

    public function __construct($id){
        $this->deleta = new Camera();
        if($this->deleta->deleteCamera($id)== TRUE){
            echo "<script>alert('Registro deletado com sucesso!');document.location='../view/camera.php'</script>";
        }else{
            echo "<script>alert('Erro ao deletar registro!');history.back()</script>";
        }
    }
}
new deleta($_GET['id']);
?>
