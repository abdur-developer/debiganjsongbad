<?php
// admin_ads.php
require_once 'config.php';

// অ্যাডমিন চেক (আপনার অথেনটিকেশন সিস্টেম অনুযায়ী)
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// অ্যাড ডিলিট
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM ads WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    header('Location: admin_ads.php');
    exit;
}

// অ্যাড স্ট্যাটাস টগল
if(isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $sql = "UPDATE ads SET status = NOT status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    header('Location: admin_ads.php');
    exit;
}

// অ্যাড লিস্ট
$sql = "SELECT * FROM ads ORDER BY ad_position, priority, display_order";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$ads = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাড ম্যানেজমেন্ট - অ্যাডমিন প্যানেল</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f0f0f0;
        }
        .btn {
            padding: 5px 10px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin: 0 2px;
            display: inline-block;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-success {
            background: #28a745;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
        }
        .add-btn {
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>অ্যাড ম্যানেজমেন্ট সিস্টেম</h1>
        <a href="admin_add_ad.php" class="btn add-btn">+ নতুন অ্যাড যোগ করুন</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>অ্যাড নাম</th>
                    <th>পজিশন</th>
                    <th>সাইজ</th>
                    <th>ইম্প্রেশন</th>
                    <th>ক্লিক</th>
                    <th>লিমিট (Imp/Click)</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ads as $ad): ?>
                <tr>
                    <td><?php echo $ad['id']; ?></td>
                    <td><?php echo htmlspecialchars($ad['ad_name']); ?></td>
                    <td><?php echo $ad['ad_position']; ?></td>
                    <td><?php echo $ad['ad_size']; ?></td>
                    <td><?php echo $ad['current_impressions']; ?> / <?php echo $ad['max_impressions'] ?: '∞'; ?></td>
                    <td><?php echo $ad['current_clicks']; ?> / <?php echo $ad['max_clicks'] ?: '∞'; ?></td>
                    <td><?php echo $ad['max_impressions'] ?: '∞'; ?> / <?php echo $ad['max_clicks'] ?: '∞'; ?></td>
                    <td class="<?php echo $ad['status'] ? 'status-active' : 'status-inactive'; ?>">
                        <?php echo $ad['status'] ? 'সক্রিয়' : 'নিষ্ক্রিয়'; ?>
                    </td>
                    <td>
                        <a href="admin_edit_ad.php?id=<?php echo $ad['id']; ?>" class="btn">এডিট</a>
                        <a href="?toggle=<?php echo $ad['id']; ?>" class="btn btn-success">টগল</a>
                        <a href="?delete=<?php echo $ad['id']; ?>" class="btn btn-danger" onclick="return confirm('ডিলিট করবেন?')">ডিলিট</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>