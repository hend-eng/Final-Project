
<?php

require_once __DIR__ . '/../../config/db.php';

$search = $_GET['search'] ?? '';

if (!empty($search)) {

    $sql = "SELECT 
                products.*,
                categories.name AS category_name,
                brands.name AS brand_name
            FROM products

            INNER JOIN categories
                ON products.category_id = categories.id

            LEFT JOIN brands
                ON products.brand_id = brands.id

            WHERE products.name LIKE :search_product
               OR categories.name LIKE :search_category
               OR brands.name LIKE :search_brand

            ORDER BY products.created_at DESC";

    $stmt = $pdo->prepare($sql);

    $searchValue = '%' . $search . '%';

    $stmt->execute([
        ':search_product'  => $searchValue,
        ':search_category' => $searchValue,
        ':search_brand'    => $searchValue
    ]);

} else {

    $sql = "SELECT 
                products.*,
                categories.name AS category_name,
                brands.name AS brand_name
            FROM products

            INNER JOIN categories
                ON products.category_id = categories.id

            LEFT JOIN brands
                ON products.brand_id = brands.id

            ORDER BY products.created_at DESC";

    $stmt = $pdo->query($sql);
}

$products = $stmt->fetchAll();

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Products</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="../../assets/css/dashboard.css"
    >

</head>

<body>

<?php include('../dash-shared/sidebar.php'); ?>


<div class="container mt-5">

    <!-- ================= HEADER ================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Products</h2>

        <a
            href="add.php"
            class="btn btn-primary"
        >
            Add Product
        </a>

    </div>


    <!-- ================= SEARCH ================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <form
            action=""
            method="GET"
            class="d-flex gap-2"
        >

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search products..."
                value="<?= htmlspecialchars($search) ?>"
            >

            <button
                type="submit"
                class="btn btn-primary"
            >
                Search
            </button>

            <a
                href="index.php"
                class="btn btn-secondary"
            >
                Show All
            </a>

        </form>

    </div>


    <!-- ================= PRODUCTS TABLE ================= -->

    <table class="table table-bordered table-hover text-center align-middle">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Category</th>

                <th>Brand</th>

                <th>Price</th>

                <th>Stock</th>

                <th>Image</th>

                <th>Actions</th>

            </tr>

        </thead>


        <tbody>

        <?php foreach ($products as $product): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($product['id']) ?>
                </td>


                <td>
                    <?= htmlspecialchars($product['name']) ?>
                </td>


                <td>
                    <?= htmlspecialchars($product['category_name']) ?>
                </td>


                <td>

                    <?php if (!empty($product['brand_name'])): ?>

                        <?= htmlspecialchars($product['brand_name']) ?>

                    <?php else: ?>

                        No Brand

                    <?php endif; ?>

                </td>


                <td>
                    <?= htmlspecialchars($product['price']) ?>
                </td>


                <td>
                    <?= htmlspecialchars($product['stock']) ?>
                </td>


                <td>

                    <?php if (!empty($product['main_image'])): ?>

                        <img
                            src="../../<?= htmlspecialchars($product['main_image']) ?>"
                            width="80"
                            height="80"
                            class="rounded"
                            style="object-fit: cover;"
                        >

                    <?php else: ?>

                        No Image

                    <?php endif; ?>

                </td>


                <td>

                    <a
                        href="edit.php?id=<?= urlencode($product['id']) ?>"
                        class="btn btn-warning btn-sm"
                    >
                        Edit
                    </a>


                    <a
                        href="delete.php?id=<?= urlencode($product['id']) ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this product?')"
                    >
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>


        <?php if (empty($products)): ?>

            <tr>

                <td
                    colspan="8"
                    class="text-muted"
                >
                    No Products Found
                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>

</html>

