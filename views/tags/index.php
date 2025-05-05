<?php $activePage = 'tag'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags</title>
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
            <h1 class="mb-4">Tags</h1>
            <div class="filter-section mb-3">
                <a href="/tags/create" class="btn btn-primary">Add New Tag</a>
            </div>

            <?php if (empty($tags)): ?>
            <p class="no-data text-center">No Tags Available</p>
            <?php else: ?>
            <div class="tag-table-header d-flex justify-content-between align-items-center mb-3">
                <p class="data-available mb-0">Tag List</p>
                <form action="/tags" method="GET" class="filter-form" style="display:inline;">
                    <label for="sort" class="me-2">Sort by Name:</label>
                    <select id="sort" name="sort" class="form-select d-inline-block w-auto"
                        onchange="this.form.submit()">
                        <option value="" <?= !isset($_GET['sort']) ? 'selected' : '' ?>>Default</option>
                        <option value="asc" <?= isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'selected' : '' ?>>A-Z
                        </option>
                        <option value="desc" <?= isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : '' ?>>
                            Z-A</option>
                    </select>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tags as $tag): ?>
                        <tr>
                            <td>
                                <a href="/tags/<?= htmlspecialchars($tag['id']) ?>">
                                    <?= htmlspecialchars($tag['name']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($tag['description'] ?? '-') ?></td>
                            <td>
                                <div class="action-buttons d-flex gap-2">
                                    <a href="/tags/<?= htmlspecialchars($tag['id']) ?>/edit"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="/tags/<?= htmlspecialchars($tag['id']) ?>/delete" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this tag?')">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/app.js"></script>
</body>

</html>