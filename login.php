<?php

    $host = 'localhost';
    $dbname = 'test_db';
    $username = 'your_username';
    $password = 'your_password';

    try {
        // Create a PDO instance 
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if 'ping' parameter exists in the POST data
            if (isset($_POST['ping'])) {
                // Check if the value of 'ping' parameter is 'ping'
                if ($_POST['ping'] === 'ping') {
                    // Save the 'ping' value to the database
                    $stmt = $pdo->prepare("INSERT INTO ping_pong (ping) VALUES (:ping)");
                    $stmt->execute(['ping' => $_POST['ping']]);
                    
                    // Send "pong" response
                    echo "pong";
                } else {
                    // If 'ping' parameter has a different value, return an error
                    http_response_code(400);
                    echo "Error: Invalid value for 'ping' parameter.";
                }
            } else {
                // If 'ping' parameter is missing, return an error
                http_response_code(400);
                echo "Error: 'ping' parameter is missing.";
            }
        } else {
            // If the request method is not POST, return an error
            http_response_code(405);
            echo "Error: Only POST requests are allowed.";
        }
    } catch (PDOException $e) {
        // If there's an error with the database connection, return an error
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
?>