<?php
// admin/ajax/load-more.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT n.*, c.name_bn as category_name, u.full_name as author_name 
        FROM news n 
        LEFT JOIN categories c ON n.category_id = c.id 
        LEFT JOIN users u ON n.author_id = u.id 
        WHERE n.status = 'published' 
        ORDER BY n.created_at DESC 
        LIMIT $offset, $limit";

$result = $conn->query($sql);
$html = '';

if ($result && $result->num_rows > 0) {
    while ($news = $result->fetch_assoc()) {
        $html .= '
        <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">
                <img src="' . ($news['featured_image'] ?: 'https://via.placeholder.com/50') . '" 
                     class="w-12 h-12 object-cover rounded" alt="">
            </td>
            <td class="px-4 py-2 font-semibold">' . e($news['title_bn']) . '</td>
            <td class="px-4 py-2">' . $news['category_name'] . '</td>
            <td class="px-4 py-2">' . $news['author_name'] . '</td>
            <td class="px-4 py-2">' . date('d/m/Y', strtotime($news['created_at'])) . '</td>
            <td class="px-4 py-2">' . number_format($news['views']) . '</td>
            <td class="px-4 py-2">
                <a href="edit.php?id=' . $news['id'] . '" class="text-blue-600 hover:text-blue-800 mr-2">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>';
    }
}

// আরও ডাটা আছে কিনা চেক
$countSql = "SELECT COUNT(*) as total FROM news WHERE status = 'published'";
$countResult = $conn->query($countSql);
$totalRows = $countResult->fetch_assoc()['total'];
$hasMore = ($page * $limit) < $totalRows;

echo json_encode([
    'success' => true,
    'html' => $html,
    'hasMore' => $hasMore,
    'page' => $page,
    'total' => $totalRows
]);