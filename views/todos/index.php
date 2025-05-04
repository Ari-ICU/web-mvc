<!DOCTYPE html>
<html>

<head>
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
        <ul class="todo-list">
            <?php foreach ($todos as $todo): ?>
            <li class="todo-item <?= $todo['completed'] ? 'completed' : '' ?>">
                <a href="/todos/<?= $todo['id'] ?>">
                    <?= htmlspecialchars($todo['title']) ?>
                    (<?= $todo['completed'] ? 'Completed' : 'Pending' ?>)
                </a>
                <div>
                    <!-- Edit Button -->
                    <a href="/todos/<?= $todo['id'] ?>/edit" class="btn btn-secondary">Edit</a>
                    <!-- Delete Form -->
                    <form action="/todos/<?= $todo['id'] ?>/delete" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this todo?')">Delete</button>
                    </form>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</body>

</html>