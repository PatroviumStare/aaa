<?php

header('Content-Type: text/plain; charset=utf-8');

if (!isset($_POST['sex']) || !isset($_POST['height'])) {
    http_response_code(400);
    echo 'ошибка: отсутствуют параметры';
    exit;
}

$sex = $_POST['sex'];
$heightStr = $_POST['height'];

if (($sex !== 'man') && ($sex !== 'woman')) {
    http_response_code(400);
    echo 'ошибка: неверные параметры';
    exit;
}

$height = filter_var($heightStr, FILTER_VALIDATE_INT);
if ($height === false || $height <= 0) {
    http_response_code(400);
    echo 'ошибка: неверные параметры';
    exit;
}

$ideal = ($sex === 'man') ? ($height - 100) : ($height - 105);
if ($ideal < 0) $ideal = 0;

echo (string)$ideal;
?>