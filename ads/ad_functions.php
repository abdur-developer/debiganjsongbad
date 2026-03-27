<?php
// ad_functions.php

// ডিভাইস চেনার ফাংশন
function getDevice() {
    $mobile = ['Android', 'iPhone', 'iPad', 'Mobile', 'BlackBerry'];
    foreach($mobile as $device) {
        if(stripos($_SERVER['HTTP_USER_AGENT'], $device) !== false) {
            return 'mobile';
        }
    }
    return 'desktop';
}

// অ্যাড দেখানোর ফাংশন
function showAds($position, $limit = null) {
    global $pdo;
    
    $device = getDevice();
    $html = '';
    
    $sql = "SELECT * FROM ads 
            WHERE ad_position = :position 
            AND status = 1 
            AND (device_type = 'all' OR device_type = :device)
            AND (start_date IS NULL OR start_date <= NOW())
            AND (end_date IS NULL OR end_date >= NOW())
            ORDER BY priority ASC, display_order ASC";
    
    if($limit) {
        $sql .= " LIMIT $limit";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':position' => $position,
        ':device' => $device
    ]);
    
    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($ads as $ad) {
        // ইম্প্রেশন আপডেট
        $pdo->prepare("UPDATE ads SET current_impressions = current_impressions + 1 WHERE id = ?")
            ->execute([$ad['id']]);
        
        // অ্যাড কোড দেখান
        $html .= '<div class="ad-wrapper" data-ad-id="'.$ad['id'].'">';
        $html .= $ad['ad_code'];
        $html .= '</div>';
    }
    
    return $html;
}

// আলাদা পজিশনের জন্য ফাংশন
function headerAds() {
    return showAds('header', 1);
}

function sidebarAds() {
    return showAds('sidebar', 3);
}

function contentAds() {
    return showAds('content_middle', 2);
}

function footerAds() {
    return showAds('footer', 1);
}
?>