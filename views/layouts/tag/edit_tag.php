<?php $activePage = 'tag'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content flex-grow-1 p-4">
            <h1 class="mb-4">Edit Tag</h1>
            <form action="/tags/<?= htmlspecialchars($tag['id']) ?>/edit" method="POST" class="tag-form">
                <!-- CSRF Token -->
                <input type="hidden" name="_token"
                    value="<?php echo htmlspecialchars($csrf_token ?? 'YOUR_CSRF_TOKEN'); ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Tag Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($tag['name']) ?>" required
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional):</label>
                    <textarea id="description" name="description" class="form-control"
                        rows="4"><?= htmlspecialchars($tag['description'] ?? '') ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/tags" class="btn btn-secondary">Back to Tags</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>