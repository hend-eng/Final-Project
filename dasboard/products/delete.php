<?php

require_once __DIR__ . '/../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];


// Get product first
$stmt = $pdo->prepare(
    "SELECT * FROM products WHERE id = ?"
);

$stmt->execute([$id]);

$product = $stmt->fetch();

if (!$product) {
    exit("Product not found");
}


// Delete product
$stmt = $pdo->prepare(
    "DELETE FROM products WHERE id = ?"
);

$stmt->execute([$id]);


// Delete product image
if (!empty($product['main_image'])) {

    $imagePath =
        __DIR__ . '/../../' . $product['main_image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}


header("Location: index.php");
exit;