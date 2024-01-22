<?php
require_once("../init.php");

class Camera{

    protected $mysqli;

    public function __construct(){
        $this->conexao();
    }

    private function conexao(){
        $this->mysqli = new mysqli(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);
    }

    public function setCamera($nome, $clienteNome, $endereco, $ip, $descricao, $status){
        $stmt = $this->mysqli->prepare("INSERT INTO cameras (`nome`, `cliente_nome`, `endereco`, `ip`, `descricao`, `status`) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssssi", $nome, $clienteNome, $endereco, $ip, $descricao, $status);

        if ($stmt->execute() == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getCamera(){
        $result = $this->mysqli->query("SELECT * FROM cameras");
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $array[] = $row;
        }
        return $array;
    }

    public function deleteCamera($id){
        if ($this->mysqli->query("DELETE FROM `cameras` WHERE `id` = '".$id."';") == TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function pesquisaCamera($id){
        $result = $this->mysqli->query("SELECT * FROM cameras WHERE id='$id'");
        return $result->fetch_array(MYSQLI_ASSOC);
    }

    public function updateCamera($nome, $clienteNome, $endereco, $ip, $descricao, $status, $id){
        $stmt = $this->mysqli->prepare("UPDATE `cameras` SET `nome` = ?, `cliente_nome` = ?, `endereco` = ?, `ip` = ?, `descricao` = ?, `status` = ? WHERE `id` = ?");
        $stmt->bind_param("sssssii", $nome, $clienteNome, $endereco, $ip, $descricao, $status, $id);

        if ($stmt->execute() == TRUE) {
             return true;
        } else {
            return false;
        }
    }

    public function updateCamera2($nome, $clienteNome, $status, $id){
        $stmt = $this->mysqli->prepare("UPDATE `cameras` SET `nome` = ?, `cliente_nome` = ?, `status` = ? WHERE `id` = ?");
        $stmt->bind_param("ssii", $nome, $clienteNome, $status, $id);

        if ($stmt->execute() == TRUE) {
             return true;
        } else {
            return false;
        }
    }
    
    public function getCameraPaginado($itensPorPagina, $offset, $termoPesquisa = '', $camposPesquisa = array()){
        $sql = "SELECT * FROM cameras";
    
        // Adiciona condição de pesquisa, se um termo de pesquisa foi fornecido
        if (!empty($termoPesquisa) && !empty($camposPesquisa)) {
            $sql .= " WHERE ";
            $condicoes = array();
    
            foreach ($camposPesquisa as $campo) {
                $lowercaseTermoPesquisa = strtolower($termoPesquisa); // Converta para minúsculas
    
                if ($campo == 'status' && ($lowercaseTermoPesquisa == 'ok' || $lowercaseTermoPesquisa == 'pendente')) {
                    // Mapeia "OK" ou "ok" para status 1 e "PENDÊNCIA" ou "pendência" para valores diferentes de 1
                    $condicoes[] = "($campo = " . ($lowercaseTermoPesquisa == 'ok' ? 1 : "2 OR $campo = 3 OR $campo = 4") . ")";
                } else {
                    $condicoes[] = "LOWER($campo) LIKE '%$lowercaseTermoPesquisa%'";
                }
            }
    
            $sql .= implode(" OR ", $condicoes);
        }
    
        $sql .= " LIMIT $itensPorPagina OFFSET $offset";
	
        $result = $this->mysqli->query($sql);
    
        $array = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $array[] = $row;
        }
	
        return $array;
    }


    public function getTotalPaginas($itensPorPagina, $termoPesquisa = '', $camposPesquisa = array()) {
        $query = "SELECT COUNT(*) as total FROM cameras";
        
        // Adiciona condição de pesquisa, se um termo de pesquisa foi fornecido
        if (!empty($termoPesquisa) && !empty($camposPesquisa)) {
            $query .= " WHERE ";
            $condicoes = array();

            foreach ($camposPesquisa as $campo) {
                $condicoes[] = "$campo LIKE '%$termoPesquisa%'";
            }

            $query .= implode(" OR ", $condicoes);
        }

        $result = $this->mysqli->query($query);
        $totalItens = $result->fetch_assoc()['total'];

        return ceil($totalItens / $itensPorPagina);
    }
}
?>

