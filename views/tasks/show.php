<?php $activePage = 'tasks'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task: <?= htmlspecialchars($task['title']) ?></title>
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
            <h1 class="mb-4">Task: <?= htmlspecialchars($task['title']) ?></h1>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Task Details</h5>
                    <p><strong>Title:</strong> <?= htmlspecialchars($task['title']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($task['description'] ?? '-') ?></p>
                    <p><strong>Due Date:</strong> <?= htmlspecialchars($task['due_date'] ?? '-') ?></p>
                    <p><strong>Priority:</strong> <?= htmlspecialchars(ucfirst($task['priority'])) ?></p>
                    <p><strong>Status:</strong>
                        <?php
                        switch ($task['status']) {
                            case 'completed':
                                echo '<span class="badge bg-success">Completed</span>';
                                break;
                            case 'canceled':
                                echo '<span class="badge bg-danger">Canceled</span>';
                                break;
                            case 'pending':
                            default:
                                echo '<span class="badge bg-warning">Pending</span>';
                                break;
                        }
                        ?>
                    </p>
                    <p><strong>Assigned User:</strong> <?= $user ? htmlspecialchars($user['name']) : '-' ?></p>
                    <p><strong>Tags:</strong>
                        <?= $tags ? implode(', ', array_map(function ($tag) {
                            return htmlspecialchars($tag['name']);
                        }, $tags)) : '-' ?>
                    </p>
                    <p><strong>Created At:</strong> <?= htmlspecialchars($task['created_at']) ?></p>
                    <p><strong>Updated At:</strong> <?= htmlspecialchars($task['updated_at']) ?></p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="/tasks/<?= htmlspecialchars($task['id']) ?>/edit" class="btn btn-primary">Edit Task</a>
                <a href="/tasks" class="btn btn-secondary">Back to Tasks</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>