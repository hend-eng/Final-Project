<?php

require_once __DIR__ . '/../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];


// Get brand first
$stmt = $pdo->prepare("SELECT * FROM brands WHERE id = ?");
$stmt->execute([$id]);

$brand = $stmt->fetch();

if (!$brand) {
    exit("Brand not found");
}


// Delete brand
$stmt = $pdo->prepare("DELETE FROM brands WHERE id = ?");
$stmt->execute([$id]);


// Delete logo from folder
if (!empty($brand['logo'])) {

    $logoPath = __DIR__ . '/../../' . $brand['logo'];

    if (file_exists($logoPath)) {
        unlink($logoPath);
    }
}


header("Location: index.php");
exit;