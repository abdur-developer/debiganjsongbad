<?php
// admin/ajax/import.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (!isset($_FILES['import_file'])) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit();
}

$file = $_FILES['import_file'];
$importType = $_POST['import_type'] ?? 'news';
$userId = $_SESSION['user_id'];

// ফাইল টাইপ চেক
$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($extension, ['csv', 'json', 'xml'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only CSV, JSON, XML allowed']);
    exit();
}

$imported = 0;
$errors = [];

switch ($importType) {
    case 'news':
        if ($extension == 'csv') {
            $result = importNewsFromCSV($file['tmp_name'], $conn, $userId);
        } elseif ($extension == 'json') {
            $result = importNewsFromJSON($file['tmp_name'], $conn, $userId);
        }
        break;
        
    case 'categories':
        if ($extension == 'csv') {
            $result = importCategoriesFromCSV($file['tmp_name'], $conn, $userId);
        }
        break;
        
    case 'users':
        if ($extension == 'csv') {
            $result = importUsersFromCSV($file['tmp_name'], $conn, $userId);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid import type']);
        exit();
}

if ($result['success']) {
    // লগ তৈরি
    $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR']);
    $logSql = "INSERT INTO activity_log (user_id, action, details, ip_address) 
               VALUES ($userId, 'import_$importType', 'Imported {$result['count']} items', '$ip')";
    $conn->query($logSql);
}

echo json_encode($result);

// ==================== ফাংশন ====================

function importNewsFromCSV($filepath, $conn, $userId) {
    $handle = fopen($filepath, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $errors = [];
    
    while (($data = fgetcsv($handle)) !== FALSE) {
        $row = array_combine($header, $data);
        
        $title_bn = $conn->real_escape_string($row['title_bn'] ?? '');
        $content = $conn->real_escape_string($row['content'] ?? '');
        $category_id = intval($row['category_id'] ?? 0);
        $status = $conn->real_escape_string($row['status'] ?? 'draft');
        
        if (empty($title_bn)) {
            $errors[] = "Line " . ($imported + 2) . ": Title required";
            continue;
        }
        
        $slug = createSlug($title_bn);
        
        $sql = "INSERT INTO news (title_bn, content, category_id, author_id, status, slug, created_at) 
                VALUES ('$title_bn', '$content', $category_id, $userId, '$status', '$slug', NOW())";
        
        if ($conn->query($sql)) {
            $imported++;
        } else {
            $errors[] = "Line " . ($imported + 2) . ": " . $conn->error;
        }
    }
    
    fclose($handle);
    
    return [
        'success' => true,
        'count' => $imported,
        'errors' => $errors,
        'message' => "$imported টি নিউজ ইম্পোর্ট করা হয়েছে"
    ];
}

function importNewsFromJSON($filepath, $conn, $userId) {
    $json = file_get_contents($filepath);
    $data = json_decode($json, true);
    $imported = 0;
    $errors = [];
    
    foreach ($data as $row) {
        $title_bn = $conn->real_escape_string($row['title_bn'] ?? '');
        $content = $conn->real_escape_string($row['content'] ?? '');
        $category_id = intval($row['category_id'] ?? 0);
        $status = $conn->real_escape_string($row['status'] ?? 'draft');
        
        if (empty($title_bn)) {
            $errors[] = "Item " . ($imported + 1) . ": Title required";
            continue;
        }
        
        $slug = createSlug($title_bn);
        
        $sql = "INSERT INTO news (title_bn, content, category_id, author_id, status, slug, created_at) 
                VALUES ('$title_bn', '$content', $category_id, $userId, '$status', '$slug', NOW())";
        
        if ($conn->query($sql)) {
            $imported++;
        } else {
            $errors[] = "Item " . ($imported + 1) . ": " . $conn->error;
        }
    }
    
    return [
        'success' => true,
        'count' => $imported,
        'errors' => $errors,
        'message' => "$imported টি নিউজ ইম্পোর্ট করা হয়েছে"
    ];
}

function importCategoriesFromCSV($filepath, $conn, $userId) {
    $handle = fopen($filepath, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $errors = [];
    
    while (($data = fgetcsv($handle)) !== FALSE) {
        $row = array_combine($header, $data);
        
        $name_bn = $conn->real_escape_string($row['name_bn'] ?? '');
        $name_en = $conn->real_escape_string($row['name_en'] ?? '');
        $parent_id = intval($row['parent_id'] ?? 0);
        
        if (empty($name_bn)) {
            $errors[] = "Line " . ($imported + 2) . ": Name required";
            continue;
        }
        
        $slug = createSlug($name_en ?: $name_bn);
        
        $sql = "INSERT INTO categories (name_bn, name_en, slug, parent_id, created_by, created_at) 
                VALUES ('$name_bn', '$name_en', '$slug', $parent_id, $userId, NOW())";
        
        if ($conn->query($sql)) {
            $imported++;
        } else {
            $errors[] = "Line " . ($imported + 2) . ": " . $conn->error;
        }
    }
    
    fclose($handle);
    
    return [
        'success' => true,
        'count' => $imported,
        'errors' => $errors,
        'message' => "$imported টি ক্যাটাগরি ইম্পোর্ট করা হয়েছে"
    ];
}

function importUsersFromCSV($filepath, $conn, $userId) {
    $handle = fopen($filepath, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $errors = [];
    
    while (($data = fgetcsv($handle)) !== FALSE) {
        $row = array_combine($header, $data);
        
        $username = $conn->real_escape_string($row['username'] ?? '');
        $email = $conn->real_escape_string($row['email'] ?? '');
        $full_name = $conn->real_escape_string($row['full_name'] ?? '');
        $password = password_hash($row['password'] ?? '123456', PASSWORD_DEFAULT);
        $role = $conn->real_escape_string($row['role'] ?? 'reporter');
        
        if (empty($username) || empty($email)) {
            $errors[] = "Line " . ($imported + 2) . ": Username and email required";
            continue;
        }
        
        // চেক ডুপ্লিকেট
        $checkSql = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
        $checkResult = $conn->query($checkSql);
        if ($checkResult->num_rows > 0) {
            $errors[] = "Line " . ($imported + 2) . ": Username or email already exists";
            continue;
        }
        
        $sql = "INSERT INTO users (username, email, password, full_name, role, created_at) 
                VALUES ('$username', '$email', '$password', '$full_name', '$role', NOW())";
        
        if ($conn->query($sql)) {
            $imported++;
        } else {
            $errors[] = "Line " . ($imported + 2) . ": " . $conn->error;
        }
    }
    
    fclose($handle);
    
    return [
        'success' => true,
        'count' => $imported,
        'errors' => $errors,
        'message' => "$imported টি ইউজার ইম্পোর্ট করা হয়েছে"
    ];
}

function createSlug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}