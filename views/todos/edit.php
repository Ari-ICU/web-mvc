<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Edit Todo</h1>
        <form action="/todos/<?= htmlspecialchars($todo['id']) ?>/edit" method="POST" class="todo-form">
            <!-- CSRF Token (example; adjust based on your framework) -->
            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN') ?>">

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($todo['title']) ?>" required
                    class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description"
                    class="form-control"><?= htmlspecialchars($todo['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="post_date">Post Date:</label>
                <input type="date" id="post_date" name="post_date"
                    value="<?= htmlspecialchars($todo['post_date'] ?? '') ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="deadline">Deadline Date:</label>
                <input type="date" id="deadline" name="deadline"
                    value="<?= htmlspecialchars($todo['deadline'] ?? '') ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="completed">Completed:</label>
                <input type="checkbox" id="completed" name="completed" value="1"
                    <?= $todo['completed'] ? 'checked' : '' ?>>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/todos" class="btn btn-secondary">Back to List</a>
            </div>
        </form>
    </div>
</body>

</html>