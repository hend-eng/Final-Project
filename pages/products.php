<?php

require_once __DIR__ . '/../shared/auth.php';
require_once __DIR__ . '/../config/products.php';

$pageTitle = 'Shop - SHOP.CO';

$siteRoot = rtrim(
    str_replace(
        '\\',
        '/',
        dirname(dirname($_SERVER['SCRIPT_NAME']))
    ),
    '/'
);

$allProducts = getProducts();

$category = trim($_GET['category'] ?? '');
$style = trim($_GET['style'] ?? '');
$color = trim($_GET['color'] ?? '');
$size = trim($_GET['size'] ?? '');
$tag = trim($_GET['tag'] ?? '');
$brand = trim($_GET['brand'] ?? '');
$search = trim($_GET['search'] ?? '');
$minPrice = trim($_GET['min_price'] ?? '');
$maxPrice = trim($_GET['max_price'] ?? '');
$sort = trim($_GET['sort'] ?? 'popular');

$minPriceValue = null;
$maxPriceValue = null;

if ($minPrice !== '' && is_numeric($minPrice)) {
    $minPriceValue = (float) $minPrice;
}

if ($maxPrice !== '' && is_numeric($maxPrice)) {
    $maxPriceValue = (float) $maxPrice;
}

function getProductBrandName(array $product): string
{
    if (!empty($product['brand'])) {

        if (is_array($product['brand'])) {
            return trim((string) ($product['brand']['name'] ?? ''));
        }

        return trim((string) $product['brand']);
    }

    if (!empty($product['brand_name'])) {
        return trim((string) $product['brand_name']);
    }

    return '';
}

function getProductBrandId(array $product): string
{
    return trim((string) ($product['brand_id'] ?? ''));
}

function getProductTags(array $product): array
{
    $tags = $product['tags'] ?? [];

    if (is_array($tags)) {
        return $tags;
    }

    if (is_string($tags)) {

        $tags = trim($tags);

        if ($tags === '') {
            return [];
        }

        return array_map('trim', explode(',', $tags));
    }

    return [];
}

function getProductColors(array $product): array
{
    $colors = $product['colors'] ?? [];

    if (is_array($colors)) {
        return array_values(
            array_filter(
                array_map(
                    'trim',
                    array_map('strval', $colors)
                )
            )
        );
    }

    if (is_string($colors)) {

        $colors = trim($colors);

        if ($colors === '') {
            return [];
        }

        return array_values(
            array_filter(
                array_map('trim', explode(',', $colors))
            )
        );
    }

    return [];
}

function getProductSizes(array $product): array
{
    $sizes = $product['sizes'] ?? [];

    if (is_array($sizes)) {
        return array_values(
            array_filter(
                array_map(
                    'trim',
                    array_map('strval', $sizes)
                )
            )
        );
    }

    if (is_string($sizes)) {

        $sizes = trim($sizes);

        if ($sizes === '') {
            return [];
        }

        return array_values(
            array_filter(
                array_map('trim', explode(',', $sizes))
            )
        );
    }

    return [];
}

function isProductOnSale(array $product): bool
{
    $price = isset($product['price'])
        ? (float) $product['price']
        : (float) productPrice($product);

    $originalPrice = isset($product['original_price'])
        ? (float) $product['original_price']
        : 0;

    $discount = isset($product['discount'])
        ? (float) $product['discount']
        : 0;

    if ($discount > 0) {
        return true;
    }

    if ($originalPrice > 0 && $originalPrice > $price) {
        return true;
    }

    foreach (getProductTags($product) as $productTag) {

        if (
            strcasecmp(
                (string) $productTag,
                'sale'
            ) === 0
        ) {
            return true;
        }
    }

    return false;
}

