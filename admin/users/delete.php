<?php
$auth->requirePermission('users');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id || $id == 1 || $id == $_SESSION['user_id']) {
    $_SESSION['error'] = 'এই ব্যবহারকারী ডিলিট করা যাবে না';
    echo "<script>window.location.href = 'index.php?q=users';</script>";
    exit();
}

// ছবি ডিলিট
$imgSql = "SELECT avatar FROM users WHERE id = $id";
$imgResult = $conn->query($imgSql);
if ($imgResult->num_rows > 0) {
    $user = $imgResult->fetch_assoc();
    if (!empty($user['avatar'])) {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . $user['avatar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

// ডিলিট
$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql)) {
    $_SESSION['success'] = 'ব্যবহারকারী মুছে ফেলা হয়েছে';
} else {
    $_SESSION['error'] = 'ত্রুটি: ' . $conn->error;
}

echo "<script>window.location.href = 'index.php?q=users';</script>";
exit();