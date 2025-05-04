<?php
// views/todos/show.php
?>
<!DOCTYPE html>
<html>

<head>
    <title>Todo Details</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Todo: <?= htmlspecialchars($todo['title']) ?></h1>
        <p>ID: <?= $todo['id'] ?></p>
        <p>Description: <?= htmlspecialchars($todo['description'] ?: 'No description') ?></p>
        <p>Status: <?= $todo['completed'] ? 'Completed' : 'Pending' ?></p>
        <a href="/todos" class="btn btn-secondary">Back to Todos</a>
    </div>
</body>

</html>