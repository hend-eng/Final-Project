<?php

require_once __DIR__ . '/../../config/db.php';

$search = $_GET['search'] ?? '';

if (!empty($search)) {

    $sql = "SELECT id, full_name, email, role
            FROM users
            WHERE role = 'customer'
              AND (full_name LIKE :search_name
                   OR email LIKE :search_email)
            ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);

    $searchValue = '%' . $search . '%';

    $stmt->execute([
        ':search_name'  => $searchValue,
        ':search_email' => $searchValue
    ]);

} else {

    $stmt = $pdo->query(
        "SELECT id, full_name, email, role
         FROM users
         WHERE role = 'customer'
         ORDER BY id DESC"
    );
}

$clients = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Clients</title>

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

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Clients</h2>

    </div>


    <!-- SEARCH -->
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
                placeholder="Search clients..."
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


    <!-- CLIENTS TABLE -->
    <table class="table table-bordered table-hover text-center align-middle">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Email</th>

                <th>Role</th>

            </tr>

        </thead>


        <tbody>

        <?php foreach ($clients as $client): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($client['id']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($client['full_name']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($client['email']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($client['role']) ?>
                </td>

            </tr>

        <?php endforeach; ?>


        <?php if (empty($clients)): ?>

            <tr>

                <td
                    colspan="4"
                    class="text-muted"
                >
                    No Clients Found
                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>

</html>