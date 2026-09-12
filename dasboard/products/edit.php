<?php

require_once __DIR__ . '/../../config/db.php';


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];


// Get product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);

$product = $stmt->fetch();

if (!$product) {
    exit("Product not found");
}


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


if (isset($_POST['update_product'])) {

    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $brand_id = !empty($_POST['brand_id'])
        ? $_POST['brand_id']
        : null;

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

    if ($name === '') {

        $error = "Product name is required";

    } elseif (empty($category_id)) {

        $error = "Category is required";

    } elseif ($price === '' || $price < 0) {

        $error = "Valid price is required";

    } elseif ($description === '') {

        $error = "Description is required";

    } elseif ($stock === '' || $stock < 0) {

        $error = "Valid stock is required";

    } else {

        // Keep old image
        $imagePath = $product['main_image'];


        // Check if new image uploaded
        if (
            isset($_FILES['main_image']) &&
            $_FILES['main_image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

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


                $newImagePath =
                    $uploadDir . $imageName;


                if (move_uploaded_file(
                    $image['tmp_name'],
                    $newImagePath
                )) {

                    // Delete old image
                    if (!empty($product['main_image'])) {

                        $oldImagePath =
                            __DIR__ . '/../../' .
                            $product['main_image'];

                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }


                    $imagePath =
                        'assets/images/products/' . $imageName;

                } else {

                    $error = "Failed to upload image";

                }
            }
        }


        if (!isset($error)) {

            $sql = "UPDATE products SET

                        name = ?,
                        category_id = ?,
                        brand_id = ?,
                        style = ?,
                        gender = ?,
                        price = ?,
                        original_price = ?,
                        discount = ?,
                        rating = ?,
                        review_count = ?,
                        description = ?,
                        details = ?,
                        stock = ?,
                        main_image = ?,
                        colors = ?,
                        sizes = ?,
                        tags = ?

                    WHERE id = ?";


            $stmt = $pdo->prepare($sql);


            $stmt->execute([

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
                $imagePath,
                $colors,
                $sizes,
                $tags,
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

    <title>Edit Product</title>

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
        Edit Product
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
                class="form-control"
                value="<?= htmlspecialchars($product['id']) ?>"
                disabled
            >

        </div>


        <!-- Name -->

        <div class="mb-3">

            <label class="form-label">
                Product Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars($product['name']) ?>"
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

                <?php foreach ($categories as $category): ?>

                    <option
                        value="<?= $category['id'] ?>"
                        <?= $product['category_id'] == $category['id']
                            ? 'selected'
                            : '' ?>
                    >

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

                    <option
                        value="<?= $brand['id'] ?>"
                        <?= $product['brand_id'] == $brand['id']
                            ? 'selected'
                            : '' ?>
                    >

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
                value="<?= htmlspecialchars($product['style'] ?? '') ?>"
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

                <option
                    value="Men"
                    <?= $product['gender'] === 'Men'
                        ? 'selected'
                        : '' ?>
                >
                    Men
                </option>

                <option
                    value="Women"
                    <?= $product['gender'] === 'Women'
                        ? 'selected'
                        : '' ?>
                >
                    Women
                </option>

                <option
                    value="Unisex"
                    <?= $product['gender'] === 'Unisex'
                        ? 'selected'
                        : '' ?>
                >
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
                value="<?= htmlspecialchars($product['price']) ?>"
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
                value="<?= htmlspecialchars($product['original_price'] ?? '') ?>"
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
                value="<?= htmlspecialchars($product['discount']) ?>"
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
                value="<?= htmlspecialchars($product['rating']) ?>"
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
                value="<?= htmlspecialchars($product['review_count']) ?>"
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
            ><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

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
            ><?= htmlspecialchars($product['details'] ?? '') ?></textarea>

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
                value="<?= htmlspecialchars($product['stock']) ?>"
                required
            >

        </div>


        <!-- Current Image -->

        <div class="mb-3">

            <label class="form-label">
                Current Image
            </label>

            <br>

            <?php if (!empty($product['main_image'])): ?>

                <img
                    src="../../<?= htmlspecialchars($product['main_image']) ?>"
                    width="120"
                    height="120"
                    class="rounded"
                    style="object-fit: cover;"
                >

            <?php else: ?>

                <p>No Image</p>

            <?php endif; ?>

        </div>


        <!-- Change Image -->

        <div class="mb-3">

            <label class="form-label">
                Change Image
            </label>

            <input
                type="file"
                name="main_image"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <small class="text-muted">
                Leave empty to keep the current image.
            </small>

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
                value="<?= htmlspecialchars($product['colors'] ?? '') ?>"
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
                value="<?= htmlspecialchars($product['sizes'] ?? '') ?>"
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
                value="<?= htmlspecialchars($product['tags'] ?? '') ?>"
                placeholder="summer, casual, cotton"
            >

        </div>


        <button
            type="submit"
            name="update_product"
            class="btn btn-success"
        >
            Update Product
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