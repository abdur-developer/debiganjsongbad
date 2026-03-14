<?php
// api/get-news.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../admin/includes/config.php';
require_once '../admin/includes/db.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$category = isset($_GET['category']) ? intval($_GET['category']) : 0;

$where = "status = 'published'";
if ($category > 0) {
    $where .= " AND category_id = $category";
}

$sql = "SELECT n.*, c.name_bn as category_name, u.full_name as author_name 
        FROM news n 
        LEFT JOIN categories c ON n.category_id = c.id 
        LEFT JOIN users u ON n.author_id = u.id 
        WHERE $where 
        ORDER BY n.created_at DESC 
        LIMIT $limit";

$result = $conn->query($sql);
$news = [];

while ($row = $result->fetch_assoc()) {
    $news[] = [
        'id' => $row['id'],
        'title' => $row['title_bn'],
        'summary' => $row['summary'],
        'image' => $row['featured_image'],
        'category' => $row['category_name'],
        'author' => $row['author_name'],
        'date' => $row['created_at'],
        'url' => "/news/?feed={$row['id']}"
    ];
}

echo json_encode([
    'success' => true,
    'data' => $news,
    'total' => count($news)
]);