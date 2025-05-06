<?php $activePage = 'tasks'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN'); ?>">
    <title>Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="d-flex">
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>
        <div class="content flex-grow-1 p-4">
            <h1 class="mb-4">Tasks</h1>

            <?php if (isset($errors) && $errors): ?>
            <div class="alert alert-<?php echo htmlspecialchars($errors['type']); ?> alert-dismissible fade show"
                role="alert">
                <?php echo htmlspecialchars($errors['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="filter-section mb-3">
                <a href="/tasks/create" class="btn btn-primary">Add New Task</a>
            </div>

            <?php // Debug: Uncomment to inspect tasks array ?>
            <?php // var_dump($tasks); exit; ?>

            <?php if (empty($tasks)): ?>
            <p class="no-data text-center">No Tasks Available</p>
            <?php else: ?>
            <div class="todo-table-header d-flex justify-content-between align-items-center mb-3">
                <p class="data-available mb-0">Task List</p>
                <form action="/tasks" method="GET" class="filter-form" style="display:inline;">
                    <label for="sort" class="me-2">Sort by Title:</label>
                    <select id="sort" name="sort" class="form-select d-inline-block w-auto"
                        onchange="this.form.submit()">
                        <option value="" <?php echo !isset($_GET['sort']) ? 'selected' : ''; ?>>Default</option>
                        <option value="asc"
                            <?php echo isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'selected' : ''; ?>>A-Z
                        </option>
                        <option value="desc"
                            <?php echo isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : ''; ?>>Z-A
                        </option>
                    </select>
                </form>
            </div>
            <div class="table-responsive">
                <table class="todo-table table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>Tags</th>
                            <th>Due Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                        <?php
                                $tags = isset($task['tags']) && is_array($task['tags']) ? $task['tags'] : [];
                                $user = isset($task['user']) && is_array($task['user']) ? $task['user'] : null;
                                $due_date = isset($task['due_date']) && $task['due_date'] ? htmlspecialchars($task['due_date']) : '-';
                                ?>
                        <tr class="todo-item <?php echo $task['status'] === 'completed' ? 'completed' : ''; ?>">
                            <td>
                                <a href="/tasks/<?php echo htmlspecialchars($task['id']); ?>"
                                    class="text-decoration-none">
                                    <?php echo htmlspecialchars($task['title']); ?>
                                </a>
                            </td>
                            <td>
                                <?php
                                        $priority = $task['priority'] ?? 'low';
                                        switch ($priority) {
                                            case 'high':
                                                echo '<span class="badge bg-danger">High</span>';
                                                break;
                                            case 'medium':
                                                echo '<span class="badge bg-warning text-dark">Medium</span>';
                                                break;
                                            case 'low':
                                            default:
                                                echo '<span class="badge bg-secondary">Low</span>';
                                                break;
                                        }
                                        ?>
                            </td>

                            <td>
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
                            </td>
                            <td>
                                <?php echo $user && isset($user['name']) ? htmlspecialchars($user['name']) : 'Unassigned'; ?>
                            </td>
                            <td>
                                <?php
                                        if ($tags) {
                                            echo implode(', ', array_map(function ($tag) {
                                                return htmlspecialchars($tag['name'] ?? 'Unknown');
                                            }, $tags));
                                        } else {
                                            echo 'No tags';
                                        }
                                        ?>
                            </td>
                            <td>
                                <?php echo $due_date; ?>
                            </td>
                            <td>
                                <div class="action-buttons d-flex gap-2">
                                    <a href="/tasks/<?php echo htmlspecialchars($task['id']); ?>/edit"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="/tasks/<?php echo htmlspecialchars($task['id']); ?>/delete"
                                        method="POST" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this task?')">
                                        <input type="hidden" name="_token"
                                            value="<?php echo htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN'); ?>">
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