$filtered = array_values(
    array_filter(
        $allProducts,
        function ($product) use (
            $category,
            $style,
            $color,
            $size,
            $tag,
            $brand,
            $search,
            $minPriceValue,
            $maxPriceValue
        ) {

            $productName = trim(
                (string) ($product['name'] ?? '')
            );

            $productDescription = trim(
                (string) ($product['description'] ?? '')
            );

            $productCategory = trim(
                (string) ($product['category'] ?? '')
            );

            $productStyle = trim(
                (string) ($product['style'] ?? '')
            );

            $productColors = getProductColors($product);
            $productSizes = getProductSizes($product);
            $productBrand = getProductBrandName($product);
            $productBrandId = getProductBrandId($product);
            $productTags = getProductTags($product);

            if (
                $category !== '' &&
                strcasecmp($productCategory, $category) !== 0
            ) {
                return false;
            }

            if (
                $style !== '' &&
                strcasecmp($productStyle, $style) !== 0
            ) {
                return false;
            }

            if ($color !== '') {

                $colorFound = false;

                foreach ($productColors as $productColor) {

                    if (
                        strcasecmp(
                            (string) $productColor,
                            $color
                        ) === 0
                    ) {
                        $colorFound = true;
                        break;
                    }
                }

                if (!$colorFound) {
                    return false;
                }
            }

            if ($size !== '') {

                $sizeFound = false;

                foreach ($productSizes as $productSize) {

                    if (
                        strcasecmp(
                            (string) $productSize,
                            $size
                        ) === 0
                    ) {
                        $sizeFound = true;
                        break;
                    }
                }

                if (!$sizeFound) {
                    return false;
                }
            }

            if ($tag !== '') {

                if (
                    strcasecmp($tag, 'sale') === 0
                ) {

                    if (!isProductOnSale($product)) {
                        return false;
                    }

                } else {

                    $tagFound = false;

                    foreach ($productTags as $productTag) {

                        if (
                            strcasecmp(
                                (string) $productTag,
                                $tag
                            ) === 0
                        ) {
                            $tagFound = true;
                            break;
                        }
                    }

                    if (!$tagFound) {
                        return false;
                    }
                }
            }

            if ($brand !== '') {

                $brandMatches = false;

                if (
                    $productBrand !== '' &&
                    strcasecmp(
                        $productBrand,
                        $brand
                    ) === 0
                ) {
                    $brandMatches = true;
                }

                if (
                    !$brandMatches &&
                    $productBrandId !== ''
                ) {

                    if (
                        $productBrandId ===
                        (string) $brand
                    ) {
                        $brandMatches = true;
                    }
                }

                if (!$brandMatches) {
                    return false;
                }
            }

            if ($search !== '') {

                $tagsText = implode(
                    ' ',
                    array_map(
                        'strval',
                        $productTags
                    )
                );

                $haystack = strtolower(
                    implode(
                        ' ',
                        [
                            $productName,
                            $productDescription,
                            $productCategory,
                            $productStyle,
                            $productBrand,
                            $tagsText
                        ]
                    )
                );

                $searchText = strtolower($search);

                if (
                    strpos(
                        $haystack,
                        $searchText
                    ) === false
                ) {
                    return false;
                }
            }

            $productPrice = (float) productPrice($product);

            if (
                $minPriceValue !== null &&
                $productPrice < $minPriceValue
            ) {
                return false;
            }

            if (
                $maxPriceValue !== null &&
                $productPrice > $maxPriceValue
            ) {
                return false;
            }

            return true;
        }
    )
);

if ($sort === 'price-low') {

    usort(
        $filtered,
        function ($a, $b) {
            return productPrice($a) <=> productPrice($b);
        }
    );

} elseif ($sort === 'price-high') {

    usort(
        $filtered,
        function ($a, $b) {
            return productPrice($b) <=> productPrice($a);
        }
    );

} elseif ($sort === 'rating') {

    usort(
        $filtered,
        function ($a, $b) {
            return
                (float) ($b['rating'] ?? 0)
                <=>
                (float) ($a['rating'] ?? 0);
        }
    );
}

$categories = [];
$styles = [];
$colors = [];
$sizes = [];
$brands = [];

foreach ($allProducts as $product) {

    if (!empty($product['category'])) {

        $categoryName = trim(
            (string) $product['category']
        );

        if ($categoryName !== '') {
            $categories[$categoryName] = true;
        }
    }

    if (!empty($product['style'])) {

        $styleName = trim(
            (string) $product['style']
        );

        if ($styleName !== '') {
            $styles[$styleName] = true;
        }
    }

    foreach (getProductColors($product) as $colorName) {

        if ($colorName !== '') {
            $colors[$colorName] = true;
        }
    }

    foreach (getProductSizes($product) as $sizeName) {

        if ($sizeName !== '') {
            $sizes[$sizeName] = true;
        }
    }

    $brandName = getProductBrandName($product);

    if ($brandName !== '') {
        $brands[$brandName] = true;
    }
}

