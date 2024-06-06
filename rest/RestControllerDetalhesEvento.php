<?php
require_once("../model/evento.php");
include 'ValidaToken.php';

class RestControllerDetalhesEvento {
    private $lista;
    private $id;

    public function __construct($id) {
        $this->lista = new Evento();
        $this->id = $id;
    }

    public function getDetalheEventosCameraJSON() {
        // Chama o método existente para obter os dados
        $dados = $this->lista->getEventoBD($this->id);

        // Converte os dados para JSON
        $json = json_encode($dados);

        return $json;
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : 1;

// Uso do Controller
$controller = new RestControllerDetalhesEvento($id);
$dadosJson = $controller->getDetalheEventosCameraJSON();

// Retorna os dados em JSON
echo $dadosJson;
?>