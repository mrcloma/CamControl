<?php
require_once("../model/evento.php");
include 'ValidaToken.php';

class RestControllerListarEvento {
    private $lista;
	private $camera_id;
    private $itensPorPagina = 5;

    public function __construct($camera_id) {
        $this->lista = new Evento();
        $this->camera_id = $camera_id;
    }

    public function getEventoPaginadoJSON($camera_id, $itensPorPagina, $offset) {
        // Chama o método existente para obter os dados
        //$dados = $this->lista->getEventoPaginado($this->camera_id, $this->itensPorPagina, $offset);
		$dados = $this->lista->getEventoPaginado($camera_id, $itensPorPagina, $offset);

        // Converte os dados para JSON
        $json = json_encode($dados);

        return $json;
    }
}

// Obtém os parâmetros da requisição HTTP GET
$itensPorPagina = isset($_GET['itensPorPagina']) ? $_GET['itensPorPagina'] : 5;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$camera_id = isset($_GET['camera_id']) ? $_GET['camera_id'] : 1;

// Calcula o deslocamento com base na página atual
$offset = ($paginaAtual - 1) * $itensPorPagina;

// Uso do Controller
$lista = new Evento(); // Substitua 'Camera()' pela instância correta do objeto que contém o método getCameraPaginado
$controller = new RestControllerListarEvento($lista);
$dadosJson = $controller->getEventoPaginadoJSON($camera_id, $itensPorPagina, $offset);

// Retorna os dados em JSON
echo $dadosJson;
?>