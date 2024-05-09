<?php
    $content = file_get_contents("php://input");
    $json = json_decode($content);
    echo "recebi usuario ".$json->usuario;


    
