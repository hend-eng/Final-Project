<?php

require_once __DIR__ . '/../../config/db.php';

$search = $_GET['search'] ?? '';

if (!empty($search)) {

    $sql = "SELECT *
            FROM orders
            WHERE customer_name LIKE :search_customer
               OR phone LIKE :search_phone
               OR status LIKE :search_status
            ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);

    $searchValue = '%' . $search . '%';

    $stmt->execute([
        ':search_customer' => $searchValue,
        ':search_phone'    => $searchValue,
        ':search_status'   => $searchValue
    ]);

} else {

    $stmt = $pdo->query(
        "SELECT *
         FROM orders
         ORDER BY id DESC"
    );
}

$orders = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Orders</title>

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

        <h2>Orders</h2>

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
                placeholder="Search orders..."
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


    <!-- ORDERS TABLE -->
    <div class="table-responsive">

        <table class="table table-bordered table-hover text-center align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>

                    <th>Customer</th>

                    <th>Phone</th>

                    <th>Address</th>

                    <th>Payment</th>

                    <th>Subtotal</th>

                    <th>Delivery</th>

                    <th>Total</th>

                    <th>Status</th>

                    <th>Date</th>

                </tr>

            </thead>


            <tbody>

            <?php foreach ($orders as $order): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($order['id']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['customer_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['phone']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['address']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['payment_method']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['subtotal']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['delivery_fee']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['total']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['status']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($order['created_at']) ?>
                    </td>

                </tr>

            <?php endforeach; ?>


            <?php if (empty($orders)): ?>

                <tr>

                    <td
                        colspan="10"
                        class="text-muted"
                    >
                        No Orders Found
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>