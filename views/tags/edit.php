<?php $activePage = 'tag'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
    .tag-form .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
    }

    .form-label {
        font-weight: 500;
    }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content flex-grow-1 p-4" role="main">
            <h1 class="mb-4">Edit Tag</h1>
            <form action="/tags/<?php echo htmlspecialchars($id); ?>/edit" method="POST" class="tag-form"
                id="editTagForm" novalidate>
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrf_token ?? session_id()); ?>">

                <!-- Error Feedback -->
                <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Tag Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($tag['name'] ?? ''); ?>"
                        required class="form-control" maxlength="50" aria-describedby="nameHelp nameError"
                        placeholder="Enter tag name (e.g., Work)">
                    <div id="nameHelp" class="form-text">Unique name for the tag (max 50 characters).</div>
                    <div id="nameError" class="error-message" style="display: none;">Please enter a valid tag name.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional):</label>
                    <textarea id="description" name="description" class="form-control" rows="4"
                        aria-describedby="descriptionHelp"><?php echo htmlspecialchars($tag['description'] ?? ''); ?></textarea>
                    <div id="descriptionHelp" class="form-text">Brief description of the tag.</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Tag</button>
                    <a href="/tags" class="btn btn-secondary">Back to Tags</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/app.js"></script>
    <script>
    document.getElementById('editTagForm').addEventListener('submit', function(event) {
        const nameInput = document.getElementById('name');
        const nameError = document.getElementById('nameError');
        let isValid = true;

        // Client-side validation for name
        if (!nameInput.value.trim()) {
            nameError.textContent = 'Tag name is required.';
            nameError.style.display = 'block';
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else if (nameInput.value.length > 50) {
            nameError.textContent = 'Tag name must be 50 characters or less.';
            nameError.style.display = 'block';
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            nameError.style.display = 'none';
            nameInput.classList.remove('is-invalid');
        }

        if (!isValid) {
            event.preventDefault();
            return;
        }

        // Confirmation prompt
        if (!confirm('Are you sure you want to update this tag?')) {
            event.preventDefault();
        }
    });

    // Clear error on input
    document.getElementById('name').addEventListener('input', function() {
        const nameError = document.getElementById('nameError');
        nameError.style.display = 'none';
        this.classList.remove('is-invalid');
    });
    </script>
</body>

</html>