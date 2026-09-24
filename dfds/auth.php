<?php
require_once __DIR__ . '/storage.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function currentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    $users = readData(USERS_FILE);
    foreach ($users as $user) {
        if ($user['id'] == $_SESSION['user_id']) {
            return $user;
        }
    }
    return null;
}

function registerUser($name, $email, $password) {
    $users = readData(USERS_FILE);
    
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return ['success' => false, 'error' => 'Пользователь с таким email уже существует!'];
        }
    }
    
    $user = [
        'name' => trim($name),
        'email' => trim($email),
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $id = createRecord(USERS_FILE, $user);
    
    return ['success' => true, 'id' => $id];
}

function loginUser($email, $password) {
    $users = readData(USERS_FILE);
    
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                return ['success' => true];
            }
            return ['success' => false, 'error' => 'Неверный пароль!'];
        }
    }
    
    return ['success' => false, 'error' => 'Пользователь не найден!'];
}

function logoutUser() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}
?>