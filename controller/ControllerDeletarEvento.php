<?php
require_once("../model/evento.php");
class deleta {
    private $deleta;

    public function __construct($id){
        $this->deleta = new Evento();
        if($this->deleta->deleteEventoBD($id)== TRUE){
            echo "<script>alert('Registro deletado com sucesso!');document.location='../view/registros.php'</script>";
        }else{
            echo "<script>alert('Erro ao deletar registro!');history.back()</script>";
        }
    }
}
new deleta($_GET['id']);
?>
