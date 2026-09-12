<?php

require_once __DIR__ . '/../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];


// Check if category has products
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM products WHERE category_id = ?"
);

$stmt->execute([$id]);

$productCount = $stmt->fetchColumn();

if ($productCount > 0) {

    exit(
        "Cannot delete this category because it has products."
    );
}


// Delete category
$stmt = $pdo->prepare(
    "DELETE FROM categories WHERE id = ?"
);

$stmt->execute([$id]);

header("Location: index.php");
exit;