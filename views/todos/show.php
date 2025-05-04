<?php
// views/todos/show.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Details</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Todo: <?= htmlspecialchars($todo['title']) ?></h1>
        <div class="todo-details">
            <p><strong>ID:</strong> <?= htmlspecialchars($todo['id']) ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($todo['description'] ?: 'No description') ?></p>
            <p><strong>Post Date:</strong>
                <?= htmlspecialchars($todo['post_date'] ?? 'Not set') ?>
            </p>
            <p><strong>Deadline Date:</strong>
                <?= htmlspecialchars($todo['deadline'] ?? 'Not set') ?>
            </p>
            <p><strong>Status:</strong>
                <span class="<?= $todo['completed'] ? 'status-completed' : 'status-pending' ?>">
                    <?= $todo['completed'] ? 'Completed' : 'Pending' ?>
                </span>
            </p>
            <div class="form-actions">
                <a href="/todos" class="btn btn-secondary">Back to Todos</a>
            </div>
        </div>
    </div>
</body>

</html>