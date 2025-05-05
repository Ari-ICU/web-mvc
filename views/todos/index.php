<?php $activePage = 'todos'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos</title>
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
            <h1 class="mb-4">Task</h1>
            <div class="filter-section mb-3">
                <a href="/todos/create" class="btn btn-primary">Add New Task</a>
            </div>

            <?php if (empty($todos)): ?>
            <p class="no-data text-center">No Data Available</p>
            <?php else: ?>
            <div class="todo-table-header d-flex justify-content-between align-items-center mb-3">
                <p class="data-available mb-0">Todo List</p>
                <form action="/todos" method="GET" class="filter-form" style="display:inline;">
                    <label for="sort" class="me-2">Sort by Title:</label>
                    <select id="sort" name="sort" class="form-select d-inline-block w-auto"
                        onchange="this.form.submit()">
                        <option value="" <?= !isset($_GET['sort']) ? 'selected' : '' ?>>Default</option>
                        <option value="asc" <?= isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'selected' : '' ?>>A-Z
                        </option>
                        <option value="desc" <?= isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : '' ?>>
                            Z-A</option>
                    </select>
                </form>
            </div>
            <div class="table-responsive">
                <table class="todo-table table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Post Date</th>
                            <th>Deadline Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todos as $todo): ?>
                        <tr class="todo-item <?= $todo['completed'] ? 'completed' : '' ?>">
                            <td>
                                <a href="/todos/<?= htmlspecialchars($todo['id']) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($todo['title']) ?>
                                </a>
                            </td>
                            <td>
                                <span><?= htmlspecialchars(array_key_exists('post_date', $todo) && $todo['post_date'] ? $todo['post_date'] : '') ?></span>
                            </td>
                            <td>
                                <span><?= htmlspecialchars(array_key_exists('deadline', $todo) && $todo['deadline'] ? $todo['deadline'] : '') ?></span>
                            </td>
                            <td class="<?= $todo['completed'] ? 'status-completed' : 'status-pending' ?>">
                                <span><?= $todo['completed'] ? 'Completed' : 'Pending' ?></span>
                            </td>
                            <td>
                                <div class="action-buttons d-flex gap-2">
                                    <a href="/todos/<?= htmlspecialchars($todo['id']) ?>/edit"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="/todos/<?= htmlspecialchars($todo['id']) ?>/delete" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this todo?')">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>