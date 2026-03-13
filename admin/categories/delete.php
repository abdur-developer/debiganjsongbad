<?php
$auth->requirePermission('categories');

$id = isset($_GET['delete_id']) ? intval($_GET['delete_id']) : 0;

if (!$id) {
    echo "<script>window.location.href = 'index.php?q=categories';</script>";
    exit();
}

// চেক ক্যাটাগরিতে নিউজ আছে কিনা
$checkSql = "SELECT COUNT(*) as total FROM news WHERE category_id = $id";
$checkResult = $conn->query($checkSql);
$checkRow = $checkResult->fetch_assoc();

if ($checkRow['total'] > 0) {
    $_SESSION['error'] = 'এই ক্যাটাগরিতে নিউজ আছে, আগে নিউজ সরান';
    echo "<script>window.location.href = 'index.php?q=categories';</script>";
    exit();
}

// ডিলিট
$sql = "DELETE FROM categories WHERE id = $id";

if ($conn->query($sql)) {
    $_SESSION['success'] = 'ক্যাটাগরি মুছে ফেলা হয়েছে';
} else {
    $_SESSION['error'] = 'ত্রুটি: ' . $conn->error;
}

echo "<script>window.location.href = 'index.php?q=categories';</script>";
exit();