<?php
// admin/news/delete.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

$auth->requirePermission('news');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    header('Location: index.php');
    exit();
}

// নিউজ তথ্য
$sql = "SELECT featured_image, gallery_images FROM news WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $news = $result->fetch_assoc();
    
    // ফিচার ইমেজ ডিলিট
    if (!empty($news['featured_image'])) {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . $news['featured_image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    
    // গ্যালারি ইমেজ ডিলিট
    if (!empty($news['gallery_images'])) {
        $gallery = json_decode($news['gallery_images'], true);
        if (is_array($gallery)) {
            foreach ($gallery as $img) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $img;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
    
    // কমেন্ট ডিলিট
    $conn->query("DELETE FROM comments WHERE news_id = $id");
    
    // নিউজ ডিলিট
    $deleteSql = "DELETE FROM news WHERE id = $id";
    
    if ($conn->query($deleteSql)) {
        $_SESSION['success'] = 'সংবাদ মুছে ফেলা হয়েছে';
    } else {
        $_SESSION['error'] = 'ত্রুটি: ' . $conn->error;
    }
} else {
    $_SESSION['error'] = 'সংবাদ পাওয়া যায়নি';
}

header('Location: index.php');
exit();