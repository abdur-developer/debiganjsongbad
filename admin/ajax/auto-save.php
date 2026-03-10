<?php
// admin/ajax/auto-save.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$data = $_POST;
$newsId = isset($data['news_id']) ? intval($data['news_id']) : 0;
$userId = $_SESSION['user_id'];

// ডাটা স্যানিটাইজ
$title_bn = $conn->real_escape_string($data['title_bn'] ?? '');
$title_en = $conn->real_escape_string($data['title_en'] ?? '');
$content = $conn->real_escape_string($data['content'] ?? '');
$summary = $conn->real_escape_string($data['summary'] ?? '');
$category_id = isset($data['category_id']) ? intval($data['category_id']) : 0;

if (empty($title_bn)) {
    echo json_encode(['success' => false, 'message' => 'শিরোনাম প্রয়োজন']);
    exit();
}

if ($newsId > 0) {
    // আপডেট
    $sql = "UPDATE news SET 
            title_bn = '$title_bn',
            title_en = '$title_en',
            content = '$content',
            summary = '$summary',
            category_id = $category_id,
            updated_at = NOW()
            WHERE id = $newsId AND (author_id = $userId OR editor_id = $userId)";
} else {
    // ইনসার্ট
    $sql = "INSERT INTO news (title_bn, title_en, content, summary, category_id, author_id, status, created_at) 
            VALUES ('$title_bn', '$title_en', '$content', '$summary', $category_id, $userId, 'draft', NOW())";
}

if ($conn->query($sql)) {
    if ($newsId == 0) {
        $newsId = $conn->insert_id;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'খসড়া সেভ হয়েছে',
        'news_id' => $newsId,
        'time' => date('Y-m-d H:i:s')
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'সেভ ব্যর্থ: ' . $conn->error
    ]);
}