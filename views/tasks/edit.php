<?php $activePage = 'tasks'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN'); ?>">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="d-flex">
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>
        <div class="content flex-grow-1 p-4">
            <h1 class="mb-4">Edit Task</h1>
            <form action="/tasks/<?php echo htmlspecialchars($task['id']); ?>/edit" method="POST" class="todo-form"
                id="task-form">
                <input type="hidden" name="_token"
                    value="<?php echo htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN'); ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" id="title" name="title"
                                value="<?php echo htmlspecialchars($task['title']); ?>" required class="form-control"
                                maxlength="255">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" name="description" class="form-control"
                                rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Assign To:</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">Select User</option>
                                <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user['id']); ?>"
                                    <?php echo ($task['user_id'] == $user['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($user['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <select name="tags[]" id="tags" class="form-select select2" multiple>
                                <?php foreach ($tags as $tag): ?>
                                <option value="<?php echo htmlspecialchars($tag['id']); ?>"
                                    <?php foreach ($selectedTags as $selectedTag): ?>
                                    <?php echo $selectedTag['id'] == $tag['id'] ? 'selected' : ''; ?>
                                    <?php endforeach; ?>>
                                    <?php echo htmlspecialchars($tag['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority:</label>
                            <select name="priority" id="priority" class="form-control">
                                <?php 
                                $priorities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'];
                                foreach ($priorities as $value => $label): ?>
                                <option value="<?php echo $value; ?>"
                                    <?php echo ($task['priority'] ?? 'medium') === $value ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select name="status" id="status" class="form-control">
                                <?php 
                                $statuses = ['pending' => 'Pending', 'completed' => 'Completed', 'canceled' => 'Canceled'];
                                foreach ($statuses as $value => $label): ?>
                                <option value="<?php echo $value; ?>"
                                    <?php echo ($task['status'] ?? 'pending') === $value ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control"
                                value="<?php echo htmlspecialchars($task['due_date'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/tasks" class="btn btn-secondary">Back to List</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        // Initialize Select2
        $('#tags').select2({
            placeholder: "Select tags",
            allowClear: true,
            width: '100%'
        });

        // Form validation
        $('#task-form').on('submit', function(e) {
            const title = $('#title').val().trim();
            if (!title) {
                e.preventDefault();
                alert('Title is required');
                return false;
            }

            const dueDate = $('#due_date').val();
            if (dueDate) {
                const today = new Date().toISOString().split('T')[0];
                if (dueDate < today) {
                    e.preventDefault();
                    alert('Due date cannot be in the past');
                    return false;
                }
            }
        });
    });
    </script>
    <script src="/js/app.js"></script>
</body>

</html>