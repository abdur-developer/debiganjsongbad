<?php
// api/get-categories.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../admin/includes/config.php';
require_once '../admin/includes/db.php';

$sql = "SELECT * FROM categories WHERE status = 'active' ORDER BY sort_order, name_bn";
$result = $conn->query($sql);
$categories = [];

while ($row = $result->fetch_assoc()) {
    // নিউজ কাউন্ট
    $countSql = "SELECT COUNT(*) as total FROM news WHERE category_id = {$row['id']} AND status = 'published'";
    $countResult = $conn->query($countSql);
    $countRow = $countResult->fetch_assoc();
    
    $categories[] = [
        'id' => $row['id'],
        'name_bn' => $row['name_bn'],
        'name_en' => $row['name_en'],
        'slug' => $row['slug'],
        'news_count' => $countRow['total'],
        'url' => "/category.php?slug={$row['slug']}"
    ];
}

echo json_encode([
    'success' => true,
    'data' => $categories
]);