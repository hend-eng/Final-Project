<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/products.php';

$basePath = '..';
$pageTitle = 'Checkout - SHOP.CO';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$items = [];
$subtotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $product = getProductById((string)$id);
    if (!$product) continue;
    $qty = max(1, (int)$qty);
    $lineTotal = productPrice($product) * $qty;
    $subtotal += $lineTotal;
    $items[] = ['product' => $product, 'quantity' => $qty, 'total' => $lineTotal];
}

// إذا كانت السلة فارغة
if (empty($items) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cart.php');
    exit;
}

$delivery = $items ? 15 : 0;
$total = $subtotal + $delivery;
$orderSuccess = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($items)) {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName  = trim($_POST['last_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $address   = trim($_POST['address'] ?? '');
    $city      = trim($_POST['city'] ?? '');
    $payment   = trim($_POST['payment_method'] ?? 'cod');

    $customerName = $firstName . ' ' . $lastName;
    $fullAddress  = $address . ', ' . $city;

    try {
        $pdo->beginTransaction();

        $stmtOrder = $pdo->prepare("
            INSERT INTO orders (customer_name, phone, address, payment_method, subtotal, delivery_fee, total, status, created_at)
            VALUES (:name, :phone, :address, :payment, :subtotal, :delivery, :total, 'pending', NOW())
        ");
        
        $stmtOrder->execute([
            ':name'     => $customerName,
            ':phone'    => $phone,
            ':address'  => $fullAddress,
            ':payment'  => $payment,
            ':subtotal' => $subtotal,
            ':delivery' => $delivery,
            ':total'    => $total
        ]);

        $orderId = $pdo->lastInsertId();

        $stmtItem = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, product_name, unit_price, quantity, subtotal)
            VALUES (:order_id, :product_id, :product_name, :unit_price, :quantity, :subtotal)
        ");

        $stmtUpdateStock = $pdo->prepare("
            UPDATE products SET stock = GREATEST(0, stock - :qty) WHERE id = :id
        ");

        foreach ($items as $item) {
            $p = $item['product'];
            $price = productPrice($p);

            $stmtItem->execute([
                ':order_id'     => $orderId,
                ':product_id'   => $p['id'],
                ':product_name' => $p['name'],
                ':unit_price'   => $price,
                ':quantity'     => $item['quantity'],
                ':subtotal'     => $item['total']
            ]);

            $stmtUpdateStock->execute([
                ':qty' => $item['quantity'],
                ':id'  => $p['id']
            ]);
        }

        $pdo->commit();
        $_SESSION['cart'] = []; 
        $orderSuccess = true;

    } catch (PDOException $e) {
        $pdo->rollBack();
$error = "Failed to place order. Please try again.";   
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/../shared/header.php'; ?>

<main class="py-5">
<div class="container">
<?php if ($orderSuccess): ?>
    <div class="text-center py-5">
        <i class="bi bi-check-circle-fill text-success display-1"></i>
        <h2 class="mt-3">Thank You For Your Order!</h2>
        <p class="text-muted">Your order has been placed successfully and saved.</p>
        <a href="products.php" class="btn btn-dark mt-3">Continue Shopping</a>
    </div>
<?php else: ?>
    <h1 class="cart-title mb-4">CHECKOUT</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card p-4 shadow-sm border-0 rounded-4">
                <h4 class="mb-3">Shipping Details</h4>
                <form method="post" action="checkout.php">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Street address, apartment, etc." required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="cod">Cash on Delivery</option>
                                <option value="card">Credit Card</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 mt-4 d-flex align-items-center justify-content-center gap-2 rounded-3 text-uppercase fw-bold" style="padding: 12px 20px; font-size: 15px;">
                        <span>Place Order</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="order-summary p-4 card border-0 shadow-sm rounded-4">
                <h4 class="mb-3">Order Summary</h4>
                <div class="mb-3">
                    <?php foreach ($items as $item): $p = $item['product']; ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="fw-bold"><?= htmlspecialchars($p['name']) ?></span>
                                <small class="text-muted d-block">Qty: <?= $item['quantity'] ?></small>
                            </div>
                            <span>$<?= number_format($item['total'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr>
                <div class="summary-row d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <strong>$<?= number_format($subtotal, 2) ?></strong>
                </div>
                <div class="summary-row d-flex justify-content-between mb-2">
                    <span>Delivery Fee</span>
                    <strong>$<?= number_format($delivery, 2) ?></strong>
                </div>
                <hr>
                <div class="summary-total d-flex justify-content-between fs-5 fw-bold">
                    <span>Total</span>
                    <strong>$<?= number_format($total, 2) ?></strong>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>
</main>

<?php require __DIR__ . '/../shared/footer.php'; ?>
</body>
</html>