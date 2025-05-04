<?php
// views/todos/create.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Todo</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Create Todo</h1>
        <form method="POST" action="/todos/create" class="todo-form">
            <!-- CSRF Token (example; adjust based on your framework) -->
            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN') ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="post_date">Post Date:</label>
                <input type="date" id="post_date" name="post_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="deadline">Deadline Date:</label>
                <input type="date" id="deadline" name="deadline" class="form-control">
            </div>
            <div class="form-group">
                <label for="completed">Completed:</label>
                <input type="checkbox" id="completed" name="completed" value="1">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="/todos" class="btn btn-secondary">Back to Todos</a>
            </div>
        </form>
    </div>
</body>

</html>