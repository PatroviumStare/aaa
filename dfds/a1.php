<?php

header('Content-Type: text/plain; charset=utf-8');

if (!isset($_POST['num1']) || !isset($_POST['num2'])) {
    http_response_code(400);
    echo 'ошибка: отсутствуют параметры';
    exit;
}

$num1 = $_POST['num1'];
$num2 = $_POST['num2'];

if (!is_numeric($num1) || !is_numeric($num2)) {
    http_response_code(400);
    echo 'ошибка: неверные параметры';
    exit;
}

$sum = (float)$num1 + (float)$num2;

echo $sum;
?>