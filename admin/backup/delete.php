<?php
$auth->requirePermission('settings');

$file = $_GET['file'] ?? '';
$file = basename($file); // সিকিউরিটি

$backupDir = $_SERVER['DOCUMENT_ROOT'] . '/backups/';
$filepath = $backupDir . $file;

if (file_exists($filepath)) {
    unlink($filepath);
    $_SESSION['success'] = 'ব্যাকআপ ফাইল মুছে ফেলা হয়েছে';
}

echo "<script>window.location.href = 'index.php?q=backup';</script>";
exit();