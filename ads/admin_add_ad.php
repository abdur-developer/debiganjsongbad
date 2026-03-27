<?php
// admin_add_ad.php
require_once 'config.php';

session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad_name = $_POST['ad_name'];
    $ad_code = $_POST['ad_code'];
    $ad_position = $_POST['ad_position'];
    $ad_size = $_POST['ad_size'];
    $device_type = $_POST['device_type'];
    $priority = $_POST['priority'];
    $display_order = $_POST['display_order'];
    $max_impressions = $_POST['max_impressions'] ?: 0;
    $max_clicks = $_POST['max_clicks'] ?: 0;
    $status = isset($_POST['status']) ? 1 : 0;
    
    $sql = "INSERT INTO ads (ad_name, ad_code, ad_position, ad_size, device_type, 
            priority, display_order, max_impressions, max_clicks, status) 
            VALUES (:ad_name, :ad_code, :ad_position, :ad_size, :device_type, 
            :priority, :display_order, :max_impressions, :max_clicks, :status)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':ad_name' => $ad_name,
        ':ad_code' => $ad_code,
        ':ad_position' => $ad_position,
        ':ad_size' => $ad_size,
        ':device_type' => $device_type,
        ':priority' => $priority,
        ':display_order' => $display_order,
        ':max_impressions' => $max_impressions,
        ':max_clicks' => $max_clicks,
        ':status' => $status
    ]);
    
    header('Location: admin_ads.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নতুন অ্যাড যোগ করুন</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        textarea {
            height: 200px;
            font-family: monospace;
        }
        button {
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>নতুন অ্যাড যোগ করুন</h1>
        <form method="POST">
            <div class="form-group">
                <label>অ্যাড নাম</label>
                <input type="text" name="ad_name" required>
            </div>
            
            <div class="form-group">
                <label>অ্যাড কোড (Google AdSense কোড)</label>
                <textarea name="ad_code" required></textarea>
            </div>
            
            <div class="form-group">
                <label>পজিশন</label>
                <select name="ad_position">
                    <option value="header">হেডার</option>
                    <option value="sidebar">সাইডবার</option>
                    <option value="content_top">কন্টেন্ট টপ</option>
                    <option value="content_middle">কন্টেন্ট মিডল</option>
                    <option value="content_bottom">কন্টেন্ট বটম</option>
                    <option value="footer">ফুটার</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>অ্যাড সাইজ</label>
                <input type="text" name="ad_size" placeholder="যেমন: 728x90, 300x250">
            </div>
            
            <div class="form-group">
                <label>ডিভাইস টাইপ</label>
                <select name="device_type">
                    <option value="all">সব ডিভাইস</option>
                    <option value="desktop">ডেস্কটপ</option>
                    <option value="mobile">মোবাইল</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>প্রায়োরিটি (ছোট সংখ্যা = বেশি প্রায়োরিটি)</label>
                <input type="number" name="priority" value="0">
            </div>
            
            <div class="form-group">
                <label>ডিসপ্লে অর্ডার</label>
                <input type="number" name="display_order" value="0">
            </div>
            
            <div class="form-group">
                <label>ম্যাক্সিমাম ইম্প্রেশন (0 = আনলিমিটেড)</label>
                <input type="number" name="max_impressions" value="0">
            </div>
            
            <div class="form-group">
                <label>ম্যাক্সিমাম ক্লিক (0 = আনলিমিটেড)</label>
                <input type="number" name="max_clicks" value="0">
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="status" checked> সক্রিয় করুন
                </label>
            </div>
            
            <button type="submit">অ্যাড সংরক্ষণ করুন</button>
        </form>
    </div>
</body>
</html>