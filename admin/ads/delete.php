<?php
$auth->requirePermission('ads');

$id = isset($_GET['delete_id']) ? intval($_GET['delete_id']) : 0;

if ($id) {
    // ছবি ডিলিট
    $imgSql = "SELECT image FROM advertisements WHERE id = $id";
    $imgResult = $conn->query($imgSql);
    if ($imgResult->num_rows > 0) {
        $ad = $imgResult->fetch_assoc();
        if (!empty($ad['image'])) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . $ad['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
    
    $sql = "DELETE FROM advertisements WHERE id = $id";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'বিজ্ঞাপন মুছে ফেলা হয়েছে';
    }
}

echo "<script>window.location.href = 'index.php?q=ads';</script>";
exit();