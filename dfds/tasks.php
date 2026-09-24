<?php
$page_title = 'Мои задачи';

if (!isLoggedIn()) {
    header('Location: ?page=login');
    exit;
}

$user = currentUser();
$userId = $user['id'];

$action = $_GET['action'] ?? '';
$taskId = $_GET['id'] ?? null;

if ($action === 'delete' && $taskId) {
    $task = getRecord(TASKS_FILE, $taskId);
    if ($task && $task['user_id'] == $userId) {
        deleteRecord(TASKS_FILE, $taskId);
        header('Location: ?page=tasks');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_task'])) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'new';
    
    $errors = collectErrors([
        'title' => validateTaskTitle($title)
    ]);
    
    if (empty($errors)) {
        $task = [
            'user_id' => $userId,
            'title' => trim($title),
            'description' => trim($description),
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];
        createRecord(TASKS_FILE, $task);
        header('Location: ?page=tasks');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_task']) && $taskId) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'new';
    
    $errors = collectErrors([
        'title' => validateTaskTitle($title)
    ]);
    
    if (empty($errors)) {
        $task = getRecord(TASKS_FILE, $taskId);
        if ($task && $task['user_id'] == $userId) {
            updateRecord(TASKS_FILE, $taskId, [
                'title' => trim($title),
                'description' => trim($description),
                'status' => $status
            ]);
            header('Location: ?page=tasks');
            exit;
        }
    }
}

$tasks = findRecords(TASKS_FILE, ['user_id' => $userId]);

$editingTask = null;
if ($action === 'edit' && $taskId) {
    $editingTask = getRecord(TASKS_FILE, $taskId);
    if (!$editingTask || $editingTask['user_id'] != $userId) {
        $editingTask = null;
    }
}

$statuses = [
    'new' => 'Новая',
    'in_progress' => 'В работе',
    'completed' => 'Выполнена'
];
$statusClasses = [
    'new' => 'status-new',
    'in_progress' => 'status-progress',
    'completed' => 'status-completed'
];
?>

<h1>Мои задачи</h1>

<div class="task-form-box">
    <h2><?php echo $editingTask ? 'Редактирование задачи' : 'Создать задачу'; ?></h2>
    <?php if (!empty($errors)): ?>
        <div class="error-message"><?php echo htmlspecialchars($errors['title'] ?? 'Ошибка валидации'); ?></div>
    <?php endif; ?>
    <form action="" method="POST" class="task-form">
        <div class="form-group">
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($editingTask['title'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($editingTask['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Статус:</label>
            <select id="status" name="status">
                <?php foreach ($statuses as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php echo (($editingTask['status'] ?? 'new') == $key) ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if ($editingTask): ?>
            <input type="hidden" name="edit_task" value="1">
            <button type="submit" class="btn-primary">Обновить</button>
            <a href="?page=tasks" class="btn-cancel">Отмена</a>
        <?php else: ?>
            <input type="hidden" name="create_task" value="1">
            <button type="submit" class="btn-primary">Создать</button>
        <?php endif; ?>
    </form>
</div>

<div class="tasks-list">
    <?php if (empty($tasks)): ?>
        <p class="no-tasks">У вас пока нет задач. Создайте первую!</p>
    <?php else: ?>
        <table class="tasks-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Статус</th>
                    <th>Создана</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_reverse($tasks) as $task): ?>
                    <tr>
                        <td><?php echo $task['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($task['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                        <td><span class="status-badge <?php echo $statusClasses[$task['status']] ?? ''; ?>">
                            <?php echo $statuses[$task['status']] ?? $task['status']; ?>
                        </span></td>
                        <td><?php echo date('d.m.Y H:i', strtotime($task['created_at'])); ?></td>
                        <td class="actions">
                            <a href="?page=tasks&action=edit&id=<?php echo $task['id']; ?>" class="btn-edit">✏️</a>
                            <a href="?page=tasks&action=delete&id=<?php echo $task['id']; ?>" 
                               onclick="return confirm('Удалить задачу?')" 
                               class="btn-delete">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>