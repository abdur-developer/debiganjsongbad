<?php
// admin/staff/delete.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

$auth->requirePermission('users');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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

header('Location: index.php');
exit();