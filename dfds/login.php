<?php
$page_title = 'Вход';

if (isLoggedIn()) {
    header('Location: ?page=home');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = loginUser($email, $password);
    if ($result['success']) {
        header('Location: ?page=home');
        exit;
    } else {
        $error = $result['error'];
    }
}
?>
<h1>Вход</h1>

<?php if ($error): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form action="" method="POST" class="auth-form">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <button type="submit" class="btn-primary">Войти</button>
</form>
<p>Нет аккаунта? <a href="?page=register">Зарегистрироваться</a></p>