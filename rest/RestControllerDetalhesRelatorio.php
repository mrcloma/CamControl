<?php
require_once("../model/relatorio.php");
include 'ValidaToken.php';

class RestControllerDetalhesRelatorio {
    private $lista;
    private $id;

    public function __construct($id) {
        $this->lista = new Relatorio();
        $this->id = $id;
    }

    public function getDetalheRelatorioCameraJSON() {
        // Chama o método existente para obter os dados
        $dados = $this->lista->getUltimosEventoDetalhes($this->id);

        // Converte os dados para JSON
        $json = json_encode($dados);

        return $json;
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : 1;

// Uso do Controller
$controller = new RestControllerDetalhesRelatorio($id);
$dadosJson = $controller->getDetalheRelatorioCameraJSON();

// Retorna os dados em JSON
echo $dadosJson;
?>