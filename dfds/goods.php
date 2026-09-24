<?php
// goods.php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['art'])) {
    http_response_code(400);
    echo json_encode(['error' => 'отсутствует параметр art']);
    exit;
}

$art = $_GET['art'];

if ($art !== '1' && $art !== '2') {
    http_response_code(400);
    echo json_encode(['error' => 'неверный артикул']);
    exit;
}

if ($art === '1') {
    $data = [
        'art' => 1,
        'name' => 'Кружка',
        'price' => 199.99,
        'description' => 'Керамическая кружка 300 мл',
        'availability' => 'есть'
    ];
} else { // art === '2'
    $data = [
        'art' => 2,
        'name' => 'Бутылка вода 750мл',
        'price' => 249.00,
        'description' => 'Стальная бутылка с крышкой',
        'availability' => 'есть'
    ];
}

echo json_encode($data);