<?php $activePage = 'users'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User: <?= htmlspecialchars($user['name']) ?></title>
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
            <h1 class="mb-4">User: <?= htmlspecialchars($user['name']) ?></h1>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">User Details</h5>
                    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Created At:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
                    <p><strong>Updated At:</strong> <?= htmlspecialchars($user['updated_at']) ?></p>
                </div>
            </div>

            <h2 class="mb-3">Assigned Tasks</h2>
            <?php if (empty($tasks)): ?>
            <p class="no-data text-center">No Tasks Assigned</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td>
                                <a href="/tasks/<?= htmlspecialchars($task['id']) ?>">
                                    <?= htmlspecialchars($task['title']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($task['status']) ?></td>
                            <td><?= htmlspecialchars($task['priority']) ?></td>
                            <td><?= htmlspecialchars($task['due_date'] ?? '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <a href="/users" class="btn btn-secondary mt-3">Back to Users</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>