<?php

require_once __DIR__ . '/../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM brands WHERE id = ?");
$stmt->execute([$id]);

$brand = $stmt->fetch();

if (!$brand) {
    exit("Brand not found");
}


if (isset($_POST['update_brand'])) {

    $name = trim($_POST['name']);
    $website = trim($_POST['website']);

    if ($name === '') {

        $error = "Brand name is required";

    } else {

        // Keep old logo by default
        $logoPath = $brand['logo'];


        // Check if user selected a new logo
        if (
            isset($_FILES['logo']) &&
            $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

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

                $newLogoPath = $uploadDir . $logoName;


                if (move_uploaded_file(
                    $logo['tmp_name'],
                    $newLogoPath
                )) {

                    // Delete old logo
                    if (!empty($brand['logo'])) {

                        $oldLogoPath =
                            __DIR__ . '/../../' . $brand['logo'];

                        if (file_exists($oldLogoPath)) {
                            unlink($oldLogoPath);
                        }
                    }


                    $logoPath =
                        'assets/images/brands/' . $logoName;

                } else {

                    $error = "Failed to upload logo";

                }
            }
        }


        if (!isset($error)) {

            $sql = "UPDATE brands
                    SET name = ?,
                        logo = ?,
                        website = ?
                    WHERE id = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $name,
                $logoPath,
                $website !== '' ? $website : null,
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

    <title>Edit Brand</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>
    <?php include('../dash-shared/sidebar.php'); ?>



<div class="container mt-5">

    <h2 class="mb-4">
        Edit Brand
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
                value="<?= htmlspecialchars($brand['name']) ?>"
                required
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Current Logo
            </label>

            <?php if (!empty($brand['logo'])): ?>

                <br>

                <img
                    src="../../<?= htmlspecialchars($brand['logo']) ?>"
                    width="120"
                    height="120"
                    class="rounded"
                    style="object-fit: contain;"
                >

            <?php else: ?>

                <p>No logo</p>

            <?php endif; ?>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Change Logo
            </label>

            <input
                type="file"
                name="logo"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <small class="text-muted">
                Leave empty to keep the current logo.
            </small>

        </div>


        


        <button
            type="submit"
            name="update_brand"
            class="btn btn-success"
        >
            Update Brand
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