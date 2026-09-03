<?php
session_start();
require_once '../config/db.php'; 

$stmt = $pdo->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - SHOP.CO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: sans-serif; }
        .order-card { background: #fff; border-radius: 12px; border: 1px solid #eee; margin-bottom: 24px; padding: 20px; }
        .badge-pending { background-color: #ffeeb3; color: #8a6d3b; }
        .badge-completed { background-color: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Orders</h2>
        <a href="products.php" class="btn btn-outline-dark btn-sm">← Back to Shop</a>
    </div>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info text-center py-4">
            You haven't placed any orders yet.
        </div>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <div>
                        <h5 class="mb-1">Order #<?= $order['id'] ?></h5>
                        <small class="text-muted">Placed on: <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></small>
                    </div>
                    <div>
                        <span class="badge rounded-pill <?= $order['status'] == 'pending' ? 'badge-pending' : 'badge-completed' ?> px-3 py-2 fs-6">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </div>
                </div>

                <?php
                $stmtItems = $pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
                $stmtItems->execute([':order_id' => $order['id']]);
                $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="fw-semibold"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td>$<?= number_format($item['unit_price'], 2) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td class="text-end fw-bold">$<?= number_format($item['subtotal'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <div>
                        <small class="text-muted d-block">Payment Method: <strong><?= strtoupper($order['payment_method']) ?></strong></small>
                        <small class="text-muted d-block">Shipping Address: <?= htmlspecialchars($order['address']) ?></small>
                    </div>
                    <div class="text-end">
                        <span class="text-muted me-2">Total Amount:</span>
                        <span class="fs-4 fw-bold text-dark">$<?= number_format($order['total'], 2) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>