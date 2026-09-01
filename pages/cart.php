<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$basePath = '..';
$pageTitle = 'Cart - SHOP.CO';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = trim($_POST['product_id'] ?? '');

    if ($action === 'add') {
        $product = getProductById($id);
        if ($product) {
            $qty = max(1, (int)($_POST['quantity'] ?? 1));
            $stock = max(1, (int)($product['stock'] ?? 999));
            $_SESSION['cart'][$id] = min($stock, ($_SESSION['cart'][$id] ?? 0) + $qty);
        }
    } elseif ($action === 'update') {
        foreach ($_POST['quantities'] ?? [] as $productId => $quantity) {
            if (getProductById((string)$productId)) {
                $quantity = (int)$quantity;
                if ($quantity <= 0) unset($_SESSION['cart'][$productId]);
                else $_SESSION['cart'][$productId] = $quantity;
            }
        }
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$id]);
    }

    header('Location: cart.php');
    exit;
}

$items = [];
$subtotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $product = getProductById((string)$id);
    if (!$product) continue;
    $qty = max(1, (int)$qty);
    $lineTotal = productPrice($product) * $qty;
    $subtotal += $lineTotal;
    $items[] = ['product'=>$product, 'quantity'=>$qty, 'total'=>$lineTotal];
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
<form method="post"><input type="hidden" name="action" value="update">
<div class="row g-4">
<div class="col-12 col-lg-7"><div class="cart-items">
<?php foreach($items as $item): $p=$item['product']; ?>
<div class="cart-item d-flex gap-3 align-items-center border-bottom py-3">
<img src="../<?= htmlspecialchars(productImage($p)) ?>" alt="<?= htmlspecialchars($p['name']) ?>" width="100">
<div class="flex-grow-1"><h3><?= htmlspecialchars($p['name']) ?></h3><p class="mb-1">$<?= number_format(productPrice($p),2) ?></p>
<label>Quantity <input type="number" min="0" name="quantities[<?= htmlspecialchars($p['id']) ?>]" value="<?= $item['quantity'] ?>" class="form-control" style="max-width:90px"></label></div>
<strong>$<?= number_format($item['total'],2) ?></strong>
</div>
<?php endforeach; ?>
</div><button class="btn btn-outline-dark mt-3" type="submit">Update Cart</button></div>

<div class="col-12 col-lg-5"><div class="order-summary"><h2>Order Summary</h2>
<div class="summary-row"><span>Subtotal</span><strong>$<?= number_format($subtotal,2) ?></strong></div>
<div class="summary-row"><span>Delivery Fee</span><strong>$<?= number_format($delivery,2) ?></strong></div><hr>
<div class="summary-total"><span>Total</span><strong>$<?= number_format($total,2) ?></strong></div>
<a href="checkout.php" class="btn btn-dark checkout-button w-100 mt-3">Go to Checkout <i class="bi bi-arrow-right"></i></a>
</div></div></div>
</form>
<?php endif; ?>
</div></section></main>

<?php require __DIR__ . '/../shared/footer.php'; ?>
</body></html>
