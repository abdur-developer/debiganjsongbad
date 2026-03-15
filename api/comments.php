<?php
// api/get-categories.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$input = json_decode(file_get_contents('php://input'), true);

require_once '../admin/includes/config.php';
require_once '../admin/includes/db.php';

$news_id = $input['news_id'];
$name = $input['name'];
$email = $input['email'];
$comment = $input['comment'];
$ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR']);

$sql = "INSERT INTO comments (news_id, name, email, comment, ip_address) VALUES ($news_id, '$name', '$email', '$comment', '$ip')";
$result = $conn->query($sql);
if ($result) {
    echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
}
?>