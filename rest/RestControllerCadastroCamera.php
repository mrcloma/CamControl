<?php
require_once("../model/cadastroCamera.php");
include 'ValidaToken.php';

class RestControllerCadastroCamera {
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
        if (!isset($input_data['nome']) || !isset($input_data['cliente_nome']) || !isset($input_data['endereco']) || !isset($input_data['ip']) || !isset($input_data['descricao']) || !isset($input_data['status'])) {
            // Se algum campo estiver faltando, responde com status 400 (Pedido incorreto)
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos. Certifique-se de enviar todos os campos necessários."));
            return;
        }

        // Cria uma instância do objeto Cadastro
        $cadastro = new Cadastro();

        // Define os valores dos campos utilizando os métodos Set
        $cadastro->setNome($input_data['nome']);
        $cadastro->setClienteNome($input_data['cliente_nome']);
        $cadastro->setEndereco($input_data['endereco']);
        $cadastro->setIP($input_data['ip']);
        $cadastro->setDescricao($input_data['descricao']);
        $cadastro->setStatus($input_data['status']);

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
$cadastroAPI = new RestControllerCadastroCamera();
$cadastroAPI->inserirDados();
?>
