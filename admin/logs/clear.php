<?php
$auth->requirePermission('settings');

// ৩০ দিনের পুরাতন লগ ডিলিট
$sql = "DELETE FROM activity_log WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)";

if ($conn->query($sql)) {
    $_SESSION['success'] = 'পুরাতন লগ মুছে ফেলা হয়েছে';
} else {
    $_SESSION['error'] = 'ত্রুটি: ' . $conn->error;
}

echo "<script>window.location.href = 'index.php?q=logs';</script>";
exit();