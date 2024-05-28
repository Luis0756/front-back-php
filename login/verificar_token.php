<?php
class Login {
    private $pdo;

    public function __construct() {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->senha = "root";
        $this->banco = "banco_app_php";
        $this->porta = 3306;
        try {
            $this->pdo = new PDO("mysql:host={$this->servidor};dbname={$this->banco}", $this->usuario, $this->senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function validarToken($token) {
        $qry = $this->pdo->prepare("SELECT * FROM login_control WHERE token = :token AND expira > NOW()");
        $qry->bindParam(':token', $token);
        $qry->execute();
        return $qry->fetch(PDO::FETCH_ASSOC);
    }
}

$autent = new Login();
$content = file_get_contents('php://input');
$json = json_decode($content, true);

if (isset($json['token'])) {
    $tokenData = $autent->validarToken($json['token']);
    header('Content-Type: application/json');
    if ($tokenData) {
        http_response_code(200);
        echo json_encode([
            'access' => true,
            'msg' => 'Token válido'
        ]);
    } else {
        http_response_code(200);
        echo json_encode([
            'access' => false,
            'msg' => 'Token inválido ou expirado'
        ]);
    }
} else {
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode([
        'access' => false,
        'msg' => 'Token não fornecido'
    ]);
}
?>