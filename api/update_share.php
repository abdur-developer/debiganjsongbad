<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$input = json_decode(file_get_contents('php://input'), true);

require_once '../admin/includes/config.php';
require_once '../admin/includes/db.php';

$news_id = $input['news_id'];
if($news_id === null) {
    echo json_encode(['success' => false, 'message' => 'News ID is required']);
    exit;
}
$sql = "UPDATE news SET share_count = share_count + 1 WHERE id = $news_id";
$result = $conn->query($sql);
if ($result) {
    echo json_encode(['success' => true, 'message' => 'Share count updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update share count']);
}
?>