<?php
if(isset($_POST['calculate'])){
    $value1 = $_POST['value1'];
    $value2 = $_POST['value2'];
    $operation = $_POST['operation'];

    switch($operation){
        case 'add':
            $result = $value1 + $value2;
            break;
        case 'subtract':
            $result = $value1 - $value2;
            break;
        case 'multiply':
            $result = $value1 * $value2;
            break;
        case 'divide':
            if($value2 != 0){
                $result = $value1 / $value2;
            } else {
                $result = "Error: Division by zero";
            }
            break;
        default:
            $result = "Invalid operation";
    }

    echo $result;
}
?>
