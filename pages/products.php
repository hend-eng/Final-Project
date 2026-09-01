<?php
require_once __DIR__ . '/../config/products.php';
$basePath = '..';
$pageTitle = 'Shop - SHOP.CO';

$allProducts = getProducts();
$category = trim($_GET['category'] ?? '');
$style = trim($_GET['style'] ?? '');
$tag = trim($_GET['tag'] ?? '');
$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'popular';

$filtered = array_values(array_filter($allProducts, function ($product) use ($category, $style, $tag, $search) {
    if ($category !== '' && strcasecmp($product['category'] ?? '', $category) !== 0) return false;
    if ($style !== '' && strcasecmp($product['style'] ?? '', $style) !== 0) return false;
    if ($tag !== '' && !in_array($tag, $product['tags'] ?? [], true)) return false;
    if ($search !== '') {
        $haystack = strtolower(($product['name'] ?? '').' '.($product['description'] ?? '').' '.($product['category'] ?? ''));
        if (strpos($haystack, strtolower($search)) === false) return false;
    }
    return true;
}));
if ($sort === 'price-low') usort($filtered, fn($a,$b)=>productPrice($a)<=>productPrice($b));
elseif ($sort === 'price-high') usort($filtered, fn($a,$b)=>productPrice($b)<=>productPrice($a));
elseif ($sort === 'rating') usort($filtered, fn($a,$b)=>(float)($b['rating']??0)<=>(float)($a['rating']??0));

$categories = $styles = [];
foreach ($allProducts as $p) {
    if (!empty($p['category'])) $categories[$p['category']] = true;
    if (!empty($p['style'])) $styles[$p['style']] = true;
}
ksort($categories); ksort($styles);
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
<main class="category-page">
<section class="category-header"><div class="container">
<div class="category-breadcrumb"><a href="../index.php">Home</a><i class="bi bi-chevron-right" aria-hidden="true"></i><span>Shop</span></div>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
<div><h1>Shop</h1><p class="mb-0"><?= count($filtered) ?> product<?= count($filtered)===1?'':'s' ?> found</p></div>
<form method="get" class="sort-box"><label for="sort-products">Sort by:</label>
<?php foreach(['category','style','tag','search'] as $key): if(isset($_GET[$key]) && $_GET[$key]!==''): ?><input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($_GET[$key]) ?>"><?php endif; endforeach; ?>
<select id="sort-products" name="sort" class="form-select">
<option value="popular" <?= $sort==='popular'?'selected':'' ?>>Most Popular</option>
<option value="rating" <?= $sort==='rating'?'selected':'' ?>>Top Rated</option>
<option value="price-low" <?= $sort==='price-low'?'selected':'' ?>>Price: Low to High</option>
<option value="price-high" <?= $sort==='price-high'?'selected':'' ?>>Price: High to Low</option>
</select></form></div></div></section>
<section class="category-products-section"><div class="container"><div class="row g-4">
<aside class="col-md-3"><div class="filters"><div class="filter-header"><h2 class="mb-0">Filters</h2></div><hr>
<form method="get">
<div class="filter-group"><h3>Categories</h3><div class="filter-list">
<label class="d-block mb-2"><input type="radio" name="category" value="" <?= $category===''?'checked':'' ?>> All</label>
<?php foreach($categories as $name=>$_): ?><label class="d-block mb-2"><input type="radio" name="category" value="<?= htmlspecialchars($name) ?>" <?= strcasecmp($category,$name)===0?'checked':'' ?>> <?= htmlspecialchars($name) ?></label><?php endforeach; ?>
</div></div><hr>
<div class="filter-group"><h3>Dress Style</h3><div class="filter-list">
<label class="d-block mb-2"><input type="radio" name="style" value="" <?= $style===''?'checked':'' ?>> All</label>
<?php foreach($styles as $name=>$_): ?><label class="d-block mb-2"><input type="radio" name="style" value="<?= htmlspecialchars($name) ?>" <?= strcasecmp($style,$name)===0?'checked':'' ?>> <?= htmlspecialchars($name) ?></label><?php endforeach; ?>
</div></div>
<?php if($tag!==''): ?><input type="hidden" name="tag" value="<?= htmlspecialchars($tag) ?>"><?php endif; ?>
<?php if($search!==''): ?><input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>"><?php endif; ?>
<button type="submit" class="btn btn-dark w-100 mt-3">Apply Filter</button>
<a href="products.php" class="btn btn-outline-dark w-100 mt-2">Clear Filters</a>
</form></div></aside>
<div class="col-12 col-md-9"><div class="row row-cols-2 row-cols-lg-3 g-4">
<?php if(!$filtered): ?><div class="col-12"><div class="alert alert-light border">No products match your filters.</div></div><?php endif; ?>
<?php foreach($filtered as $p): ?><div class="col"><article class="product-card h-100">
<a href="product-details.php?id=<?= urlencode($p['id']) ?>" class="text-decoration-none text-reset">
<img src="../<?= htmlspecialchars(productImage($p)) ?>" class="img-fluid" alt="<?= htmlspecialchars($p['name']) ?>">
<h3><?= htmlspecialchars($p['name']) ?></h3><div class="product-rating"><?= htmlspecialchars((string)($p['rating']??0)) ?>/5</div>
<strong>$<?= number_format(productPrice($p),2) ?></strong>
<?php if(($o=productOriginalPrice($p))!==null): ?><del class="ms-2">$<?= number_format($o,2) ?></del><?php endif; ?>
</a></article></div><?php endforeach; ?>
</div></div></div></div></section></main>
<?php require __DIR__ . '/../shared/footer.php'; ?>
</body></html>