ksort($categories);
ksort($styles);
uksort($colors, 'strnatcasecmp');
uksort($sizes, 'strnatcasecmp');
ksort($brands);

$currentFilters = [
    'category' => $category,
    'style' => $style,
    'color' => $color,
    'size' => $size,
    'tag' => $tag,
    'brand' => $brand,
    'search' => $search,
    'min_price' => $minPrice,
    'max_price' => $maxPrice
];

$productsPerPage = 13;

$totalProducts = count($filtered);

$totalPages = max(
    1,
    (int) ceil(
        $totalProducts / $productsPerPage
    )
);

$currentPage = isset($_GET['page'])
    ? max(1, (int) $_GET['page'])
    : 1;

if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$offset = ($currentPage - 1) * $productsPerPage;

$pageProducts = array_slice(
    $filtered,
    $offset,
    $productsPerPage
);

function getColorHex(string $color): string
{
    $key = strtolower(
        trim(
            preg_replace(
                '/\s+/',
                ' ',
                $color
            )
        )
    );

    $map = [
        'black' => '#000000',
        'white' => '#ffffff',
        'off white' => '#f8f8f8',
        'cream' => '#fff4d6',
        'ivory' => '#fffff0',
        'red' => '#c62828',
        'dark red' => '#8b0000',
        'light red' => '#ef9a9a',
        'burgundy' => '#800020',
        'maroon' => '#800000',
        'blue' => '#1717e8',
        'dark blue' => '#071a8a',
        'navy' => '#001f5b',
        'light blue' => '#9ec9e8',
        'sky blue' => '#87ceeb',
        'baby blue' => '#a9d6f5',
        'green' => '#008000',
        'dark green' => '#006400',
        'light green' => '#a8c8a0',
        'olive' => '#808000',
        'yellow' => '#ffd400',
        'gold' => '#d4af37',
        'orange' => '#ff8c00',
        'pink' => '#ffb6c1',
        'light pink' => '#ffc4cf',
        'hot pink' => '#ff69b4',
        'purple' => '#800080',
        'lavender' => '#b57edc',
        'brown' => '#8b4513',
        'light brown' => '#b89a7a',
        'beige' => '#e8d7bd',
        'khaki' => '#b5a36a',
        'gray' => '#8a8a8a',
        'grey' => '#8a8a8a',
        'light gray' => '#eeeeee',
        'light grey' => '#eeeeee',
        'dark gray' => '#555555',
        'dark grey' => '#555555',
        'silver' => '#c0c0c0',
        'charcoal' => '#36454f'
    ];

    if (isset($map[$key])) {
        return $map[$key];
    }

    if (preg_match('/^#[0-9a-f]{3,8}$/i', $color)) {
        return $color;
    }

    if (preg_match('/^(rgb|rgba|hsl|hsla)\(/i', $color)) {
        return $color;
    }

    return '#d9d9d9';
}

function buildPageUrl(
    int $page,
    array $filters,
    string $sort
): string {

    $query = $filters;

    $query['sort'] = $sort;
    $query['page'] = $page;

    $query = array_filter(
        $query,
        function ($value) {
            return $value !== '';
        }
    );

    return 'products.php?' . http_build_query($query);
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($pageTitle) ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="<?= htmlspecialchars(
            $siteRoot,
            ENT_QUOTES,
            'UTF-8'
        ) ?>/assets/css/style.css"
    >

    <style>

.category-products-section {
    padding: 25px 0 70px;
}

.category-products-section > .container {
    max-width: 1500px;
}

.filters {
    position: sticky;
    top: 120px;
    padding: 22px;
    border: 1px solid #ddd;
    border-radius: 18px;
    background: #fff;
}

.filters-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.filters-header h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
}

.filter-close {
    display: none;
    width: 32px;
    height: 32px;
    padding: 0;
    border: 0;
    background: transparent;
    font-size: 18px;
}

.filters hr {
    margin: 18px 0;
    border-color: #e5e5e5;
}

