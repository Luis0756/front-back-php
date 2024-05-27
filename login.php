<?php
class Login
{
    private $servidor;
    private $usuario;
    private $senha;
    private $banco;
    private $porta;
    private $pdo;

    public function __construct()
    {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->senha = "";
        $this->banco = "teste";
        $this->porta = 3306;
        $this->pdo = new PDO("mysql:host={$this->servidor};dbname={$this->banco}", $this->usuario, $this->senha);
    }

    private function getUsuarioByLogin($login)
    {
        $qry = $this->pdo->prepare("select * from usuario where email_login = '{$login}'");
        $qry->execute();
        $usuarios = $qry->fetchAll(PDO::FETCH_ASSOC);
        if (count($usuarios) > 0) {
            return $usuarios[0];
        } else {
            return null;
        }
    }

    private function getNewToken($id)
    {
        $token = md5(uniqid(mt_rand(), true));
        $qry = $this->pdo->prepare("insert into login_control (idusuario, token, criado, expira) values (:id, :token, now(), DATE_ADD(now(), INTERVAL 12 HOUR))");
        $qry->bindParam(':id', $id);
        $qry->bindParam(':token', $token);
        $qry->execute();
        return $token;
    }

    public function login()
    {
        if (isset($_POST['user']) && (isset($_POST['pass']))) {
            $json = $_POST;
        } else {
            $content = file_get_contents('php://input');
            $json = json_decode($content, true);
        }

        if (isset($json['user']) && isset($json['pass'])) {
            $usuario = $this->getUsuarioByLogin($json['user']);
            if (isset($usuario['senha'])) {
                if ($usuario['senha'] == $json['pass']) {
                    $token = $this->getNewToken($usuario['id']);
                    if ($token) {
                        http_response_code(200);
                        header('Content-Type: application/json');
                        $dados = [
                            'access' => true,
                            'token' => $token,
                            'msg' => 'Login OK'
                        ];
                        echo json_encode($dados);
                        return $token;
                    } else {
                        http_response_code(200);
                        header('Content-Type: application/json');
                        $dados = [
                            'access' => false,
                            'token' => null,
                            'msg' => 'Falha na geração do token'
                        ];
                        echo json_encode($dados);
                    }
                } else {
                    http_response_code(200);
                    header('Content-Type: application/json');
                    $dados = [
                        'access' => false,
                        'token' => null,
                        'msg' => 'Usuário ou senha inválido'
                    ];
                    echo json_encode($dados);
                }
            } else {
                http_response_code(200);
                header('Content-Type: application/json');
                $dados = [
                    'access' => false,
                    'token' => null,
                    'msg' => 'Usuário ou senha inválido'
                ];
                echo json_encode($dados);
            }
        }
    }
}

$autent = new Login();
$autent->login();
