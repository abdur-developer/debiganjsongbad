<?php
// admin.php - অ্যাড ম্যানেজ করতে
require_once 'config.php';

// পাসওয়ার্ড প্রোটেক্ট (সিম্পল)
if(!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Access denied';
    exit;
} else {
    if($_SERVER['PHP_AUTH_USER'] != 'admin' || $_SERVER['PHP_AUTH_PW'] != 'admin123') {
        header('WWW-Authenticate: Basic realm="Admin Area"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Invalid credentials';
        exit;
    }
}

// অ্যাড ডিলিট
if(isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM ads WHERE id = ?")->execute([$_GET['delete']]);
    header('Location: admin.php');
    exit;
}

// অ্যাড স্ট্যাটাস টগল
if(isset($_GET['toggle'])) {
    $pdo->prepare("UPDATE ads SET status = NOT status WHERE id = ?")->execute([$_GET['toggle']]);
    header('Location: admin.php');
    exit;
}

// নতুন অ্যাড যোগ
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO ads (ad_name, ad_code, ad_position, ad_size, device_type, priority, display_order) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['ad_name'],
        $_POST['ad_code'],
        $_POST['ad_position'],
        $_POST['ad_size'],
        $_POST['device_type'],
        $_POST['priority'],
        $_POST['display_order']
    ]);
    header('Location: admin.php');
    exit;
}

// সব অ্যাড লিস্ট
$ads = $pdo->query("SELECT * FROM ads ORDER BY ad_position, priority")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>অ্যাডমিন প্যানেল</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin: 2px;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-success {
            background: #28a745;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        textarea {
            height: 150px;
        }
        .status-active {
            color: green;
        }
        .status-inactive {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>অ্যাড ম্যানেজমেন্ট</h1>
        
        <!-- অ্যাড যোগ ফর্ম -->
        <h2>নতুন অ্যাড যোগ করুন</h2>
        <form method="POST">
            <div class="form-group">
                <label>অ্যাড নাম</label>
                <input type="text" name="ad_name" required>
            </div>
            
            <div class="form-group">
                <label>অ্যাড কোড (Google AdSense)</label>
                <textarea name="ad_code" required></textarea>
            </div>
            
            <div class="form-group">
                <label>পজিশন</label>
                <select name="ad_position">
                    <option value="header">হেডার</option>
                    <option value="sidebar">সাইডবার</option>
                    <option value="content_middle">কন্টেন্টের মধ্যে</option>
                    <option value="footer">ফুটার</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>সাইজ (যেমন: 728x90)</label>
                <input type="text" name="ad_size">
            </div>
            
            <div class="form-group">
                <label>ডিভাইস</label>
                <select name="device_type">
                    <option value="all">সব</option>
                    <option value="desktop">ডেস্কটপ</option>
                    <option value="mobile">মোবাইল</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>প্রায়োরিটি (০ = বেশি)</label>
                <input type="number" name="priority" value="0">
            </div>
            
            <div class="form-group">
                <label>ডিসপ্লে অর্ডার</label>
                <input type="number" name="display_order" value="0">
            </div>
            
            <button type="submit" name="add" class="btn">অ্যাড যোগ করুন</button>
        </form>
        
        <hr>
        
        <!-- অ্যাড লিস্ট -->
        <h2>অ্যাড লিস্ট</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>নাম</th>
                    <th>পজিশন</th>
                    <th>ইম্প্রেশন</th>
                    <th>ক্লিক</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ads as $ad): ?>
                <tr>
                    <td><?= $ad['id'] ?></td>
                    <td><?= htmlspecialchars($ad['ad_name']) ?></td>
                    <td><?= $ad['ad_position'] ?></td>
                    <td><?= $ad['current_impressions'] ?></td>
                    <td><?= $ad['current_clicks'] ?></td>
                    <td class="<?= $ad['status'] ? 'status-active' : 'status-inactive' ?>">
                        <?= $ad['status'] ? 'সক্রিয়' : 'নিষ্ক্রিয়' ?>
                    </td>
                    <td>
                        <a href="?toggle=<?= $ad['id'] ?>" class="btn btn-success">টগল</a>
                        <a href="?delete=<?= $ad['id'] ?>" class="btn btn-danger" onclick="return confirm('ডিলিট করবেন?')">ডিলিট</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>