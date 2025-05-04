<!DOCTYPE html>
<html>

<head>
    <title>Edit Todo</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Edit Todo</h1>
        <form action="/todos/<?= $todo['id'] ?>/edit" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($todo['title']) ?>" required>
            <label for="completed">Completed:</label>
            <input type="checkbox" name="completed" <?= $todo['completed'] ? 'checked' : '' ?>>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <a href="/todos">Back to List</a>
    </div>
</body>

</html>