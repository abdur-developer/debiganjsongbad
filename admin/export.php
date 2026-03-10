<?php
// admin/export.php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

$auth->requireLogin();

$type = $_GET['type'] ?? 'news';
$from = $_GET['from'] ?? date('Y-m-d', strtotime('-30 days'));
$to = $_GET['to'] ?? date('Y-m-d');

// ফাইল নাম
$filename = $type . '_' . date('Y-m-d') . '.csv';

// হেডার সেট
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// আউটপুট ফাইল
$output = fopen('php://output', 'w');

// BOM যোগ (UTF-8 এর জন্য)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

switch ($type) {
    case 'news':
        exportNews($output, $conn, $from, $to);
        break;
    case 'categories':
        exportCategories($output, $conn);
        break;
    case 'users':
        exportUsers($output, $conn);
        break;
    case 'comments':
        exportComments($output, $conn, $from, $to);
        break;
    case 'gallery':
        exportGallery($output, $conn);
        break;
    default:
        exportNews($output, $conn, $from, $to);
}

fclose($output);

// ==================== এক্সপোর্ট ফাংশন ====================

function exportNews($output, $conn, $from, $to) {
    // হেডার
    fputcsv($output, ['ID', 'শিরোনাম (বাংলা)', 'শিরোনাম (ইংরেজি)', 'ক্যাটাগরি', 'লেখক', 'স্ট্যাটাস', 'ভিউ', 'তারিখ']);
    
    $sql = "SELECT n.*, c.name_bn as category_name, u.full_name as author_name 
            FROM news n 
            LEFT JOIN categories c ON n.category_id = c.id 
            LEFT JOIN users u ON n.author_id = u.id 
            WHERE DATE(n.created_at) BETWEEN '$from' AND '$to'
            ORDER BY n.created_at DESC";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['title_bn'],
            $row['title_en'],
            $row['category_name'],
            $row['author_name'],
            $row['status'],
            $row['views'],
            $row['created_at']
        ]);
    }
}

function exportCategories($output, $conn) {
    fputcsv($output, ['ID', 'নাম (বাংলা)', 'নাম (ইংরেজি)', 'স্লাগ', 'প্যারেন্ট', 'স্ট্যাটাস']);
    
    $sql = "SELECT * FROM categories ORDER BY id";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['name_bn'],
            $row['name_en'],
            $row['slug'],
            $row['parent_id'],
            $row['status']
        ]);
    }
}

function exportUsers($output, $conn) {
    fputcsv($output, ['ID', 'ইউজারনেম', 'ইমেইল', 'নাম', 'রোল', 'স্ট্যাটাস', 'লাস্ট লগিন']);
    
    $sql = "SELECT * FROM users ORDER BY id";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['username'],
            $row['email'],
            $row['full_name'],
            $row['role'],
            $row['status'],
            $row['last_login']
        ]);
    }
}

function exportComments($output, $conn, $from, $to) {
    fputcsv($output, ['ID', 'নিউজ', 'নাম', 'ইমেইল', 'মন্তব্য', 'স্ট্যাটাস', 'তারিখ']);
    
    $sql = "SELECT c.*, n.title_bn as news_title 
            FROM comments c 
            LEFT JOIN news n ON c.news_id = n.id 
            WHERE DATE(c.created_at) BETWEEN '$from' AND '$to'
            ORDER BY c.created_at DESC";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['news_title'],
            $row['name'],
            $row['email'],
            $row['comment'],
            $row['status'],
            $row['created_at']
        ]);
    }
}

function exportGallery($output, $conn) {
    fputcsv($output, ['ID', 'শিরোনাম (বাংলা)', 'শিরোনাম (ইংরেজি)', 'ছবি', 'আপলোডকারী', 'তারিখ']);
    
    $sql = "SELECT g.*, u.full_name as uploader 
            FROM gallery g 
            LEFT JOIN users u ON g.uploaded_by = u.id 
            ORDER BY g.created_at DESC";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['title_bn'],
            $row['title_en'],
            $row['image'],
            $row['uploader'],
            $row['created_at']
        ]);
    }
}