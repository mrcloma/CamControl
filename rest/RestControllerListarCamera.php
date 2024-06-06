<?php
require_once("../model/camera.php");
include 'ValidaToken.php';

class RestControllerListarCamera {
    private $lista;
    private $itensPorPagina = 5;

    public function __construct($lista){
        $this->lista = $lista;
    }

    public function getCameraPaginadoJSON($itensPorPagina, $offset, $termoPesquisa = '', $camposPesquisa = array()) {
        // Chama o método existente para obter os dados
        $dados = $this->lista->getCameraPaginado($itensPorPagina, $offset, $termoPesquisa, $camposPesquisa);

        // Converte os dados para JSON
        $json = json_encode($dados);

        return $json;
    }
}

// Obtém os parâmetros da requisição HTTP GET
$itensPorPagina = isset($_GET['itensPorPagina']) ? $_GET['itensPorPagina'] : 5;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$termoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$camposPesquisa = array('nome', 'cliente_nome', 'endereco', 'descricao');

// Calcula o deslocamento com base na página atual
$offset = ($paginaAtual - 1) * $itensPorPagina;

// Uso do Controller
$lista = new Camera(); // Substitua 'Camera()' pela instância correta do objeto que contém o método getCameraPaginado
$controller = new RestControllerListarCamera($lista);
$dadosJson = $controller->getCameraPaginadoJSON($itensPorPagina, $offset, $termoPesquisa, $camposPesquisa);

// Retorna os dados em JSON
echo $dadosJson;
?>