.filter-group h3 {
    margin: 0 0 14px;
    font-size: 14px;
    font-weight: 600;
}

.filter-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.filter-list button {
    width: 100%;
    padding: 6px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 0;
    background: transparent;
    color: #555;
    text-align: left;
    font-size: 12px;
    cursor: pointer;
}

.filter-list button:hover,
.filter-list button.selected {
    color: #000;
    font-weight: 600;
}

.price-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

.price-inputs .form-control {
    min-height: 40px;
    border-radius: 10px;
    font-size: 12px;
}

.color-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.color-option {
    width: 28px;
    height: 28px;
    padding: 0;
    border: 1px solid #ddd;
    border-radius: 50%;
    cursor: pointer;
}

.color-option.selected {
    outline: 2px solid #000;
    outline-offset: 3px;
}

.clear-option {
    margin-top: 12px;
    padding: 0;
    border: 0;
    background: transparent;
    color: #666;
    font-size: 11px;
    text-decoration: underline;
    cursor: pointer;
}

.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
}

.size-options button {
    padding: 8px 13px;
    border: 0;
    border-radius: 18px;
    background: #f1f1f1;
    color: #555;
    font-size: 11px;
    cursor: pointer;
}

.size-options button:hover,
.size-options button.selected {
    background: #000;
    color: #fff;
}

#category-products .product-card {
    height: 100%;
}

#category-products .product-card-link {
    display: block;
    text-decoration: none;
}

#category-products .product-image {
    width: 100%;
    height: 260px;
    overflow: hidden;
    border-radius: 14px;
    background: #f5f5f5;
}

#category-products .product-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    transition: transform .3s ease;
}

#category-products .product-card:hover .product-image img {
    transform: scale(1.03);
}

#category-products .product-card h3 {
    margin: 10px 0 5px;
    font-size: 14px;
    line-height: 1.35;
}

#category-products .product-card h3 a {
    color: #000;
    text-decoration: none;
}

#category-products .product-card h3 a:hover {
    text-decoration: underline;
}

#category-products .product-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 7px;
    color: #555;
    font-size: 12px;
}

#category-products .product-stars {
    color: #ffc107;
    letter-spacing: 1px;
}

#category-products .product-price {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

#category-products .product-price strong {
    font-size: 17px;
}

#category-products .product-price span {
    color: #999;
    font-size: 13px;
    text-decoration: line-through;
}

#category-products .product-price small {
    padding: 4px 8px;
    border-radius: 20px;
    background: #ffe5e5;
    color: #ff3333;
    font-size: 10px;
    font-weight: 600;
}

.no-products {
    padding: 60px 20px;
    border: 1px solid #eee;
    border-radius: 16px;
    text-align: center;
}

.no-products h3 {
    margin-bottom: 8px;
    font-size: 20px;
}

.no-products p {
    margin: 0;
    color: #777;
}

.category-pagination {
    margin-top: 45px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.category-pagination a,
.category-pagination button {
    min-width: 105px;
    height: 38px;
    padding: 0 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    color: #333;
    text-decoration: none;
    font-size: 12px;
}

.category-pagination a:hover {
    border-color: #000;
    color: #000;
}

.category-pagination .pagination-numbers {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    flex-wrap: wrap;
}

.category-pagination .pagination-numbers a {
    min-width: 35px;
    width: 35px;
    height: 35px;
    padding: 0;
}

.category-pagination .pagination-numbers a.active {
    border-color: #000;
    background: #000;
    color: #fff;
}

.mobile-filter-button {
    display: none;
}

@media (max-width: 767.98px) {

    .mobile-filter-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 44px;
        margin-bottom: 20px;
        border-radius: 22px;
    }

    .filters {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1055;
        width: min(320px, 88vw);
        height: 100vh;
        overflow-y: auto;
        padding: 22px;
        border: 0;
        border-radius: 0;
        box-shadow: 8px 0 25px rgba(0,0,0,.15);
        transform: translateX(-105%);
        transition: transform .25s ease;
    }

    .filters.show {
        transform: translateX(0);
    }

    .filter-close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    body.filters-open {
        overflow: hidden;
    }

    body.filters-open::after {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(0,0,0,.35);
    }

    #category-products .product-image {
        height: 190px;
        border-radius: 12px;
    }

    #category-products .product-card h3 {
        font-size: 11px;
    }

    #category-products .product-rating {
        font-size: 9px;
    }

    #category-products .product-price strong {
        font-size: 12px;
    }

    #category-products .product-price span {
        font-size: 10px;
    }

    .category-pagination {
        margin-top: 35px;
        gap: 8px;
    }

    .category-pagination a,
    .category-pagination button {
        min-width: auto;
        padding: 0 10px;
        font-size: 10px;
    }
}

