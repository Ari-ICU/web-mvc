<?php $activePage = 'todos'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>
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
            <h1 class="mb-4">Edit Todo</h1>
            <form action="/todos/<?= htmlspecialchars($todo['id']) ?>/edit" method="POST" class="todo-form"
                id="task-form">
                <!-- CSRF Token -->
                <input type="hidden" name="_token"
                    value="<?php echo htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN'); ?>">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" id="title" name="title" value="<?= htmlspecialchars($todo['title']) ?>"
                                required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" name="description" class="form-control"
                                rows="4"><?= htmlspecialchars($todo['description']) ?></textarea>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="post_date" class="form-label">Post Date:</label>
                            <input type="date" id="post_date" name="post_date"
                                value="<?= htmlspecialchars($todo['post_date'] ?? '') ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="deadline" class="form-label">Deadline Date:</label>
                            <input type="date" id="deadline" name="deadline"
                                value="<?= htmlspecialchars($todo['deadline'] ?? '') ?>" class="form-control">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" id="completed" name="completed" value="1"
                                <?= $todo['completed'] ? 'checked' : '' ?> class="form-check-input">
                            <label for="completed" class="form-check-label">Completed:</label>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/todos" class="btn btn-secondary">Back to List</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>