<?php
$page_title = 'Регистрация';

if (isLoggedIn()) {
    header('Location: ?page=home');
    exit;
}

$errors = [];
$formData = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    
    $formData = ['name' => $name, 'email' => $email];
    
    $errors = collectErrors([
        'name' => validateName($name),
        'email' => validateEmail($email),
        'password' => validatePassword($password),
        'password_confirm' => $password !== $passwordConfirm ? 'Пароли не совпадают' : null
    ]);
    
    if (empty($errors)) {
        $result = registerUser($name, $email, $password);
        if ($result['success']) {
            loginUser($email, $password);
            header('Location: ?page=home');
            exit;
        } else {
            $errors['general'] = $result['error'];
        }
    }
}
?>
<h1>Регистрация</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="error-message"><?php echo htmlspecialchars($errors['general']); ?></div>
<?php endif; ?>

<form action="" method="POST" class="auth-form">
    <div class="form-group">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($formData['name']); ?>" required>
        <?php if (!empty($errors['name'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['name']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>" required>
        <?php if (!empty($errors['email'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['email']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="password">Пароль (мин. 6 символов):</label>
        <input type="password" id="password" name="password" required>
        <?php if (!empty($errors['password'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['password']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="password_confirm">Подтверждение пароля:</label>
        <input type="password" id="password_confirm" name="password_confirm" required>
        <?php if (!empty($errors['password_confirm'])): ?>
            <span class="field-error"><?php echo htmlspecialchars($errors['password_confirm']); ?></span>
        <?php endif; ?>
    </div>
    
    <button type="submit" class="btn-primary">Зарегистрироваться</button>
</form>
<p>Уже есть аккаунт? <a href="?page=login">Войти</a></p>