<?php
    date_default_timezone_set("America/Sao_Paulo");
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

$_SESSION["token"] = null;

echo '1';

?>