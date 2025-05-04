<?php
// views/todos/create.php
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Todo</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Create Todo</h1>
        <form method="POST" action="/todos/create">
            <div class="form-group">
                <label>Title: <input type="text" name="title" class="form-control" required></label>
            </div>
            <div class="form-group">
                <label>Description: <textarea name="description" class="form-control"></textarea></label>
            </div>
            <div class="form-group">
                <label>Completed: <input type="checkbox" name="completed" value="1"></label>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        <a href="/todos" class="btn btn-secondary">Back to Todos</a>
    </div>
</body>

</html>