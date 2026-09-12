<?php

require_once __DIR__ . '/../../config/db.php';


// Get category ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];


// Get category
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);

$category = $stmt->fetch();

if (!$category) {
    exit("Category not found");
}


// Update category
if (isset($_POST['update_category'])) {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);


    // Validate name
    if ($name === '') {

        $error = "Category name is required";

    // Validate description
    } elseif ($description === '') {

        $error = "Description is required";

    } else {

        // Keep old image
        $imagePath = $category['image'];


        // Check if user uploaded a new image
        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            $image = $_FILES['image'];

            $allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            // Check image type
            if (!in_array($image['type'], $allowedTypes)) {

                $error = "Only JPG, PNG and WEBP images are allowed";

            } elseif ($image['error'] !== UPLOAD_ERR_OK) {

                $error = "There was an error uploading the image";

            } else {

                // Upload folder
                $uploadDir = __DIR__ . '/../../assets/images/categories/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }


                // Create new image name
                $extension = pathinfo(
                    $image['name'],
                    PATHINFO_EXTENSION
                );

                $imageName = uniqid('category_', true) . '.' . $extension;

                $newImagePath = $uploadDir . $imageName;


                // Move uploaded image
                if (move_uploaded_file(
                    $image['tmp_name'],
                    $newImagePath
                )) {

                    // Delete old image if it exists
                    if (!empty($category['image'])) {

                        $oldImagePath =
                            __DIR__ . '/../../' . $category['image'];

                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }


                    // Save new path
                    $imagePath =
                        'assets/images/categories/' . $imageName;

                } else {

                    $error = "Failed to upload image";
                }
            }
        }


        // Update database
        if (!isset($error)) {

            $sql = "UPDATE categories
                    SET name = ?,
                        image = ?,
                        description = ?
                    WHERE id = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $name,
                $imagePath,
                $description,
                $id
            ]);


            header("Location: index.php");
            exit;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Category</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
<link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>


<body>
<?php include('../dash-shared/sidebar.php'); ?>


<div class="container mt-5">

    <h2 class="mb-4">
        Edit Category
    </h2>


    <?php if (isset($error)): ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <form
        method="POST"
        enctype="multipart/form-data"
    >


        <!-- Category Name -->

        <div class="mb-3">

            <label class="form-label">
                Category Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars($category['name']) ?>"
                required
            >

        </div>


        <!-- Current Image -->

        <div class="mb-3">

            <label class="form-label">
                Current Image
            </label>

            <?php if (!empty($category['image'])): ?>

                <br>

                <img
                    src="../../<?= htmlspecialchars($category['image']) ?>"
                    width="120"
                    height="120"
                    class="rounded"
                    style="object-fit: cover;"
                >

            <?php else: ?>

                <p>No image</p>

            <?php endif; ?>

        </div>


        <!-- New Image -->

        <div class="mb-3">

            <label class="form-label">
                Change Image
            </label>

            <input
                type="file"
                name="image"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <small class="text-muted">
                Leave empty to keep the current image.
            </small>

        </div>


        <!-- Description -->

        <div class="mb-3">

            <label class="form-label">
                Description
            </label>

            <textarea
                name="description"
                class="form-control"
                rows="4"
                required
            ><?= htmlspecialchars($category['description'] ?? '') ?></textarea>

        </div>


        <button
            type="submit"
            name="update_category"
            class="btn btn-success"
        >
            Update Category
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