<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Todos</h1>
        <a href="/todos/create" class="btn btn-primary">Add New Todo</a>
        <?php if (empty($todos)): ?>
        <p class="no-data">No Data Available</p>
        <?php else: ?>
        <p class="data-available">Todo List</p>
        <table class="todo-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todos as $todo): ?>
                <tr class="todo-item <?= $todo['completed'] ? 'completed' : '' ?>">
                    <td>
                        <a href="/todos/<?= htmlspecialchars($todo['id']) ?>">
                            <?= htmlspecialchars($todo['title']) ?>

                        </a>
                    </td>
                    <td class="<?= $todo['completed'] ? 'status-completed' : 'status-pending' ?>">
                        <?= $todo['completed'] ? 'Completed' : 'Pending' ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="/todos/<?= htmlspecialchars($todo['id']) ?>/edit"
                                class="btn btn-secondary">Edit</a>
                            <form action="/todos/<?= htmlspecialchars($todo['id']) ?>/delete" method="POST"
                                style="display:inline;">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this todo?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</body>

</html>