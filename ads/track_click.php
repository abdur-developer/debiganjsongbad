<?php
// track_click.php
session_start();
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ad_id'])) {
    $adId = intval($_POST['ad_id']);
    
    // ক্লিক আপডেট করুন
    updateClick($adId);
    
    // JSON রেসপন্স
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
} else {
    header('HTTP/1.0 403 Forbidden');
    echo 'Access denied';
}
?>