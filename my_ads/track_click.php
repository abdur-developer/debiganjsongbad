<?php
// track_click.php
require_once 'config.php';

if(isset($_POST['ad_id'])) {
    $ad_id = (int)$_POST['ad_id'];
    
    // ক্লিক আপডেট
    $stmt = $pdo->prepare("UPDATE ads SET current_clicks = current_clicks + 1 WHERE id = ?");
    $stmt->execute([$ad_id]);
    
    echo 'ok';
} else {
    echo 'error';
}
?>