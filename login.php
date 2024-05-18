<?php
    try { 
        /*
            Para efetuar o ping, utilize:
            curl -X POST -d "ping=ping" http://localhost/dashboard/projeto/front-back-php/login.php
            Ao usar o postman, utilize o 'Content-Type' como 'application/x-www-form-urlencoded' e envie "ping=ping" no corpo.
        */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            if (isset($_POST['ping'])) {
                if ($_POST['ping'] === 'ping') {
                
                    echo "pong";
                } else {
                    http_response_code(400);
                    echo "Erro: valor inválido!";
                }
            } else {
                http_response_code(400);
                echo "Erro: parâmetro 'ping' é obrigatório";
            }
        } 
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
?>