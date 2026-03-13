<?php
$auth->requirePermission('gallery');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    echo "<script>window.location.href = 'index.php?q=gallery';</script>";
    exit();
}

// ছবির তথ্য
$sql = "SELECT image FROM gallery WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $image = $result->fetch_assoc();
    
    // ফাইল ডিলিট
    if (!empty($image['image'])) {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . $image['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    
    // ডাটাবেজ থেকে ডিলিট
    $deleteSql = "DELETE FROM gallery WHERE id = $id";
    
    if ($conn->query($deleteSql)) {
        $_SESSION['success'] = 'ছবি মুছে ফেলা হয়েছে';
    } else {
        $_SESSION['error'] = 'ত্রুটি: ' . $conn->error;
    }
} else {
    $_SESSION['error'] = 'ছবি পাওয়া যায়নি';
}

echo "<script>window.location.href = 'index.php?q=gallery';</script>";
exit();