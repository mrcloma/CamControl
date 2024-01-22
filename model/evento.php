<?php
require_once("../init.php");

class Evento{

    protected $mysqli;

    public function __construct(){
        $this->conexao();
    }

    private function conexao(){
        $this->mysqli = new mysqli(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);
    }

    public function setEventoBD($evento, $camera_id, $it2m, $data_abertura, $data_fechamento, $responsavel, $descricao){
        $stmt = $this->mysqli->prepare("INSERT INTO registros (`evento`, `camera_id`, `it2m`, `data_abertura`, `data_fechamento`, `responsavel`, `descricao`) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("siissss", $evento, $camera_id, $it2m, $data_abertura, $data_fechamento, $responsavel, $descricao);

        if ($stmt->execute() == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getEventoBD($id){
        $result = $this->mysqli->query("SELECT * FROM `registros` WHERE `id` = '".$id."';");
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $array[] = $row;
        }
        return $array;
    }

    public function deleteEventoBD($id){
        if($this->mysqli->query("DELETE FROM `registros` WHERE `id` = '".$id."';")== TRUE){
            return true;
        }else{
            return false;
        }

    }

    public function getEventoPaginado($camera_id, $itensPorPagina, $offset) {
        $stmt = $this->mysqli->prepare("SELECT * FROM registros WHERE camera_id = ? LIMIT ? OFFSET ?");
        $stmt->bind_param("sii", $camera_id, $itensPorPagina, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $array[] = $row;
        }

        return $array;
    }

    public function getTotalPaginasEvento($camera_id, $itensPorPagina) {
        $stmt = $this->mysqli->prepare("SELECT COUNT(*) AS total FROM registros WHERE camera_id = ?");
        $stmt->bind_param("i", $camera_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $totalItens = $row['total'];
        $totalPaginas = ceil($totalItens / $itensPorPagina);

        return $totalPaginas;
    }
}
?>

