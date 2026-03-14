<?php
// api/search.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../admin/includes/config.php';
require_once '../admin/includes/db.php';

$query = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

if (strlen($query) < 2) {
    echo json_encode(['success' => false, 'message' => 'Search query too short']);
    exit();
}

$sql = "SELECT n.*, c.name_bn as category_name 
        FROM news n 
        LEFT JOIN categories c ON n.category_id = c.id 
        WHERE n.status = 'published' 
        AND (n.title_bn LIKE '%$query%' OR n.title_en LIKE '%$query%' OR n.content LIKE '%$query%')
        ORDER BY n.created_at DESC 
        LIMIT 20";

$result = $conn->query($sql);
$results = [];

while ($row = $result->fetch_assoc()) {
    $results[] = [
        'id' => $row['id'],
        'title' => $row['title_bn'],
        'summary' => substr(strip_tags($row['content']), 0, 150) . '...',
        'image' => $row['featured_image'],
        'category' => $row['category_name'],
        'date' => $row['created_at'],
        'url' => "/news/?feed={$row['id']}"
    ];
}

echo json_encode([
    'success' => true,
    'query' => $query,
    'total' => count($results),
    'data' => $results
]);