
<?php

require_once __DIR__ . '/../../config/db.php';

$search = $_GET['search'] ?? '';

if (!empty($search)) {

    $sql = "SELECT *
            FROM brands
            WHERE name LIKE :search_name
            ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':search_name' => '%' . $search . '%'
    ]);

} else {

    $stmt = $pdo->query(
        "SELECT * FROM brands ORDER BY id DESC"
    );
}

$brands = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Brands</title>

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

        <h2>Brands</h2>

        <a
            href="add.php"
            class="btn btn-primary"
        >
            Add Brand
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
                placeholder="Search brands..."
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


    <!-- ================= BRANDS TABLE ================= -->

    <table class="table table-bordered table-hover text-center align-middle">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Logo</th>

                <th>Actions</th>

            </tr>

        </thead>


        <tbody>


        <?php foreach ($brands as $brand): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($brand['id']) ?>
                </td>


                <td>
                    <?= htmlspecialchars($brand['name']) ?>
                </td>


                <td>

                    <?php if (!empty($brand['logo'])): ?>

                        <img
                            src="../../<?= htmlspecialchars($brand['logo']) ?>"
                            width="80"
                            height="80"
                            class="rounded"
                            style="object-fit: contain;"
                        >

                    <?php else: ?>

                        No Logo

                    <?php endif; ?>

                </td>


                <td>

                    <a
                        href="edit.php?id=<?= urlencode($brand['id']) ?>"
                        class="btn btn-warning btn-sm"
                    >
                        Edit
                    </a>


                    <a
                        href="delete.php?id=<?= urlencode($brand['id']) ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this brand?')"
                    >
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>


        <?php if (empty($brands)): ?>

            <tr>

                <td
                    colspan="4"
                    class="text-muted"
                >
                    No Brands Found
                </td>

            </tr>

        <?php endif; ?>


        </tbody>

    </table>

</div>


</body>

</html>

