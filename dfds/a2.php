<?php
header('Content-Type: text/plain; charset=utf-8');

if (!isset($_POST['year'])) {
    http_response_code(400);
    echo 'ошибка: отсутствуют параметры';
    exit;
}

$yearStr = $_POST['year'];

if (!ctype_digit($yearStr) || strlen($yearStr) !== 4) {
    http_response_code(400);
    echo 'ошибка: неверные параметры';
    exit;
}

$birthYear = (int)$yearStr;
$currentYear = (int)date('Y');
$minYear = 1900;

if ($birthYear < $minYear || $birthYear > $currentYear) {
    http_response_code(400);
    echo 'ошибка: неверный год рождения';
    exit;
}

$age = $currentYear - $birthYear;

echo $age;
?>