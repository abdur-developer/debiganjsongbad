<?php
// admin/categories/delete.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

$auth->requirePermission('categories');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    header('Location: index.php');
    exit();
}

// চেক ক্যাটাগরিতে নিউজ আছে কিনা
$checkSql = "SELECT COUNT(*) as total FROM news WHERE category_id = $id";
$checkResult = $conn->query($checkSql);
$checkRow = $checkResult->fetch_assoc();

if ($checkRow['total'] > 0) {
    $_SESSION['error'] = 'এই ক্যাটাগরিতে নিউজ আছে, আগে নিউজ সরান';
    header('Location: index.php');
    exit();
}

// ডিলিট
$sql = "DELETE FROM categories WHERE id = $id";

if ($conn->query($sql)) {
    $_SESSION['success'] = 'ক্যাটাগরি মুছে ফেলা হয়েছে';
} else {
    $_SESSION['error'] = 'ত্রুটি: ' . $conn->error;
}

header('Location: index.php');
exit();