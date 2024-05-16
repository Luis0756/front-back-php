<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $headers = getallheaders();
       
        if (isset($headers['app-token'])) {
            $appToken = $headers['app-token'];
            if ($appToken === "e73c6a96ffelac3156d30dc51aaa545") {
        
                $json = [];

                if (isset($_POST['user']) && isset($_POST['pass'])) {
                    $json = $_POST;
                } else {
                    $content = file_get_contents('php://input');
                    $json = json_decode($content, true);
                }

                if (isset($json['user']) && isset($json['pass'])) {
                    $usuario = $this->UsuarioModel->getUsuarioByLogin($json['user']);

        
                    if (isset($usuario['senha']) && password_verify($json['pass'], $usuario['senha'])) {
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
                            http_response_code(500);
                            header('Content-Type: application/json');
                            $dados = [
                                'access' => false,
                                'msg' => 'Falha ao gerar token'
                            ];
                            echo json_encode($dados);
                        }
                    } else {
                        // Senha inválida
                        http_response_code(401);
                        header('Content-Type: application/json');
                        $dados = [
                            'access' => false,
                            'msg' => 'Credenciais inválidas'
                        ];
                        echo json_encode($dados);
                    }
                } else {
                    http_response_code(400);
                    header('Content-Type: application/json');
                    $dados = [
                        'access' => false,
                        'msg' => 'Parâmetros ausentes'
                    ];
                    echo json_encode($dados);
                }
            } else {
                http_response_code(403);
                header('Content-Type: application/json');
                $dados = [
                    'access' => false,
                    'msg' => 'Token da aplicação inválido'
                ];
                echo json_encode($dados);
            }
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            $dados = [
                'access' => false,
                'msg' => 'Cabeçalho "app-token" ausente'
            ];
            echo json_encode($dados);
        }
    } else {
        http_response_code(405);
        header('Content-Type: application/json');
        $dados = [
            'access' => false,
            'msg' => 'Método não permitido'
        ];
        echo json_encode($dados);
    }
