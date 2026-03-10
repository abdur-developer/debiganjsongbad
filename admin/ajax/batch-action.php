<?php
// admin/ajax/batch-action.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$action = $_POST['action'] ?? '';
$ids = $_POST['ids'] ?? [];
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

if (empty($ids) || empty($action)) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$idList = implode(',', array_map('intval', $ids));

// পারমিশন চেক
$hasPermission = false;
switch ($action) {
    case 'publish':
    case 'draft':
    case 'archive':
    case 'delete':
    case 'featured':
    case 'breaking':
    case 'trending':
        $hasPermission = $auth->hasPermission('news');
        break;
    case 'approve_comments':
    case 'delete_comments':
        $hasPermission = $auth->hasPermission('comments');
        break;
    default:
        $hasPermission = false;
}

if (!$hasPermission && $userRole != 'super_admin') {
    echo json_encode(['success' => false, 'message' => 'Permission denied']);
    exit();
}

$response = ['success' => false, 'message' => ''];

switch ($action) {
    // ==================== নিউজ অ্যাকশন ====================
    case 'publish':
        $sql = "UPDATE news SET status = 'published', published_at = NOW() WHERE id IN ($idList)";
        $message = 'সংবাদ প্রকাশিত হয়েছে';
        $logDetails = "Published news IDs: $idList";
        break;
        
    case 'draft':
        $sql = "UPDATE news SET status = 'draft' WHERE id IN ($idList)";
        $message = 'সংবাদ খসড়া করা হয়েছে';
        $logDetails = "Moved to draft news IDs: $idList";
        break;
        
    case 'archive':
        $sql = "UPDATE news SET status = 'archived' WHERE id IN ($idList)";
        $message = 'সংবাদ আর্কাইভ করা হয়েছে';
        $logDetails = "Archived news IDs: $idList";
        break;
        
    case 'delete':
        // প্রথমে ছবি ডিলিট
        $imgSql = "SELECT featured_image, gallery_images FROM news WHERE id IN ($idList)";
        $imgResult = $conn->query($imgSql);
        while ($row = $imgResult->fetch_assoc()) {
            if ($row['featured_image']) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $row['featured_image'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            if ($row['gallery_images']) {
                $gallery = json_decode($row['gallery_images'], true);
                if (is_array($gallery)) {
                    foreach ($gallery as $img) {
                        $filePath = $_SERVER['DOCUMENT_ROOT'] . $img;
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }
            }
        }
        
        $sql = "DELETE FROM news WHERE id IN ($idList)";
        $message = 'সংবাদ মুছে ফেলা হয়েছে';
        $logDetails = "Deleted news IDs: $idList";
        break;
        
    case 'featured':
        $sql = "UPDATE news SET is_featured = 1 WHERE id IN ($idList)";
        $message = 'ফিচার্ড করা হয়েছে';
        $logDetails = "Featured news IDs: $idList";
        break;
        
    case 'breaking':
        $sql = "UPDATE news SET is_breaking = 1 WHERE id IN ($idList)";
        $message = 'ব্রেকিং নিউজ করা হয়েছে';
        $logDetails = "Breaking news IDs: $idList";
        break;
        
    case 'trending':
        $sql = "UPDATE news SET is_trending = 1 WHERE id IN ($idList)";
        $message = 'ট্রেন্ডিং করা হয়েছে';
        $logDetails = "Trending news IDs: $idList";
        break;
        
    case 'unfeatured':
        $sql = "UPDATE news SET is_featured = 0 WHERE id IN ($idList)";
        $message = 'ফিচার্ড সরানো হয়েছে';
        $logDetails = "Unfeatured news IDs: $idList";
        break;
        
    case 'unbreaking':
        $sql = "UPDATE news SET is_breaking = 0 WHERE id IN ($idList)";
        $message = 'ব্রেকিং সরানো হয়েছে';
        $logDetails = "Unbreaking news IDs: $idList";
        break;
        
    case 'untrending':
        $sql = "UPDATE news SET is_trending = 0 WHERE id IN ($idList)";
        $message = 'ট্রেন্ডিং সরানো হয়েছে';
        $logDetails = "Untrending news IDs: $idList";
        break;
    
    // ==================== ক্যাটাগরি অ্যাকশন ====================
    case 'activate_categories':
        $sql = "UPDATE categories SET status = 'active' WHERE id IN ($idList)";
        $message = 'ক্যাটাগরি সক্রিয় করা হয়েছে';
        $logDetails = "Activated categories IDs: $idList";
        break;
        
    case 'deactivate_categories':
        $sql = "UPDATE categories SET status = 'inactive' WHERE id IN ($idList)";
        $message = 'ক্যাটাগরি নিষ্ক্রিয় করা হয়েছে';
        $logDetails = "Deactivated categories IDs: $idList";
        break;
        
    case 'delete_categories':
        // চেক ক্যাটাগরিতে নিউজ আছে কিনা
        $checkSql = "SELECT COUNT(*) as total FROM news WHERE category_id IN ($idList)";
        $checkResult = $conn->query($checkSql);
        $checkRow = $checkResult->fetch_assoc();
        
        if ($checkRow['total'] > 0) {
            echo json_encode(['success' => false, 'message' => 'এই ক্যাটাগরিতে নিউজ আছে, আগে নিউজ সরান']);
            exit();
        }
        
        $sql = "DELETE FROM categories WHERE id IN ($idList)";
        $message = 'ক্যাটাগরি মুছে ফেলা হয়েছে';
        $logDetails = "Deleted categories IDs: $idList";
        break;
    
    // ==================== ইউজার অ্যাকশন ====================
    case 'activate_users':
        $sql = "UPDATE users SET status = 'active' WHERE id IN ($idList)";
        $message = 'ব্যবহারকারী সক্রিয় করা হয়েছে';
        $logDetails = "Activated users IDs: $idList";
        break;
        
    case 'deactivate_users':
        $sql = "UPDATE users SET status = 'inactive' WHERE id IN ($idList)";
        $message = 'ব্যবহারকারী নিষ্ক্রিয় করা হয়েছে';
        $logDetails = "Deactivated users IDs: $idList";
        break;
        
    case 'ban_users':
        $sql = "UPDATE users SET status = 'banned' WHERE id IN ($idList)";
        $message = 'ব্যবহারকারী নিষিদ্ধ করা হয়েছে';
        $logDetails = "Banned users IDs: $idList";
        break;
        
    case 'delete_users':
        // সুপার অ্যাডমিন ডিলিট না করা
        if (in_array(1, $ids)) {
            echo json_encode(['success' => false, 'message' => 'সুপার অ্যাডমিন ডিলিট করা যাবে না']);
            exit();
        }
        
        $sql = "DELETE FROM users WHERE id IN ($idList)";
        $message = 'ব্যবহারকারী মুছে ফেলা হয়েছে';
        $logDetails = "Deleted users IDs: $idList";
        break;
    
    // ==================== কমেন্ট অ্যাকশন ====================
    case 'approve_comments':
        $sql = "UPDATE comments SET status = 'approved' WHERE id IN ($idList)";
        $message = 'মন্তব্য অনুমোদন করা হয়েছে';
        $logDetails = "Approved comments IDs: $idList";
        break;
        
    case 'pending_comments':
        $sql = "UPDATE comments SET status = 'pending' WHERE id IN ($idList)";
        $message = 'মন্তব্য পেন্ডিং করা হয়েছে';
        $logDetails = "Pending comments IDs: $idList";
        break;
        
    case 'spam_comments':
        $sql = "UPDATE comments SET status = 'spam' WHERE id IN ($idList)";
        $message = 'মন্তব্য স্পাম করা হয়েছে';
        $logDetails = "Spam comments IDs: $idList";
        break;
        
    case 'delete_comments':
        $sql = "DELETE FROM comments WHERE id IN ($idList)";
        $message = 'মন্তব্য মুছে ফেলা হয়েছে';
        $logDetails = "Deleted comments IDs: $idList";
        break;
    
    // ==================== অ্যাড অ্যাকশন ====================
    case 'activate_ads':
        $sql = "UPDATE advertisements SET status = 'active' WHERE id IN ($idList)";
        $message = 'বিজ্ঞাপন সক্রিয় করা হয়েছে';
        $logDetails = "Activated ads IDs: $idList";
        break;
        
    case 'deactivate_ads':
        $sql = "UPDATE advertisements SET status = 'inactive' WHERE id IN ($idList)";
        $message = 'বিজ্ঞাপন নিষ্ক্রিয় করা হয়েছে';
        $logDetails = "Deactivated ads IDs: $idList";
        break;
        
    case 'delete_ads':
        $sql = "DELETE FROM advertisements WHERE id IN ($idList)";
        $message = 'বিজ্ঞাপন মুছে ফেলা হয়েছে';
        $logDetails = "Deleted ads IDs: $idList";
        break;
    
    // ==================== গ্যালারি অ্যাকশন ====================
    case 'activate_gallery':
        $sql = "UPDATE gallery SET status = 'active' WHERE id IN ($idList)";
        $message = 'গ্যালারি ছবি সক্রিয় করা হয়েছে';
        $logDetails = "Activated gallery IDs: $idList";
        break;
        
    case 'deactivate_gallery':
        $sql = "UPDATE gallery SET status = 'inactive' WHERE id IN ($idList)";
        $message = 'গ্যালারি ছবি নিষ্ক্রিয় করা হয়েছে';
        $logDetails = "Deactivated gallery IDs: $idList";
        break;
        
    case 'delete_gallery':
        // প্রথমে ছবি ডিলিট
        $imgSql = "SELECT image FROM gallery WHERE id IN ($idList)";
        $imgResult = $conn->query($imgSql);
        while ($row = $imgResult->fetch_assoc()) {
            if ($row['image']) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $row['image'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        
        $sql = "DELETE FROM gallery WHERE id IN ($idList)";
        $message = 'গ্যালারি ছবি মুছে ফেলা হয়েছে';
        $logDetails = "Deleted gallery IDs: $idList";
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit();
}

if ($conn->query($sql)) {
    // অ্যাক্টিভিটি লগ তৈরি
    $affectedRows = $conn->affected_rows;
    $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR']);
    $logSql = "INSERT INTO activity_log (user_id, action, details, ip_address) 
               VALUES ($userId, 'batch_$action', '$logDetails ($affectedRows items)', '$ip')";
    $conn->query($logSql);
    
    $response = [
        'success' => true,
        'message' => "$affectedRows টি $message",
        'count' => $affectedRows,
        'action' => $action
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'ত্রুটি: ' . $conn->error
    ];
}

echo json_encode($response);