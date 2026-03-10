<?php
// admin/ajax/live-search.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($query) < 2) {
    echo json_encode(['results' => []]);
    exit();
}

$search = $conn->real_escape_string($query);
$results = [];

// ==================== নিউজ সার্চ ====================
$newsSql = "SELECT id, title_bn, title_en, created_at, 'news' as type 
            FROM news 
            WHERE title_bn LIKE '%$search%' OR title_en LIKE '%$search%' OR content LIKE '%$search%'
            ORDER BY created_at DESC LIMIT 5";
$newsResult = $conn->query($newsSql);

while ($row = $newsResult->fetch_assoc()) {
    $results[] = [
        'type' => 'news',
        'id' => $row['id'],
        'title' => $row['title_bn'] ?: $row['title_en'],
        'category' => 'সংবাদ',
        'date' => date('d/m/Y', strtotime($row['created_at'])),
        'url' => '/admin/news/edit.php?id=' . $row['id']
    ];
}

// ==================== ক্যাটাগরি সার্চ ====================
$catSql = "SELECT id, name_bn, name_en, 'category' as type 
           FROM categories 
           WHERE name_bn LIKE '%$search%' OR name_en LIKE '%$search%'
           LIMIT 5";
$catResult = $conn->query($catSql);

while ($row = $catResult->fetch_assoc()) {
    $results[] = [
        'type' => 'category',
        'id' => $row['id'],
        'title' => $row['name_bn'] ?: $row['name_en'],
        'category' => 'ক্যাটাগরি',
        'date' => '',
        'url' => '/admin/categories/edit.php?id=' . $row['id']
    ];
}

// ==================== ইউজার সার্চ ====================
$userSql = "SELECT id, username, full_name, email, 'user' as type 
            FROM users 
            WHERE username LIKE '%$search%' OR full_name LIKE '%$search%' OR email LIKE '%$search%'
            LIMIT 5";
$userResult = $conn->query($userSql);

while ($row = $userResult->fetch_assoc()) {
    $results[] = [
        'type' => 'user',
        'id' => $row['id'],
        'title' => $row['full_name'] ?: $row['username'],
        'category' => 'ব্যবহারকারী',
        'date' => $row['email'],
        'url' => '/admin/users/edit.php?id=' . $row['id']
    ];
}

// ==================== কমেন্ট সার্চ ====================
$commentSql = "SELECT c.id, c.comment, c.name, n.title_bn as news_title, 'comment' as type 
               FROM comments c 
               LEFT JOIN news n ON c.news_id = n.id 
               WHERE c.comment LIKE '%$search%' OR c.name LIKE '%$search%'
               LIMIT 5";
$commentResult = $conn->query($commentSql);

while ($row = $commentResult->fetch_assoc()) {
    $results[] = [
        'type' => 'comment',
        'id' => $row['id'],
        'title' => substr($row['comment'], 0, 50) . '...',
        'category' => 'মন্তব্য',
        'date' => $row['name'] . ' - ' . substr($row['news_title'], 0, 30),
        'url' => '/admin/comments/index.php'
    ];
}

echo json_encode(['results' => $results]);