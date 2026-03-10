<?php
// admin/ajax/clear-cache.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn() || !$auth->hasPermission('settings')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$cacheDir = $_SERVER['DOCUMENT_ROOT'] . '/cache/';
$deleted = 0;
$errors = [];

if (file_exists($cacheDir)) {
    $files = glob($cacheDir . '*');
    foreach ($files as $file) {
        if (is_file($file)) {
            if (unlink($file)) {
                $deleted++;
            } else {
                $errors[] = basename($file);
            }
        }
    }
}

// টেম্পোরারি ফাইল ক্লিন
$tempDir = $_SERVER['DOCUMENT_ROOT'] . '/temp/';
if (file_exists($tempDir)) {
    $files = glob($tempDir . '*');
    foreach ($files as $file) {
        if (is_file($file) && time() - filemtime($file) > 3600) { // 1 ঘন্টা পুরাতন
            unlink($file);
        }
    }
}

// সেশন ক্লিন (ঐচ্ছিক)
// $sessionDir = session_save_path();
// if ($sessionDir) {
//     $files = glob($sessionDir . '/sess_*');
//     foreach ($files as $file) {
//         if (is_file($file) && time() - filemtime($file) > 24 * 3600) {
//             unlink($file);
//         }
//     }
// }

// লগ তৈরি
$userId = $_SESSION['user_id'];
$ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR']);
$logSql = "INSERT INTO activity_log (user_id, action, details, ip_address) 
           VALUES ($userId, 'clear_cache', 'Cleared cache, deleted $deleted files', '$ip')";
$conn->query($logSql);

echo json_encode([
    'success' => true,
    'message' => "ক্যাশ ক্লিয়ার হয়েছে। $deleted টি ফাইল ডিলিট করা হয়েছে।",
    'deleted' => $deleted,
    'errors' => $errors
]);