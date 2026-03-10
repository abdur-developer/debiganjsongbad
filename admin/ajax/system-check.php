<?php
// admin/ajax/system-check.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$checks = [];

// ==================== PHP ভার্সন চেক ====================
$phpVersion = phpversion();
$checks['PHP Version'] = [
    'status' => version_compare($phpVersion, '7.4.0', '>=') ? 'ok' : 'warning',
    'message' => $phpVersion . (version_compare($phpVersion, '7.4.0', '>=') ? ' (OK)' : ' (7.4+ প্রয়োজন)')
];

// ==================== MySQL সংযোগ চেক ====================
if ($conn->ping()) {
    $mysqlVersion = $conn->query("SELECT VERSION() as version")->fetch_assoc()['version'];
    $checks['MySQL Connection'] = [
        'status' => 'ok',
        'message' => $mysqlVersion . ' (সংযোগ সক্রিয়)'
    ];
} else {
    $checks['MySQL Connection'] = [
        'status' => 'error',
        'message' => 'সংযোগ ব্যর্থ'
    ];
}

// ==================== প্রয়োজনীয় এক্সটেনশন চেক ====================
$requiredExtensions = ['mysqli', 'json', 'gd', 'mbstring', 'curl', 'fileinfo'];
foreach ($requiredExtensions as $ext) {
    $checks[$ext . ' Extension'] = [
        'status' => extension_loaded($ext) ? 'ok' : 'error',
        'message' => extension_loaded($ext) ? 'লোড করা আছে' : 'লোড করা নেই'
    ];
}

// ==================== ডিরেক্টরি পারমিশন চেক ====================
$dirs = [
    '/uploads/' => 'uploads',
    '/uploads/news/' => 'news uploads',
    '/uploads/gallery/' => 'gallery uploads',
    '/cache/' => 'cache',
    '/backups/' => 'backups'
];

foreach ($dirs as $dir => $label) {
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $dir;
    
    if (!file_exists($fullPath)) {
        $checks[$label . ' Directory'] = [
            'status' => 'warning',
            'message' => 'ডিরেক্টরি নেই, তৈরি করার চেষ্টা করুন'
        ];
        @mkdir($fullPath, 0777, true);
    } elseif (!is_writable($fullPath)) {
        $checks[$label . ' Directory'] = [
            'status' => 'error',
            'message' => 'রাইট করা যাচ্ছে না (পারমিশন ৭৭৫ দিন)'
        ];
    } else {
        $checks[$label . ' Directory'] = [
            'status' => 'ok',
            'message' => 'রাইট করা যাচ্ছে'
        ];
    }
}

// ==================== মেমরি লিমিট চেক ====================
$memoryLimit = ini_get('memory_limit');
$checks['Memory Limit'] = [
    'status' => intval($memoryLimit) >= 128 ? 'ok' : 'warning',
    'message' => $memoryLimit . (intval($memoryLimit) >= 128 ? ' (OK)' : ' (১২৮M+ প্রয়োজন)')
];

// ==================== আপলোড সাইজ লিমিট চেক ====================
$uploadMax = ini_get('upload_max_filesize');
$postMax = ini_get('post_max_size');
$checks['Upload Max Size'] = [
    'status' => intval($uploadMax) >= 5 ? 'ok' : 'warning',
    'message' => $uploadMax . (intval($uploadMax) >= 5 ? ' (OK)' : ' (৫M+ প্রয়োজন)')
];

$checks['Post Max Size'] = [
    'status' => intval($postMax) >= 8 ? 'ok' : 'warning',
    'message' => $postMax . (intval($postMax) >= 8 ? ' (OK)' : ' (৮M+ প্রয়োজন)')
];

// ==================== সর্বোচ্চ এক্সিকিউশন টাইম চেক ====================
$maxExecTime = ini_get('max_execution_time');
$checks['Max Execution Time'] = [
    'status' => $maxExecTime >= 120 || $maxExecTime == 0 ? 'ok' : 'warning',
    'message' => $maxExecTime . ' seconds' . ($maxExecTime >= 120 ? ' (OK)' : ' (১২০+ প্রয়োজন)')
];

// ==================== ডাটাবেজ টেবিল চেক ====================
$tables = ['users', 'news', 'categories', 'comments', 'gallery', 'settings', 'activity_log'];
$missingTables = [];

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows == 0) {
        $missingTables[] = $table;
    }
}

$checks['Database Tables'] = [
    'status' => empty($missingTables) ? 'ok' : 'error',
    'message' => empty($missingTables) ? 'সব টেবিল আছে' : 'টেবিল নেই: ' . implode(', ', $missingTables)
];

// ==================== রেকর্ড কাউন্ট চেক ====================
$counts = [];
$counts['users'] = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$counts['news'] = $conn->query("SELECT COUNT(*) as total FROM news")->fetch_assoc()['total'];
$counts['categories'] = $conn->query("SELECT COUNT(*) as total FROM categories")->fetch_assoc()['total'];

$checks['Total Records'] = [
    'status' => 'info',
    'message' => "ইউজার: {$counts['users']}, নিউজ: {$counts['news']}, ক্যাটাগরি: {$counts['categories']}"
];

// ==================== শেষ ব্যাকআপ চেক ====================
$backupDir = $_SERVER['DOCUMENT_ROOT'] . '/backups/';
if (file_exists($backupDir)) {
    $backups = glob($backupDir . '*.sql');
    if (!empty($backups)) {
        $latest = max(array_map('filemtime', $backups));
        $checks['Latest Backup'] = [
            'status' => (time() - $latest) < 7 * 24 * 3600 ? 'ok' : 'warning',
            'message' => date('Y-m-d H:i:s', $latest) . ((time() - $latest) < 7 * 24 * 3600 ? ' (রিসেন্ট)' : ' (৭ দিনের পুরাতন)')
        ];
    } else {
        $checks['Latest Backup'] = [
            'status' => 'warning',
            'message' => 'কোন ব্যাকআপ নেই'
        ];
    }
}

echo json_encode($checks);