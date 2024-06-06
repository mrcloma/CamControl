<?php
require_once("../init.php");

class Relatorio{

    protected $mysqli;

    public function __construct(){
        $this->conexao();
    }

    private function conexao(){
        $this->mysqli = new mysqli(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);
    }

    public function getUltimosEventosCameraPaginado($itensPorPagina, $offset, $termoPesquisa = '', $camposPesquisa = array()) {
        $sql = "SELECT c.id AS id_da_camera,
                       c.status AS status_da_camera,
                       c.nome AS nome_da_camera, 
                       c.endereco AS endereco_da_camera, 
                       r.data_abertura AS data_de_abertura_ultimo_evento, 
                       r.it2m AS it2m_ultimo_evento, 
                       r.fman AS fman_ultimo_evento,
                       r.vmanut AS vmanut_ultimo_evento,
                       r.problema AS problema_ultimo_evento,
                       r.acao AS acao_ultimo_evento,
                       r.data_registro AS data_registro_ultimo_evento
                FROM cameras c
                JOIN registros r ON c.id = r.camera_id
                JOIN (
                    SELECT camera_id, MAX(data_abertura) AS ultima_data_abertura
                    FROM registros
                    GROUP BY camera_id
                ) ultimos_eventos ON r.camera_id = ultimos_eventos.camera_id AND r.data_abertura = ultimos_eventos.ultima_data_abertura";

        // Adiciona condição de pesquisa, se um termo de pesquisa foi fornecido
        if (!empty($termoPesquisa) && !empty($camposPesquisa)) {
            $sql .= " WHERE ";
            $condicoes = array();

            foreach ($camposPesquisa as $campo) {
                $lowercaseTermoPesquisa = strtolower($termoPesquisa); // Converta para minúsculas

                if ($campo == 'c.status' && ($lowercaseTermoPesquisa == 'ok' || $lowercaseTermoPesquisa == 'pendente')) {
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

    public function getUltimosEventoDetalhes($id) {
        $sql = "SELECT c.id AS id_da_camera,
                       c.status AS status_da_camera,
                       c.nome AS nome_da_camera, 
                       c.endereco AS endereco_da_camera, 
                       r.data_abertura AS data_de_abertura_ultimo_evento, 
                       r.it2m AS it2m_ultimo_evento, 
                       r.fman AS fman_ultimo_evento,
                       r.vmanut AS vmanut_ultimo_evento,
                       r.problema AS problema_ultimo_evento,
                       r.acao AS acao_ultimo_evento,
                       r.data_registro AS data_registro_ultimo_evento
                FROM cameras c
                JOIN registros r ON c.id = r.camera_id
                JOIN (
                    SELECT camera_id, MAX(data_abertura) AS ultima_data_abertura
                    FROM registros
                    GROUP BY camera_id
                ) ultimos_eventos ON r.camera_id = ultimos_eventos.camera_id AND r.data_abertura = ultimos_eventos.ultima_data_abertura
                WHERE c.id = $id";

        $result = $this->mysqli->query($sql);

        $array = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $array[] = $row;
        }

        return $array;
    }

    public function getTotalPaginas($itensPorPagina, $termoPesquisa = '', $camposPesquisa = array()) {
        $query = "SELECT COUNT(DISTINCT c.id) as total FROM cameras c
                JOIN registros r ON c.id = r.camera_id
                JOIN (
                    SELECT camera_id, MAX(data_abertura) AS ultima_data_abertura
                    FROM registros
                    GROUP BY camera_id
                ) ultimos_eventos ON r.camera_id = ultimos_eventos.camera_id AND r.data_abertura = ultimos_eventos.ultima_data_abertura";

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

    public function getTotalPaginas2($itensPorPagina) {
        $query = "SELECT COUNT(*) as total FROM (
            SELECT c.id
            FROM cameras c
            JOIN registros r ON c.id = r.camera_id
            JOIN (
                SELECT camera_id, MAX(data_abertura) AS ultima_data_abertura
                FROM registros
                GROUP BY camera_id
            ) ultimos_eventos ON r.camera_id = ultimos_eventos.camera_id AND r.data_abertura = ultimos_eventos.ultima_data_abertura
        ) AS subquery";

        $result = $this->mysqli->query($query);
        $totalItens = $result->fetch_assoc()['total'];

        return ceil($totalItens / $itensPorPagina);
    }
}
?>
