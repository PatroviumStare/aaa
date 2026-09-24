<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lib/auth.php';
require_once __DIR__ . '/lib/validation.php';

if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    logoutUser();
    header('Location: ?page=login');
    exit;
}

$page = $_GET['page'] ?? 'home';

$publicPages = ['home', 'login', 'register'];
$authPages = ['tasks', 'profile'];

if (in_array($page, $authPages) && !isLoggedIn()) {
    header('Location: ?page=login');
    exit;
}

if (in_array($page, ['login', 'register']) && isLoggedIn()) {
    header('Location: ?page=home');
    exit;
}

$pageFile = __DIR__ . '/pages/' . $page . '.php';

if (!file_exists($pageFile)) {
    $pageFile = __DIR__ . '/pages/404.php';
}

require_once __DIR__ . '/templates/header.php';

require_once $pageFile;

require_once __DIR__ . '/templates/footer.php';
?>