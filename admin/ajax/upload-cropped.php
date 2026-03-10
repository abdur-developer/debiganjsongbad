<?php
// admin/ajax/upload-cropped.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (!isset($_FILES['cropped_image'])) {
    echo json_encode(['success' => false, 'message' => 'No image uploaded']);
    exit();
}

$file = $_FILES['cropped_image'];
$userId = $_SESSION['user_id'];

// ফাইল ভ্যালিডেশন
$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
$maxSize = 5 * 1024 * 1024; // 5MB

if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type']);
    exit();
}

if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'File too large']);
    exit();
}

// আপলোড ডিরেক্টরি
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/cropped/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// ফাইল নাম জেনারেট
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = time() . '_' . uniqid() . '.' . $extension;
$filepath = $uploadDir . $filename;
$relativePath = '/uploads/cropped/' . $filename;

if (move_uploaded_file($file['tmp_name'], $filepath)) {
    // ডাটাবেজে সেভ
    $title = 'Cropped image ' . date('Y-m-d H:i:s');
    $title_bn = 'ক্রপ করা ছবি ' . date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO gallery (title_bn, title_en, image, uploaded_by, status, created_at) 
            VALUES ('$title_bn', '$title', '$relativePath', $userId, 'active', NOW())";
    
    if ($conn->query($sql)) {
        $galleryId = $conn->insert_id;
        
        echo json_encode([
            'success' => true,
            'message' => 'ছবি আপলোড হয়েছে',
            'image_id' => $galleryId,
            'image_url' => $relativePath
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Upload failed']);
}