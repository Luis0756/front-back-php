<?php 

require_once("database.php");

class Authentication {
    private static $database; 
    private static $user;
    private static $password;
    public function __construct($login) {
        $this->database = new Database();
        $sql = "select * from usuario u where u.email_login = '{$login}'";
        $result = $this->database->Consultar($sql);
        $this->login = $login;
        $this->password = $login;
        $this->user = $result[0];
    } 

    public function checkPassword($password) {
        return $this->user['password'] == $password;
    }

    public function getValidToken() {

    }

    public function generateToken() {
        
    }
}

?>