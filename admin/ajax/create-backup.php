<?php
// admin/ajax/create-backup.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn() || !$auth->hasPermission('settings')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$backupDir = $_SERVER['DOCUMENT_ROOT'] . '/backups/';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
$filepath = $backupDir . $filename;

// ডাটাবেজ ব্যাকআপ তৈরি
$command = sprintf(
    'mysqldump --user=%s --password=%s --host=%s %s > %s',
    escapeshellarg(DB_USER),
    escapeshellarg(DB_PASS),
    escapeshellarg(DB_HOST),
    escapeshellarg(DB_NAME),
    escapeshellarg($filepath)
);

system($command, $output);

if (file_exists($filepath) && filesize($filepath) > 0) {
    // ফাইল সাইজ
    $size = filesize($filepath);
    $sizeText = formatBytes($size);
    
    // পুরাতন ব্যাকআপ ক্লিন (৭ দিনের পুরাতন)
    $files = glob($backupDir . '*.sql');
    $now = time();
    foreach ($files as $file) {
        if (is_file($file) && $now - filemtime($file) >= 7 * 24 * 60 * 60) {
            unlink($file);
        }
    }
    
    // লগ তৈরি
    $userId = $_SESSION['user_id'];
    $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR']);
    $logSql = "INSERT INTO activity_log (user_id, action, details, ip_address) 
               VALUES ($userId, 'create_backup', 'Created backup: $filename', '$ip')";
    $conn->query($logSql);
    
    echo json_encode([
        'success' => true,
        'message' => 'ব্যাকআপ তৈরি হয়েছে',
        'filename' => $filename,
        'size' => $sizeText,
        'date' => date('Y-m-d H:i:s'),
        'download' => '/backups/' . $filename
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ব্যাকআপ তৈরি ব্যর্থ হয়েছে'
    ]);
}

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}