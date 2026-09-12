<?php

require_once __DIR__ . '/../../config/db.php';

if (isset($_POST['add_brand'])) {

    $name = trim($_POST['name']);
    $website = trim($_POST['website']);

    if ($name === '') {

        $error = "Brand name is required";

    } elseif (!isset($_FILES['logo']) || $_FILES['logo']['error'] === UPLOAD_ERR_NO_FILE) {

        $error = "Logo is required";

    } else {

        $logo = $_FILES['logo'];

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!in_array($logo['type'], $allowedTypes)) {

            $error = "Only JPG, PNG and WEBP images are allowed";

        } elseif ($logo['error'] !== UPLOAD_ERR_OK) {

            $error = "There was an error uploading the logo";

        } else {

            $uploadDir = __DIR__ . '/../../assets/images/brands/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $extension = pathinfo(
                $logo['name'],
                PATHINFO_EXTENSION
            );

            $logoName = uniqid('brand_', true) . '.' . $extension;

            $logoPath = $uploadDir . $logoName;

            if (move_uploaded_file($logo['tmp_name'], $logoPath)) {

                $dbLogoPath = 'assets/images/brands/' . $logoName;

                $sql = "INSERT INTO brands (name, logo, website)
                        VALUES (?, ?, ?)";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    $name,
                    $dbLogoPath,
                    $website !== '' ? $website : null
                ]);

                header("Location: index.php");
                exit;

            } else {

                $error = "Failed to upload logo";

            }
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

    <title>Add Brand</title>

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
        Add Brand
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

        <div class="mb-3">

            <label class="form-label">
                Brand Name
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
                Brand Logo
            </label>

            <input
                type="file"
                name="logo"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp"
                required
            >

        </div>


        


        <button
            type="submit"
            name="add_brand"
            class="btn btn-primary"
        >
            Add Brand
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