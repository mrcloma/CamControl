<?php
$client_secret = 'seu_client_secret';

// Função para decodificar base64Url
function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

// Função para validar o token
function validateToken($jwt, $client_secret) {
    list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode('.', $jwt);

    $header = json_decode(base64UrlDecode($base64UrlHeader), true);
    $payload = json_decode(base64UrlDecode($base64UrlPayload), true);
    $signature = base64UrlDecode($base64UrlSignature);

    // Verifica a assinatura
    $validSignature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $client_secret, true);

    if ($signature !== $validSignature) {
        return false;
    }

    // Verifica se o token expirou
    if ($payload['exp'] < time()) {
        return false;
    }

    return true;
}

// Pegue o cabeçalho Authorization
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

list($jwt) = sscanf($headers['Authorization'], 'Bearer %s');

if (!$jwt || !validateToken($jwt, $client_secret)) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}
?>
