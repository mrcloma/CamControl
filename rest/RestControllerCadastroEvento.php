<?php
require_once("../model/cadastroEvento.php");
include 'ValidaToken.php';

class RestControllerCadastroEvento {
    public function __construct() {
        // Habilita CORS (Cross-Origin Resource Sharing) para permitir requisições de diferentes origens
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function inserirDados() {
        // Verifica se a requisição é do tipo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Se a requisição não for do tipo POST, responde com status 405 (Método não permitido)
            http_response_code(405);
            echo json_encode(array("message" => "Método não permitido."));
            return;
        }

        // Verifica se os dados foram enviados como JSON
        $input_data = json_decode(file_get_contents('php://input'), true);

        // Verifica se todos os campos necessários foram enviados
        if (!isset($input_data['evento']) || !isset($input_data['camera_id']) || !isset($input_data['it2m']) || !isset($input_data['fman']) || !isset($input_data['vmanut']) || !isset($input_data['data_abertura']) || !isset($input_data['data_fechamento']) || !isset($input_data['responsavel']) || !isset($input_data['problema']) || !isset($input_data['acao'])) {
            // Se algum campo estiver faltando, responde com status 400 (Pedido incorreto)
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos. Certifique-se de enviar todos os campos necessários."));
            return;
        }

        // Cria uma instância do objeto Cadastro
        $cadastro = new Cadastro();

        // Define os valores dos campos utilizando os métodos Set
        $cadastro->setEvento($input_data['evento']);
        $cadastro->setCameraId($input_data['camera_id']);
        $cadastro->setIt2m($input_data['it2m']);
        $cadastro->setFman($input_data['fman']);
        $cadastro->setVmanut($input_data['vmanut']);
        $cadastro->setDataAbertura($input_data['data_abertura']);
        $cadastro->setDataFechamento($input_data['data_fechamento']);
        $cadastro->setResponsavel($input_data['responsavel']);
        $cadastro->setProblema($input_data['problema']);
        $cadastro->setAcao($input_data['acao']);

        // Chama o método incluir para inserir os dados no banco de dados ou onde for necessário
        $resultado = $cadastro->incluir();

        // Verifica se a inclusão foi bem-sucedida
        if ($resultado) {
            // Responde com status 200 (OK) e uma mensagem de sucesso
            http_response_code(200);
            echo json_encode(array("message" => "Dados inseridos com sucesso."));
        } else {
            // Responde com status 500 (Erro interno do servidor) e uma mensagem de erro
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao inserir os dados."));
        }
    }
}

// Cria uma instância da API e chama o método para inserir dados
$cadastroAPI = new RestControllerCadastroEvento();
$cadastroAPI->inserirDados();
?>
