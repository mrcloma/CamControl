<?php
require_once("../model/cadastroCamera.php");
include 'ValidaToken.php';

class RestControllerAtualizarStatus {
    public function __construct() {
        // Habilita CORS (Cross-Origin Resource Sharing) para permitir requisições de diferentes origens
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: PUT");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function atualizarStatus() {
        // Verifica se a requisição é do tipo PUT
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            // Se a requisição não for do tipo PUT, responde com status 405 (Método não permitido)
            http_response_code(405);
            echo json_encode(array("message" => "Método não permitido."));
            return;
        }

        // Verifica se os dados foram enviados como JSON
        $input_data = json_decode(file_get_contents('php://input'), true);

        // Log para verificar os dados recebidos
        error_log("Received data: " . print_r($input_data, true));
    
        // Verifica se todos os campos necessários foram enviados
        if (!isset($input_data['nome']) || !isset($input_data['cliente_nome']) || !isset($input_data['status']) || !isset($input_data['id'])) {
            // Se algum campo estiver faltando, responde com status 400 (Pedido incorreto)
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos. Certifique-se de enviar todos os campos necessários."));
            return;
        }

        // Cria uma instância do objeto Cadastro
        $cadastro = new Cadastro();

        // Chama o método updateCamera2 para atualizar os dados no banco de dados
        $resultado = $cadastro->updateCamera2(
            $input_data['nome'],
            $input_data['cliente_nome'],
            $input_data['status'],
            $input_data['id']
        );

        // Verifica se a atualização foi bem-sucedida
        if ($resultado) {
            // Responde com status 200 (OK) e uma mensagem de sucesso
            http_response_code(200);
            echo json_encode(array("message" => "Status atualizado com sucesso."));
        } else {
            // Responde com status 500 (Erro interno do servidor) e uma mensagem de erro
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao atualizar o status."));
        }
    }
}

// Cria uma instância da API e chama o método para atualizar o status
$atualizarStatusAPI = new RestControllerAtualizarStatus();
$atualizarStatusAPI->atualizarStatus();
?>
