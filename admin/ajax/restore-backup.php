<?php
// admin/ajax/restore-backup.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn() || !$auth->hasPermission('settings')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$filename = $_POST['file'] ?? '';
if (empty($filename)) {
    echo json_encode(['success' => false, 'message' => 'Filename required']);
    exit();
}

$backupDir = $_SERVER['DOCUMENT_ROOT'] . '/backups/';
$filepath = $backupDir . basename($filename);

if (!file_exists($filepath)) {
    echo json_encode(['success' => false, 'message' => 'Backup file not found']);
    exit();
}

// টেম্পোরারি ব্যাকআপ তৈরি (বর্তমান ডাটা)
$tempBackup = $backupDir . 'temp_' . date('Y-m-d_H-i-s') . '.sql';
$command = sprintf(
    'mysqldump --user=%s --password=%s --host=%s %s > %s',
    escapeshellarg(DB_USER),
    escapeshellarg(DB_PASS),
    escapeshellarg(DB_HOST),
    escapeshellarg(DB_NAME),
    escapeshellarg($tempBackup)
);
system($command);

// ডাটাবেজ রিস্টোর
$command = sprintf(
    'mysql --user=%s --password=%s --host=%s %s < %s',
    escapeshellarg(DB_USER),
    escapeshellarg(DB_PASS),
    escapeshellarg(DB_HOST),
    escapeshellarg(DB_NAME),
    escapeshellarg($filepath)
);

system($command, $output);

if ($output == 0) {
    // লগ তৈরি
    $userId = $_SESSION['user_id'];
    $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR']);
    $logSql = "INSERT INTO activity_log (user_id, action, details, ip_address) 
               VALUES ($userId, 'restore_backup', 'Restored backup: $filename', '$ip')";
    $conn->query($logSql);
    
    echo json_encode([
        'success' => true,
        'message' => 'ব্যাকআপ রিস্টোর করা হয়েছে'
    ]);
} else {
    // ব্যর্থ হলে টেম্পোরারি ব্যাকআপ থেকে রিস্টোর
    $command = sprintf(
        'mysql --user=%s --password=%s --host=%s %s < %s',
        escapeshellarg(DB_USER),
        escapeshellarg(DB_PASS),
        escapeshellarg(DB_HOST),
        escapeshellarg(DB_NAME),
        escapeshellarg($tempBackup)
    );
    system($command);
    
    echo json_encode([
        'success' => false,
        'message' => 'রিস্টোর ব্যর্থ হয়েছে'
    ]);
}

// টেম্পোরারি ফাইল ডিলিট
if (file_exists($tempBackup)) {
    unlink($tempBackup);
}