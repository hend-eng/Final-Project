<?php

require_once __DIR__ . '/../../config/db.php';

if (isset($_POST['add_category'])) {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    // Check name and description
    if ($name === '') {
        $error = "Category name is required";
    } elseif ($description === '') {
        $error = "Description is required";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $error = "Image is required";
    } else {

        $image = $_FILES['image'];

        // Allowed image types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($image['type'], $allowedTypes)) {

            $error = "Only JPG, PNG and WEBP images are allowed";

        } elseif ($image['error'] !== UPLOAD_ERR_OK) {

            $error = "There was an error uploading the image";

        } else {

            // Create upload folder if it doesn't exist
            $uploadDir = __DIR__ . '/../../assets/images/categories/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Create unique image name
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('category_', true) . '.' . $extension;

            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {

                // Path saved in database
                $dbImagePath = 'assets/images/categories/' . $imageName;

                $sql = "INSERT INTO categories (name, image, description)
                        VALUES (?, ?, ?)";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    $name,
                    $dbImagePath,
                    $description
                ]);

                header("Location: index.php");
                exit;

            } else {

                $error = "Failed to upload image";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Category</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

</head>

<body>
    <?php include('../dash-shared/sidebar.php'); ?>

   

<div class="container mt-5">

    <h2 class="mb-4">Add Category</h2>

    <?php if (isset($error)): ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">

            <label class="form-label">
                Category Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                required
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Category Image
            </label>

            <input
                type="file"
                name="image"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp"
                required
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Description
            </label>

            <textarea
                name="description"
                class="form-control"
                rows="4"
                required
            ></textarea>

        </div>


        <button
            type="submit"
            name="add_category"
            class="btn btn-primary"
        >
            Add Category
        </button>


        <a
            href="index.php"
            class="btn btn-secondary"
        >
            Back
        </a>

    </form>

</div>

</body>

</html>