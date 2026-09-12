<?php

require_once __DIR__ . '/../../config/db.php';


// Get categories
$categoriesStmt = $pdo->query(
    "SELECT * FROM categories ORDER BY name ASC"
);

$categories = $categoriesStmt->fetchAll();


// Get brands
$brandsStmt = $pdo->query(
    "SELECT * FROM brands ORDER BY name ASC"
);

$brands = $brandsStmt->fetchAll();


if (isset($_POST['add_product'])) {

    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $brand_id = !empty($_POST['brand_id']) ? $_POST['brand_id'] : null;
    $style = trim($_POST['style']);
    $gender = trim($_POST['gender']);
    $price = $_POST['price'];
    $original_price = !empty($_POST['original_price'])
        ? $_POST['original_price']
        : null;
    $discount = !empty($_POST['discount'])
        ? $_POST['discount']
        : 0;
    $rating = !empty($_POST['rating'])
        ? $_POST['rating']
        : 0;
    $review_count = !empty($_POST['review_count'])
        ? $_POST['review_count']
        : 0;
    $description = trim($_POST['description']);
    $details = trim($_POST['details']);
    $stock = $_POST['stock'];
    $colors = trim($_POST['colors']);
    $sizes = trim($_POST['sizes']);
    $tags = trim($_POST['tags']);


    // Validation
    if ($id === '') {

        $error = "Product ID is required";

    } elseif ($name === '') {

        $error = "Product name is required";

    } elseif (empty($category_id)) {

        $error = "Category is required";

    } elseif ($price === '' || $price < 0) {

        $error = "Valid price is required";

    } elseif ($description === '') {

        $error = "Description is required";

    } elseif ($stock === '' || $stock < 0) {

        $error = "Valid stock is required";

    } elseif (
        !isset($_FILES['main_image']) ||
        $_FILES['main_image']['error'] === UPLOAD_ERR_NO_FILE
    ) {

        $error = "Product image is required";

    } else {

        $image = $_FILES['main_image'];

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];


        if (!in_array($image['type'], $allowedTypes)) {

            $error = "Only JPG, PNG and WEBP images are allowed";

        } elseif ($image['error'] !== UPLOAD_ERR_OK) {

            $error = "There was an error uploading the image";

        } else {

            $uploadDir =
                __DIR__ . '/../../assets/images/products/';


            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }


            $extension = pathinfo(
                $image['name'],
                PATHINFO_EXTENSION
            );


            $imageName =
                uniqid('product_', true) . '.' . $extension;


            $imagePath =
                $uploadDir . $imageName;


            if (move_uploaded_file(
                $image['tmp_name'],
                $imagePath
            )) {

                $dbImagePath =
                    'assets/images/products/' . $imageName;


                try {

                    $sql = "INSERT INTO products (
                                id,
                                name,
                                category_id,
                                brand_id,
                                style,
                                gender,
                                price,
                                original_price,
                                discount,
                                rating,
                                review_count,
                                description,
                                details,
                                stock,
                                main_image,
                                colors,
                                sizes,
                                tags
                            )

                            VALUES (
                                ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                ?, ?, ?, ?, ?, ?, ?, ?, ?
                            )";


                    $stmt = $pdo->prepare($sql);


                    $stmt->execute([
                        $id,
                        $name,
                        $category_id,
                        $brand_id,
                        $style,
                        $gender,
                        $price,
                        $original_price,
                        $discount,
                        $rating,
                        $review_count,
                        $description,
                        $details,
                        $stock,
                        $dbImagePath,
                        $colors,
                        $sizes,
                        $tags
                    ]);


                    header("Location: index.php");
                    exit;


                } catch (PDOException $e) {

                    // Delete uploaded image if database insert fails
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }

                    $error = "Failed to add product. Product ID may already exist.";

                }

            } else {

                $error = "Failed to upload product image";

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

    <title>Add Product</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
<link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>

<body>
<?php include('../dash-shared/sidebar.php'); ?>

  
<div class="container mt-5 mb-5">

    <h2 class="mb-4">
        Add Product
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


        <!-- Product ID -->

        <div class="mb-3">

            <label class="form-label">
                Product ID
            </label>

            <input
                type="text"
                name="id"
                class="form-control"
                required
            >

        </div>


        <!-- Product Name -->

        <div class="mb-3">

            <label class="form-label">
                Product Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                required
            >

        </div>


        <!-- Category -->

        <div class="mb-3">

            <label class="form-label">
                Category
            </label>

            <select
                name="category_id"
                class="form-select"
                required
            >

                <option value="">
                    Select Category
                </option>

                <?php foreach ($categories as $category): ?>

                    <option value="<?= $category['id'] ?>">

                        <?= htmlspecialchars($category['name']) ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- Brand -->

        <div class="mb-3">

            <label class="form-label">
                Brand
            </label>

            <select
                name="brand_id"
                class="form-select"
            >

                <option value="">
                    No Brand
                </option>

                <?php foreach ($brands as $brand): ?>

                    <option value="<?= $brand['id'] ?>">

                        <?= htmlspecialchars($brand['name']) ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- Style -->

        <div class="mb-3">

            <label class="form-label">
                Style
            </label>

            <input
                type="text"
                name="style"
                class="form-control"
            >

        </div>


        <!-- Gender -->

        <div class="mb-3">

            <label class="form-label">
                Gender
            </label>

            <select
                name="gender"
                class="form-select"
            >

                <option value="">
                    Select Gender
                </option>

                <option value="Men">
                    Men
                </option>

                <option value="Women">
                    Women
                </option>

                <option value="Unisex">
                    Unisex
                </option>

            </select>

        </div>


        <!-- Price -->

        <div class="mb-3">

            <label class="form-label">
                Price
            </label>

            <input
                type="number"
                name="price"
                class="form-control"
                step="0.01"
                min="0"
                required
            >

        </div>


        <!-- Original Price -->

        <div class="mb-3">

            <label class="form-label">
                Original Price
            </label>

            <input
                type="number"
                name="original_price"
                class="form-control"
                step="0.01"
                min="0"
            >

        </div>


        <!-- Discount -->

        <div class="mb-3">

            <label class="form-label">
                Discount
            </label>

            <input
                type="number"
                name="discount"
                class="form-control"
                step="0.01"
                min="0"
            >

        </div>


        <!-- Rating -->

        <div class="mb-3">

            <label class="form-label">
                Rating
            </label>

            <input
                type="number"
                name="rating"
                class="form-control"
                step="0.1"
                min="0"
                max="5"
                value="0"
            >

        </div>


        <!-- Review Count -->

        <div class="mb-3">

            <label class="form-label">
                Review Count
            </label>

            <input
                type="number"
                name="review_count"
                class="form-control"
                min="0"
                value="0"
            >

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
            ></textarea>

        </div>


        <!-- Details -->

        <div class="mb-3">

            <label class="form-label">
                Details
            </label>

            <textarea
                name="details"
                class="form-control"
                rows="4"
            ></textarea>

        </div>


        <!-- Stock -->

        <div class="mb-3">

            <label class="form-label">
                Stock
            </label>

            <input
                type="number"
                name="stock"
                class="form-control"
                min="0"
                required
            >

        </div>


        <!-- Image -->

        <div class="mb-3">

            <label class="form-label">
                Product Image
            </label>

            <input
                type="file"
                name="main_image"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp"
                required
            >

        </div>


        <!-- Colors -->

        <div class="mb-3">

            <label class="form-label">
                Colors
            </label>

            <input
                type="text"
                name="colors"
                class="form-control"
                placeholder="Black, White, Red"
            >

        </div>


        <!-- Sizes -->

        <div class="mb-3">

            <label class="form-label">
                Sizes
            </label>

            <input
                type="text"
                name="sizes"
                class="form-control"
                placeholder="S, M, L, XL"
            >

        </div>


        <!-- Tags -->

        <div class="mb-3">

            <label class="form-label">
                Tags
            </label>

            <input
                type="text"
                name="tags"
                class="form-control"
                placeholder="summer, casual, cotton"
            >

        </div>


        <button
            type="submit"
            name="add_product"
            class="btn btn-primary"
        >
            Add Product
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