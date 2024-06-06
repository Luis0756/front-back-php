<?php

    class Database {
        private string $servername; 
        private $username; 
        private $password; 
        private $database; 
        private $port; 
        private PDO $PDO;
        private function __construct() { 
               
            $this -> servername = "localhost";
            $this -> username = "root";
            $this -> password = "root";
            $this -> database = "root";
            $this -> port = "3306";

            $this -> PDO = new PDO("mysql:host={$this->servername};dbname={$this->servername};port={$this->port}");
            
            if ($this -> PDO->connect_error) {
                die("Connection failed: " . $this -> PDO->connect_error);
            }   
            echo "Connected successfully";
            
            $this -> PDO->close();
        }

        public function Consultar() {
            
        }
    }
?>