<?php $activePage = 'tasks'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Todo</title>
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
            <h1 class="mb-4">Create Todo</h1>
            <form method="POST" action="/tasks/create" class="todo-form" id="task-form">
                <!-- CSRF Token -->
                <input type="hidden" name="_token"
                    value="<?php echo htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN'); ?>">

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6 mb-3">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Assign To:</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user['id']); ?>">
                                    <?php echo htmlspecialchars($user['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6 mb-3">
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags:</label>
                            <select name="tags[]" id="tags" class="form-control" multiple required>
                                <?php foreach ($tags as $tag): ?>
                                <option value="<?php echo htmlspecialchars($tag['id']); ?>">
                                    <?php echo htmlspecialchars($tag['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority:</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" selected>Pending</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date:</label>
                            <input type="date" id="due_date" name="due_date" class="form-control"
                                value="<?= htmlspecialchars($formData['due_date'] ?? $task['due_date'] ?? '') ?>">
                        </div>

                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="/tasks" class="btn btn-secondary">Back to tasks</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    // Initialize Select2 for the tags and user_id fields
    $(document).ready(function() {
        $('#tags').select2();
        $('#user_id').select2();
    });
    </script>
    <script src="/js/app.js"></script>
</body>

</html>