<?php
$auth->requirePermission('users');

$id = isset($_GET['delete_id']) ? intval($_GET['delete_id']) : 0;

if ($id) {
    $imgSql = "SELECT image FROM staffs WHERE id = $id";
    $imgResult = $conn->query($imgSql);
    if ($imgResult->num_rows > 0) {
        $staff = $imgResult->fetch_assoc();
        if (!empty($staff['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $staff['image'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $staff['image']);
        }
    }
    
    $sql = "DELETE FROM staffs WHERE id = $id";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'স্টাফ মুছে ফেলা হয়েছে';
    } else {
        $_SESSION['error'] = 'ত্রুটি: ' . $conn->error;
    }
}

echo "<script>window.location.href = 'index.php?q=staff';</script>";
exit();