<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Приложение - <?php echo $page_title ?? 'Главная'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <a href="?page=home" class="logo">TaskManager</a>
            </div>
            <div class="nav-right">
                <?php if (isLoggedIn()): ?>
                    <span class="user-name"><?php echo htmlspecialchars(currentUser()['name'] ?? 'Пользователь'); ?></span>
                    <a href="?page=tasks">Задачи</a>
                    <a href="?page=profile">Профиль</a>
                    <a href="?page=logout" class="logout">Выйти</a>
                <?php else: ?>
                    <a href="?page=login">Логин</a>
                    <a href="?page=register">Регистрация</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>