<?php $activePage = 'tag'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tag Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content flex-grow-1 p-4">
            <h1 class="mb-4">Tag: <?= htmlspecialchars($tag['name']) ?></h1>
            <div class="tag-details">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6 mb-3">
                        <p><strong>ID:</strong> <?= htmlspecialchars($tag['id']) ?></p>
                        <p><strong>Name:</strong> <?= htmlspecialchars($tag['name']) ?></p>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6 mb-3">
                        <p><strong>Description:</strong>
                            <?= !empty($tag['description']) ? htmlspecialchars($tag['description']) : 'No description' ?>
                        </p>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="/tags" class="btn btn-secondary">Back to Tags</a>
                    <a href="/tags/<?= htmlspecialchars($tag['id']) ?>/edit" class="btn btn-primary">Edit Tag</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>