.filter-choice,
.color-option,
.size-options button,
.clear-option {
    transition: all .2s ease;
}

.filter-choice.selected {
    color: #000;
    font-weight: 600;
}

.color-option {
    flex: 0 0 28px;
    box-sizing: border-box;
}

.color-option.selected {
    border-color: #fff;
    outline: 2px solid #000;
    outline-offset: 2px;
}

.color-option[style*="#ffffff"],
.color-option[style*="#eeeeee"],
.color-option[style*="#f8f8f8"],
.color-option[style*="#fff4d6"] {
    box-shadow: inset 0 0 0 1px #ddd;
}

    </style>

</head>

<body>

<?php require __DIR__ . '/../shared/header.php'; ?>

<main class="category-page">

    <section class="category-header">

        <div class="container">

            <div class="category-breadcrumb">

                <a
                    href="<?= htmlspecialchars(
                        $siteRoot,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>/index.php"
                >
                    Home
                </a>

                <i
                    class="bi bi-chevron-right"
                    aria-hidden="true"
                ></i>

                <span>
                    Shop
                </span>

            </div>

            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3"
            >

                <div>

                    <h1>
                        Shop
                    </h1>

                    <p class="mb-0">
                        <?= count($filtered) ?>
                        product<?= count($filtered) === 1 ? '' : 's' ?>
                        found
                    </p>

                </div>

                <form
                    method="get"
                    class="category-sort"
                >

                    <?php foreach ($currentFilters as $key => $value): ?>

                        <?php if ($value !== ''): ?>

                            <input
                                type="hidden"
                                name="<?= htmlspecialchars(
                                    $key,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                value="<?= htmlspecialchars(
                                    $value,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                        <?php endif; ?>

                    <?php endforeach; ?>

                    <span>
                        Sort by:
                    </span>

                    <select
                        id="sort-products"
                        name="sort"
                        class="form-select"
                        onchange="this.form.submit()"
                    >

                        <option
                            value="popular"
                            <?= $sort === 'popular' ? 'selected' : '' ?>
                        >
                            Most Popular
                        </option>

                        <option
                            value="rating"
                            <?= $sort === 'rating' ? 'selected' : '' ?>
                        >
                            Top Rated
                        </option>

                        <option
                            value="price-low"
                            <?= $sort === 'price-low' ? 'selected' : '' ?>
                        >
                            Price: Low to High
                        </option>

                        <option
                            value="price-high"
                            <?= $sort === 'price-high' ? 'selected' : '' ?>
                        >
                            Price: High to Low
                        </option>

                    </select>

                </form>

            </div>

        </div>

    </section>

    <section class="category-products-section">

        <div class="container">

            <button
                type="button"
                id="open-filters"
                class="btn btn-dark mobile-filter-button"
            >
                <i
                    class="bi bi-sliders me-2"
                    aria-hidden="true"
                ></i>
                Filters
            </button>

            <div class="row g-4">

                <aside class="col-12 col-md-3">

                    <div
                        class="filters"
                        id="filters-panel"
                    >

                        <div class="filters-header">

                            <h2>
                                Filters
                            </h2>

                            <button
                                type="button"
                                class="filter-close"
                                id="close-filters"
                                aria-label="Close filters"
                            >
                                <i
                                    class="bi bi-x-lg"
                                    aria-hidden="true"
                                ></i>
                            </button>

                        </div>

                        <hr>

                        <form
                            method="get"
                            id="product-filter-form"
                        >

                            <input
                                type="hidden"
                                name="category"
                                id="filter-category"
                                value="<?= htmlspecialchars(
                                    $category,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                            <input
                                type="hidden"
                                name="color"
                                id="filter-color"
                                value="<?= htmlspecialchars(
                                    $color,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                            <input
                                type="hidden"
                                name="size"
                                id="filter-size"
                                value="<?= htmlspecialchars(
                                    $size,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                            <input
                                type="hidden"
                                name="style"
                                id="filter-style"
                                value="<?= htmlspecialchars(
                                    $style,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                            <?php if ($tag !== ''): ?>

                                <input
                                    type="hidden"
                                    name="tag"
                                    value="<?= htmlspecialchars(
                                        $tag,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >

                            <?php endif; ?>

                            <?php if ($brand !== ''): ?>

                                <input
                                    type="hidden"
                                    name="brand"
                                    value="<?= htmlspecialchars(
                                        $brand,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >

                            <?php endif; ?>

                            <div class="filter-group">

                                <h3>
                                    Categories
                                </h3>

                                <div class="filter-list">

                                    <button
                                        type="button"
                                        class="filter-choice <?= $category === '' ? 'selected' : '' ?>"
                                        data-filter="category"
                                        data-value=""
                                    >
                                        <span>
                                            All
                                        </span>

                                        <i
                                            class="bi bi-chevron-right"
                                            aria-hidden="true"
                                        ></i>
                                    </button>

                                    <?php foreach ($categories as $name => $_): ?>

                                        <button
                                            type="button"
                                            class="filter-choice <?= strcasecmp($category, $name) === 0 ? 'selected' : '' ?>"
                                            data-filter="category"
                                            data-value="<?= htmlspecialchars(
                                                $name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                        >

                                            <span>
                                                <?= htmlspecialchars(
                                                    $name,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>

                                            <i
                                                class="bi bi-chevron-right"
                                                aria-hidden="true"
                                            ></i>

                                        </button>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                            <hr>

                            <div class="filter-group">

                                <h3>
                                    Price
                                </h3>

                                <div class="price-inputs">

                                    <input
                                        type="number"
                                        name="min_price"
                                        class="form-control"
                                        min="0"
                                        step="0.01"
                                        value="<?= htmlspecialchars(
                                            $minPrice,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        placeholder="Min"
                                    >

                                    <input
                                        type="number"
                                        name="max_price"
                                        class="form-control"
                                        min="0"
                                        step="0.01"
                                        value="<?= htmlspecialchars(
                                            $maxPrice,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        placeholder="Max"
                                    >

                                </div>

                            </div>

                            <hr>

                            <div class="filter-group">

                                <h3>
                                    Colors
                                </h3>

                                <div class="color-options">

                                    <?php foreach ($colors as $name => $_): ?>

                                        <button
                                            type="button"
                                            class="color-option <?= strcasecmp($color, $name) === 0 ? 'selected' : '' ?>"
                                            data-filter="color"
                                            data-value="<?= htmlspecialchars(
                                                $name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                            style="background-color: <?= htmlspecialchars(
                                                getColorHex($name),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>;"
                                            title="<?= htmlspecialchars(
                                                $name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                            aria-label="<?= htmlspecialchars(
                                                $name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                        ></button>

                                    <?php endforeach; ?>

                                </div>

                                <?php if ($color !== ''): ?>

                                    <button
                                        type="button"
                                        class="clear-option"
                                        data-filter="color"
                                        data-value=""
                                    >
                                        Clear color
                                    </button>

                                <?php endif; ?>

                            </div>

                            <hr>

                            <div class="filter-group">

                                <h3>
                                    Size
                                </h3>

                                <div class="size-options">

                                    <?php foreach ($sizes as $name => $_): ?>

                                        <button
                                            type="button"
                                            class="<?= strcasecmp($size, $name) === 0 ? 'selected' : '' ?>"
                                            data-filter="size"
                                            data-value="<?= htmlspecialchars(
                                                $name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                        >
                                            <?= htmlspecialchars(
                                                $name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </button>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                            <hr>

                            <div class="filter-group">

                                <h3>
                                    Dress Style
                                </h3>

                                <div class="filter-list">

                                    <button
                                        type="button"
                                        class="filter-choice <?= $style === '' ? 'selected' : '' ?>"
                                        data-filter="style"
                                        data-value=""
                                    >

                                        <span>
                                            All
                                        </span>

                                        <i
                                            class="bi bi-chevron-right"
                                            aria-hidden="true"
                                        ></i>

                                    </button>

                                    <?php foreach ($styles as $name => $_): ?>

                                        <button
                                            type="button"
                                            class="filter-choice <?= strcasecmp($style, $name) === 0 ? 'selected' : '' ?>"
                                            data-filter="style"
                                            data-value="<?= htmlspecialchars(
                                                $name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                        >

                                            <span>
                                                <?= htmlspecialchars(
                                                    $name,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>

                                            <i
                                                class="bi bi-chevron-right"
                                                aria-hidden="true"
                                            ></i>

                                        </button>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                            <input
                                type="hidden"
                                name="sort"
                                value="<?= htmlspecialchars(
                                    $sort,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                            <button
                                type="submit"
                                id="apply-filters"
                                class="btn btn-dark w-100 mt-3"
                            >
                                Apply Filter
                            </button>

                            <a
                                href="<?= htmlspecialchars(
                                    $siteRoot,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>/pages/products.php"
                                class="btn btn-outline-dark w-100 mt-2"
                            >
                                Clear Filters
                            </a>

                        </form>

                    </div>

                </aside>

                <div class="col-12 col-md-9">

                    <div
                        id="category-products"
                        class="row row-cols-2 row-cols-lg-3 g-4"
                    >

                        <?php if (!$pageProducts): ?>

                            <div class="col-12">

                                <div class="no-products">

                                    <h3>
                                        No products found
                                    </h3>

                                    <p>
                                        Try changing your filters.
                                    </p>

                                </div>

                            </div>

                        <?php endif; ?>

                        <?php foreach ($pageProducts as $product): ?>

                            <?php

                            $price = productPrice($product);

                            $originalPrice =
                                productOriginalPrice($product);

                            $discount = 0;

                            if (
                                $originalPrice !== null &&
                                $originalPrice > $price
                            ) {

                                $discount = (int) round(
                                    (
                                        (
                                            $originalPrice -
                                            $price
                                        )
                                        /
                                        $originalPrice
                                    )
                                    * 100
                                );

                            } elseif (!empty($product['discount'])) {

                                $discount =
                                    (int) $product['discount'];
                            }

                            $rating =
                                (float) (
                                    $product['rating'] ?? 0
                                );

                            $reviewCount =
                                (int) (
                                    $product['review_count'] ?? 0
                                );

                            $image =
                                productImage($product);

                            $imagePath =
                                $siteRoot . '/' .
                                ltrim($image, '/');

                            ?>

                            <div class="col">

                                <article class="product-card">

                                    <a
                                        href="<?= htmlspecialchars(
                                            $siteRoot,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>/pages/product-details.php?id=<?= urlencode(
                                            (string) $product['id']
                                        ) ?>"
                                        class="product-card-link"
                                    >

                                        <div class="product-image">

                                            <img
                                                src="<?= htmlspecialchars(
                                                    $imagePath,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>"
                                                alt="<?= htmlspecialchars(
                                                    (string) $product['name'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>"
                                                loading="lazy"
                                            >

                                        </div>

                                    </a>

                                    <h3>

                                        <a
                                            href="<?= htmlspecialchars(
                                                $siteRoot,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>/pages/product-details.php?id=<?= urlencode(
                                                (string) $product['id']
                                            ) ?>"
                                        >
                                            <?= htmlspecialchars(
                                                (string) $product['name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </a>

                                    </h3>

                                    <div class="product-rating">

                                        <span class="product-stars">

                                            <?php for (
                                                $star = 1;
                                                $star <= 5;
                                                $star++
                                            ): ?>

                                                <i
                                                    class="bi <?= $star <= floor($rating) ? 'bi-star-fill' : 'bi-star' ?>"
                                                    aria-hidden="true"
                                                ></i>

                                            <?php endfor; ?>

                                        </span>

                                        <span>
                                            <?= number_format(
                                                $rating,
                                                1
                                            ) ?>/5
                                        </span>

                                        <?php if ($reviewCount > 0): ?>

                                            <span>
                                                (<?= $reviewCount ?>)
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                    <div class="product-price">

                                        <strong>
                                            $<?= number_format(
                                                $price,
                                                2
                                            ) ?>
                                        </strong>

                                        <?php if (
                                            $originalPrice !== null &&
                                            $originalPrice > $price
                                        ): ?>

                                            <span>
                                                $<?= number_format(
                                                    $originalPrice,
                                                    2
                                                ) ?>
                                            </span>

                                        <?php endif; ?>

                                        <?php if ($discount > 0): ?>

                                            <small>
                                                -<?= $discount ?>%
                                            </small>

                                        <?php endif; ?>

                                    </div>

                                </article>

                            </div>

                        <?php endforeach; ?>

                    </div>

                    <?php if ($totalPages > 1): ?>

                        <nav
                            class="category-pagination"
                            aria-label="Product pagination"
                        >

                            <?php if ($currentPage > 1): ?>

                                <a
                                    href="<?= htmlspecialchars(
                                        buildPageUrl(
                                            $currentPage - 1,
                                            $currentFilters,
                                            $sort
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                    class="prev"
                                >

                                    <i
                                        class="bi bi-arrow-left"
                                        aria-hidden="true"
                                    ></i>

                                    Previous

                                </a>

                            <?php else: ?>

                                <button
                                    type="button"
                                    class="prev"
                                    disabled
                                >

                                    <i
                                        class="bi bi-arrow-left"
                                        aria-hidden="true"
                                    ></i>

                                    Previous

                                </button>

                            <?php endif; ?>

                            <div class="pagination-numbers">

                                <?php for (
                                    $page = 1;
                                    $page <= $totalPages;
                                    $page++
                                ): ?>

                                    <a
                                        href="<?= htmlspecialchars(
                                            buildPageUrl(
                                                $page,
                                                $currentFilters,
                                                $sort
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        class="<?= $page === $currentPage ? 'active' : '' ?>"
                                    >
                                        <?= $page ?>
                                    </a>

                                <?php endfor; ?>

                            </div>

                            <?php if ($currentPage < $totalPages): ?>

                                <a
                                    href="<?= htmlspecialchars(
                                        buildPageUrl(
                                            $currentPage + 1,
                                            $currentFilters,
                                            $sort
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                    class="next"
                                >

                                    Next

                                    <i
                                        class="bi bi-arrow-right"
                                        aria-hidden="true"
                                    ></i>

                                </a>

                            <?php else: ?>

                                <button
                                    type="button"
                                    class="next"
                                    disabled
                                >

                                    Next

                                    <i
                                        class="bi bi-arrow-right"
                                        aria-hidden="true"
                                    ></i>

                                </button>

                            <?php endif; ?>

                        </nav>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </section>

</main>

<?php require __DIR__ . '/../shared/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('product-filter-form');

    const filters =
        document.getElementById('filters-panel');

    const openButton =
        document.getElementById('open-filters');

    const closeButton =
        document.getElementById('close-filters');

    if (form) {

        document
            .querySelectorAll('[data-filter]')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        const filterName =
                            button.dataset.filter;

                        const value =
                            button.dataset.value ?? '';

                        const input =
                            document.getElementById(
                                'filter-' + filterName
                            );

                        if (!input) {
                            return;
                        }

                        input.value = value;

                        document
                            .querySelectorAll(
                                '[data-filter="' +
                                filterName +
                                '"]'
                            )
                            .forEach(function (item) {

                                item.classList.toggle(
                                    'selected',
                                    item === button
                                );

                            });

                    }
                );

            });

    }

    if (
        openButton &&
        closeButton &&
        filters
    ) {

        openButton.addEventListener(
            'click',
            function () {

                filters.classList.add('show');

                document.body.classList.add(
                    'filters-open'
                );

            }
        );

        closeButton.addEventListener(
            'click',
            function () {

                filters.classList.remove('show');

                document.body.classList.remove(
                    'filters-open'
                );

            }
        );

        document.addEventListener(
            'click',
            function (event) {

                if (
                    document.body.classList.contains(
                        'filters-open'
                    ) &&
                    !filters.contains(event.target) &&
                    !openButton.contains(event.target)
                ) {

                    filters.classList.remove('show');

                    document.body.classList.remove(
                        'filters-open'
                    );

                }

            }
        );

    }

});
</script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>

