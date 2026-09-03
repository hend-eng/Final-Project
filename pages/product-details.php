<?php
require_once __DIR__ . '/../config/products.php';

$id = trim($_GET['id'] ?? '');
$product = getProductById($id);

if (!$product) {
    http_response_code(404);
    $pageTitle = 'Product Not Found - SHOP.CO';
} else {
    $pageTitle = ($product['name'] ?? 'Product') . ' - SHOP.CO';
}
$basePath = '..';
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
<section class="product-breadcrumb"><div class="container">
<a href="../index.php">Home</a><i class="bi bi-chevron-right"></i>
<a href="products.php">Shop</a><i class="bi bi-chevron-right"></i>
<span><?= htmlspecialchars($product['name'] ?? 'Product') ?></span>
</div></section>

<?php if (!$product): ?>
<section class="container py-5"><div class="alert alert-warning">Product not found.</div><a class="btn btn-dark" href="products.php">Back to Shop</a></section>
<?php else: ?>
<section class="product-details"><div class="container"><div class="row g-4">
<div class="col-12 col-lg-7">
<div class="row g-3">
<div class="col-3"><div class="product-thumbnails">
<?php foreach (($product['images'] ?? []) as $image): ?>
<img src="../<?= htmlspecialchars('assets/images/products/'.basename($image)) ?>" class="img-fluid mb-2" alt="<?= htmlspecialchars($product['name']) ?>">
<?php endforeach; ?>
</div></div>
<div class="col-9"><div class="product-main-image">
<img src="../<?= htmlspecialchars(productImage($product)) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
</div></div>
</div></div>

<div class="col-12 col-lg-5"><div class="product-info">
<h1><?= htmlspecialchars($product['name']) ?></h1>
<div class="product-rating">
<span class="rating-stars"><?php for($i=1;$i<=5;$i++): ?><i class="bi <?= $i <= round((float)($product['rating']??0)) ? 'bi-star-fill' : 'bi-star' ?>"></i><?php endfor; ?></span>
<span><?= htmlspecialchars((string)($product['rating']??0)) ?>/5</span>
</div>
<div class="product-price"><strong>$<?= number_format(productPrice($product),2) ?></strong>
<?php if(($o=productOriginalPrice($product))!==null): ?><span>$<?= number_format($o,2) ?></span><?php endif; ?>
<?php if(isset($product['discount'])): ?><span><?= htmlspecialchars((string)$product['discount']) ?>% OFF</span><?php endif; ?></div>
<p><?= htmlspecialchars($product['description'] ?? '') ?></p>
<?php if(!empty($product['details'])): ?><p><?= htmlspecialchars($product['details']) ?></p><?php endif; ?>
<hr>

<?php if(!empty($product['colors'])): ?><div class="product-option"><h3>Choose Color</h3><div class="color-options">
<?php foreach($product['colors'] as $color): ?><span class="badge text-bg-light border"><?= htmlspecialchars($color['name'] ?? '') ?></span><?php endforeach; ?>
</div></div><hr><?php endif; ?>

<?php if(!empty($product['sizes'])): ?><div class="product-option"><h3>Choose Size</h3><div class="size-options">
<?php foreach($product['sizes'] as $size): ?><span class="badge text-bg-light border"><?= htmlspecialchars($size) ?></span><?php endforeach; ?>
</div></div><hr><?php endif; ?>

<form method="post" action="cart.php">
<input type="hidden" name="action" value="add">
<input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
<div class="product-actions">
<label for="quantity" class="visually-hidden">Quantity</label>
<input id="quantity" type="number" name="quantity" value="1" min="1" max="<?= max(1,(int)($product['stock']??1)) ?>" class="form-control" style="max-width:100px">
<button type="submit" class="btn btn-dark add-cart-button">Add to Cart</button>
</div>
</form>
</div></div>
</div></div></section>
<?php endif; ?>
</main>

<?php require __DIR__ . '/../shared/footer.php'; ?>
</body></html>