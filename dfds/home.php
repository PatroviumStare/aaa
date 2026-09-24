<?php
$page_title = 'Главная';
?>
<h1>Добро пожаловать в TaskManager!</h1>

<?php if (isLoggedIn()): ?>
    <div class="welcome-box">
        <h2>Привет, <?php echo htmlspecialchars(currentUser()['name']); ?>!</h2>
        <p>Вы успешно авторизовались</p>
        <p>Перейдите в <a href="?page=tasks">раздел задач</a> для управления своими делами.</p>
    </div>
<?php else: ?>
    <div class="welcome-box">
        <h2>Добро пожаловать!</h2>
        <p>Для работы с приложением необходимо <a href="?page=register">зарегистрироваться</a> или <a href="?page=login">войти</a>.</p>
    </div>
<?php endif; ?>