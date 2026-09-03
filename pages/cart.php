<?php
session_start();
require_once __DIR__ . '/../config/products.php';

$basePath = '..';
$pageTitle = 'Cart - SHOP.CO';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = trim($_POST['product_id'] ?? '');

    if ($action === 'add' && $id !== '') {
        $product = getProductById($id);
        if ($product) {
            $qty = max(1, (int)($_POST['quantity'] ?? 1));
            $stock = max(1, (int)($product['stock'] ?? 999));
            $_SESSION['cart'][$id] = min($stock, ($_SESSION['cart'][$id] ?? 0) + $qty);
        }
        header('Location: cart.php');
        exit;
    } elseif ($action === 'update') {
        foreach ($_POST['quantities'] ?? [] as $productId => $quantity) {
            if (getProductById((string)$productId)) {
                $quantity = (int)$quantity;
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$productId]);
                } else {
                    $_SESSION['cart'][$productId] = $quantity;
                }
            }
        }
        header('Location: cart.php');
        exit;
    } elseif ($action === 'remove' && $id !== '') {
        unset($_SESSION['cart'][$id]);
        header('Location: cart.php');
        exit;
    }
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
$delivery = $items ? 15 : 0;
$total = $subtotal + $delivery;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/../shared/header.php'; ?>

<main>
<section class="cart-breadcrumb"><div class="container"><a href="../index.php">Home</a><i class="bi bi-chevron-right"></i><span>Cart</span></div></section>
<section class="cart-section"><div class="container"><h1 class="cart-title">YOUR CART</h1>
<?php if (!$items): ?>
<div class="empty-cart"><i class="bi bi-cart-x"></i><h2>Your cart is empty</h2><p>Looks like you haven't added anything to your cart yet.</p><a href="products.php" class="btn btn-dark">Continue Shopping</a></div>
<?php else: ?>
<div class="row g-4">
<div class="col-12 col-lg-7">
<form method="post" id="cart-form">
<input type="hidden" name="action" value="update">
<div class="cart-items">
<?php foreach($items as $item): $p=$item['product']; ?>
<div class="cart-item d-flex gap-3 align-items-center justify-content-between border-bottom py-3">
    <div class="d-flex gap-3 align-items-center">
        <img src="../<?= htmlspecialchars(productImage($p)) ?>" alt="<?= htmlspecialchars($p['name']) ?>" width="100">
        <div>
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <p class="mb-1">$<?= number_format(productPrice($p),2) ?></p>
            <label>Quantity <input type="number" min="0" name="quantities[<?= htmlspecialchars($p['id']) ?>]" value="<?= $item['quantity'] ?>" class="form-control" style="max-width:90px"></label>
        </div>
    </div>

    <div class="d-flex flex-column align-items-end justify-content-between h-100 py-1" style="min-height: 100px;">
        <button type="submit" form="remove-form-<?= htmlspecialchars($p['id']) ?>" class="btn btn-link text-danger p-0 border-0 mb-3" title="Remove Item">
            <i class="bi bi-trash3-fill fs-5"></i>
        </button>
        <strong>$<?= number_format($item['total'],2) ?></strong>
    </div>
</div>
<?php endforeach; ?>
</div>
<button class="btn btn-outline-dark mt-3" type="submit">Update Cart</button>
</form>

<?php foreach($items as $item): $p=$item['product']; ?>
<form method="post" id="remove-form-<?= htmlspecialchars($p['id']) ?>" style="display:none;">
    <input type="hidden" name="action" value="remove">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($p['id']) ?>">
</form>
<?php endforeach; ?>

</div>

<div class="col-12 col-lg-5"><div class="order-summary"><h2>Order Summary</h2>
<div class="summary-row"><span>Subtotal</span><strong>$<?= number_format($subtotal,2) ?></strong></div>
<div class="summary-row"><span>Delivery Fee</span><strong>$<?= number_format($delivery,2) ?></strong></div><hr>
<div class="summary-total"><span>Total</span><strong>$<?= number_format($total,2) ?></strong></div>
<a href="checkout.php" class="btn btn-dark w-100 mt-3 d-flex align-items-center justify-content-center gap-2 rounded-pill py-3 fw-bold" style="font-size: 15px; letter-spacing: 0.5px;">
    <span>Go to Checkout</span>
    <i class="bi bi-arrow-right fs-5"></i>
</a></div></div></div>
<?php endif; ?>
</div></section></main>

<?php require __DIR__ . '/../shared/footer.php'; ?>
</body></html>