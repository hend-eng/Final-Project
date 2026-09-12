
<?php

require_once __DIR__ . '/../../config/db.php';

$search = $_GET['search'] ?? '';

if (!empty($search)) {

    $sql = "SELECT *
            FROM categories
            WHERE name LIKE :search_name
               OR description LIKE :search_description
            ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);

    $searchValue = '%' . $search . '%';

    $stmt->execute([
        ':search_name' => $searchValue,
        ':search_description' => $searchValue
    ]);

} else {

    $stmt = $pdo->query(
        "SELECT * FROM categories ORDER BY id DESC"
    );
}

$categories = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Categories</title>

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

        <h2>Categories</h2>

        <a
            href="add.php"
            class="btn btn-primary"
        >
            Add Category
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
                placeholder="Search categories..."
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


    <!-- ================= CATEGORIES TABLE ================= -->

    <table class="table table-bordered table-hover text-center align-middle">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Image</th>

                <th>Description</th>

                <th>Actions</th>

            </tr>

        </thead>


        <tbody>


        <?php foreach ($categories as $category): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($category['id']) ?>
                </td>


                <td>
                    <?= htmlspecialchars($category['name']) ?>
                </td>


                <td>

                    <?php if (!empty($category['image'])): ?>

                        <img
                            src="../../<?= htmlspecialchars($category['image']) ?>"
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
                    <?= htmlspecialchars($category['description'] ?? '') ?>
                </td>


                <td>

                    <a
                        href="edit.php?id=<?= urlencode($category['id']) ?>"
                        class="btn btn-warning btn-sm"
                    >
                        Edit
                    </a>


                    <a
                        href="delete.php?id=<?= urlencode($category['id']) ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this category?')"
                    >
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>


        <?php if (empty($categories)): ?>

            <tr>

                <td
                    colspan="5"
                    class="text-muted"
                >
                    No Categories Found
                </td>

            </tr>

        <?php endif; ?>


        </tbody>

    </table>

</div>


</body>

</html>

