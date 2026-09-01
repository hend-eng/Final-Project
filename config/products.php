<?php

require_once __DIR__ . '/db.php';

/** Turn a raw DB row into the shape the rest of the site expects. */
function mapProductRow(array $row): array
{
    $row['category']   = $row['category_name'] ?? null;
    $row['tags']       = $row['tags'] !== null && $row['tags'] !== ''
        ? array_map('trim', explode(',', $row['tags']))
        : [];
    $row['colors']     = $row['colors'] !== null && $row['colors'] !== ''
        ? array_map('trim', explode(',', $row['colors']))
        : [];
    $row['sizes']      = $row['sizes'] !== null && $row['sizes'] !== ''
        ? array_map('trim', explode(',', $row['sizes']))
        : [];
    return $row;
}

/** All products, most recent first. Cached per-request. */
function getProducts(): array
{
    global $pdo;
    static $products = null;
    if ($products !== null) return $products;

    $sql = "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            ORDER BY p.created_at DESC";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();

    return $products = array_map('mapProductRow', $rows);
}

/** One product by its slug id (e.g. 'black-casual-shorts'), or null. */
function getProductById(string $id): ?array
{
    global $pdo;

    $sql = "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.id = ?
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    return $row ? mapProductRow($row) : null;
}


function productImage(array $product, int $index = 0): string
{
    // The DB only stores one image per product right now (main_image).
    // $index is kept for backward compatibility with older calls.
    return $product['main_image'] ?: 'assets/images/general/Hero.png';
}

function productPrice(array $product): float
{
    return (float)($product['price'] ?? 0);
}

function productOriginalPrice(array $product): ?float
{
    return isset($product['original_price']) && $product['original_price'] !== null
        ? (float)$product['original_price']
        : null;
}