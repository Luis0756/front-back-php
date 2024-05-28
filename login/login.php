<?php
class Login {
    private $servidor;
    private $usuario;
    private $senha;
    private $banco;
    private $porta;
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

    private function getUsuarioByLogin($login) {
        $qry = $this->pdo->prepare("SELECT * FROM usuario WHERE email_login = :login");
        $qry->bindParam(':login', $login);
        $qry->execute();
        return $qry->fetch(PDO::FETCH_ASSOC);
    }

    private function getNewToken($id) {
        $token = md5(uniqid(mt_rand(), true));
        $qry = $this->pdo->prepare("INSERT INTO login_control (idusuario, token, criado, expira) VALUES (:id, :token, NOW(), DATE_ADD(NOW(), INTERVAL 12 HOUR))");
        $qry->bindParam(':id', $id);
        $qry->bindParam(':token', $token);
        $qry->execute();
        return $token;
    }

    public function login() {
        $content = file_get_contents('php://input');
        $json = json_decode($content, true);

        if (isset($json['user']) && isset($json['pass'])) {
            $usuario = $this->getUsuarioByLogin($json['user']);
            if ($usuario && $usuario['senha'] == $json['pass']) {
                $token = $this->getNewToken($usuario['id']);
                if ($token) {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode([
                        'access' => true,
                        'token' => $token,
                        'msg' => 'Login OK'
                    ]);
                } else {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode([
                        'access' => false,
                        'token' => null,
                        'msg' => 'Falha na geração do token'
                    ]);
                }
            } else {
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode([
                    'access' => false,
                    'token' => null,
                    'msg' => 'Usuário ou senha inválido'
                ]);
            }
        } else {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'access' => false,
                'token' => null,
                'msg' => 'Usuário ou senha inválido'
            ]);
        }
    }
}

$autent = new Login();
$autent->login();
?>