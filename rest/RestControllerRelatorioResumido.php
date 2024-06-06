<?php
require_once("../model/relatorio.php");
include 'ValidaToken.php';

class RestControllerRelatorioResumido {
    private $lista;
    private $itensPorPagina = 5;

    public function __construct($camera_id) {
        $this->lista = new Relatorio();
    }

    public function getUltimosEventosCameraPaginadoJSON($itensPorPagina, $offset, $termoPesquisa = '', $camposPesquisa = array()) {
        // Chama o método existente para obter os dados
        //$dados = $this->lista->getEventoPaginado($this->camera_id, $this->itensPorPagina, $offset);
		$dados = $this->lista->getUltimosEventosCameraPaginado($itensPorPagina, $offset, $termoPesquisa, $camposPesquisa);

        // Converte os dados para JSON
        $json = json_encode($dados);

        return $json;
    }
}

// Obtém os parâmetros da requisição HTTP GET
$itensPorPagina = isset($_GET['itensPorPagina']) ? $_GET['itensPorPagina'] : 5;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$camposPesquisa = array('c.status', 'c.nome', 'c.endereco', 'r.it2m', 'r.fman', 'r.vmanut');
$termoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
// Calcula o deslocamento com base na página atual
$offset = ($paginaAtual - 1) * $itensPorPagina;

// Uso do Controller
$lista = new Relatorio(); // Substitua 'Camera()' pela instância correta do objeto que contém o método getCameraPaginado
$controller = new RestControllerRelatorioResumido($lista);
$dadosJson = $controller->getUltimosEventosCameraPaginadoJSON($itensPorPagina, $offset, $termoPesquisa, $camposPesquisa);

// Retorna os dados em JSON
echo $dadosJson;
?>