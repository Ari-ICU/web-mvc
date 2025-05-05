**views/tasks/show.php**
```php
<?php $activePage = 'tasks'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content flex-grow-1 p-4">
            <h1 class="mb-4">Todo: <?= htmlspecialchars($todo['title']) ?></h1>
            <div class="todo-form">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6 mb-3">
                        <p><strong>ID:</strong> <?= htmlspecialchars($todo['id']) ?></p>
                        <p><strong>Description:</strong>
                            <?= htmlspecialchars($todo['description'] ?: 'No description') ?></p>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-6 mb-3">
                        <p><strong>Post Date:</strong> <?= htmlspecialchars($todo['post_date'] ?? 'Not set') ?></p>
                        <p><strong>Deadline Date:</strong> <?= htmlspecialchars($todo['deadline'] ?? 'Not set') ?></p>
                        <p><strong>Status:</strong>
                            <span class="<?= $todo['completed'] ? 'status-completed' : 'status-pending' ?>">
                                <?= $todo['completed'] ? 'Completed' : 'Pending' ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="/tasks" class="btn btn-secondary">Back to tasks</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>
```