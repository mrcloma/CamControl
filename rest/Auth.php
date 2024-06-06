<?php

class Auth {
    private $pdo;
    private $clientSecret;

    public function __construct($pdo, $clientSecret) {
        $this->pdo = $pdo;
        $this->clientSecret = $clientSecret;
    }

    private function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function generateJWT($clientId) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $iat = time();
        $exp = $iat + 3600; // Token válido por 1 hora
        $payload = json_encode([
            'iss' => 'seu_dominio.com',
            'iat' => $iat,
            'exp' => $exp,
            'sub' => $clientId
        ]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->clientSecret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function authenticate($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $token = $this->generateJWT($username);
        echo json_encode(['access_token' => $token, 'expires_in' => 3600]);
    }
}
?>
