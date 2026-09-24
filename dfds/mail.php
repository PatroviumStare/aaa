<?php
// mail.php
header('Content-Type: text/plain; charset=utf-8');

// Проверка параметров
if (!isset($_POST['fio']) || !isset($_POST['email']) || !isset($_POST['phone'])) {
    http_response_code(400);
    echo 'ошибка: отсутствуют параметры';
    exit;
}

$fio = trim($_POST['fio']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);

// Валидация
if ($fio === '' || $email === '' || $phone === '') {
    http_response_code(400);
    echo 'ошибка: пустые поля';
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo 'ошибка: неверный email';
    exit;
}

// Укажите реальный адрес получателя здесь
$to = 'recipient@example.com'; // замените на реальный адрес
$subject = 'Новая заявка с сайта';
$body = "ФИО: $fio\nEmail: $email\nТелефон: $phone";

$headers = "Content-Type: text/plain; charset=utf-8\r\n";
$headers .= "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

// Попытка отправки письма
$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    echo 'Письмо отправлено';
} else {
    http_response_code(500);
    echo 'ошибка: не удалось отправить письмо';
}