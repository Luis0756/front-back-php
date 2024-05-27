<?php
$v1 = floatval($_POST['v1']);
$v2 = floatval($_POST['v2']);
$op = $_POST['op'];
$resultado = 0;
if ($op == '+') {
    $resultado = $v1 + $v2;
} else if ($op == '-') {
    $resultado = $v1 - $v2;
}
if ($op == '*') {
    $resultado = $v1 * $v2;
}
if ($op == '/') {
    if ($v2 == 0) {
        $resultado = "Não pode dividir por zero";
    } else {
        $resultado = $v1 / $v2;
    }
}

echo $resultado;
