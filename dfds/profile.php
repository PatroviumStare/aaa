<?php
$page_title = 'Профиль пользователя';

if (!isLoggedIn()) {
    header('Location: ?page=login');
    exit;
}

$user = currentUser();
$userId = $user['id'];

$visitCount = isset($_COOKIE['visit_count_' . $userId]) ? (int)$_COOKIE['visit_count_' . $userId] : 0;
$visitCount++;
setcookie('visit_count_' . $userId, $visitCount, time() + 365 * 24 * 60 * 60);

$tasks = findRecords(TASKS_FILE, ['user_id' => $userId]);
$totalTasks = count($tasks);
$completedTasks = count(array_filter($tasks, function($t) { return $t['status'] === 'completed'; }));
?>

<h1>Профиль пользователя</h1>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-avatar">
            <?php
            // Проверка на наличие аватара
            $avatarPath = UPLOAD_PATH . 'avatar_' . $userId . '.jpg';
            if (file_exists($avatarPath)) {
                echo '<img src="uploads/avatar_' . $userId . '.jpg" alt="Аватар">';
            } else {
                echo '<div class="avatar-placeholder">' . strtoupper(substr($user['name'], 0, 1)) . '</div>';
            }
            ?>
        </div>
        
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Зарегистрирован:</strong> <?php echo date('d.m.Y H:i', strtotime($user['created_at'])); ?></p>
            <p><strong>Всего задач:</strong> <?php echo $totalTasks; ?></p>
            <p><strong>Выполнено:</strong> <?php echo $completedTasks; ?> (<?php echo $totalTasks > 0 ? round($completedTasks / $totalTasks * 100, 1) : 0; ?>%)</p>
            <p><strong>Посещений профиля:</strong> <?php echo $visitCount; ?> раз</p>
        </div>
    </div>
</div>