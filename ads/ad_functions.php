<?php
// ad_functions.php

/**
 * ডিভাইস টাইপ ডিটেক্ট করুন
 */
function detectDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileDevices = array(
        'Android', 'webOS', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 
        'Windows Phone', 'Opera Mini', 'Mobile', 'mobile'
    );
    
    foreach($mobileDevices as $device) {
        if(stripos($userAgent, $device) !== false) {
            return 'mobile';
        }
    }
    return 'desktop';
}

/**
 * অ্যাড লিমিট চেক করুন (লোকালি সেশনে)
 */
function checkAdLimit($adId, $adName) {
    if(!ENABLE_AD_LIMIT) return true;
    
    // সেশন কী তৈরি
    $sessionKey = 'ad_' . $adId . '_' . date('Y-m-d');
    
    if(!isset($_SESSION[$sessionKey])) {
        $_SESSION[$sessionKey] = [
            'impressions' => 0,
            'clicks' => 0,
            'last_reset' => time()
        ];
    }
    
    $adData = $_SESSION[$sessionKey];
    $currentTime = time();
    
    // 24 ঘন্টা পর রিসেট
    if($currentTime - $adData['last_reset'] > 86400) {
        $_SESSION[$sessionKey] = [
            'impressions' => 0,
            'clicks' => 0,
            'last_reset' => $currentTime
        ];
        return true;
    }
    
    return true; // সেশনে কোনো লিমিট নেই
}

/**
 * ইম্প্রেশন আপডেট করুন
 */
function updateImpression($adId) {
    global $pdo;
    
    try {
        // ডাটাবেজে ইম্প্রেশন আপডেট
        $sql = "UPDATE ads SET current_impressions = current_impressions + 1 
                WHERE id = :ad_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ad_id' => $adId]);
        
        // সেশনে ইম্প্রেশন আপডেট
        $sessionKey = 'ad_' . $adId . '_' . date('Y-m-d');
        if(isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey]['impressions']++;
        }
        
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

/**
 * ক্লিক আপডেট করুন
 */
function updateClick($adId) {
    global $pdo;
    
    try {
        // ডাটাবেজে ক্লিক আপডেট
        $sql = "UPDATE ads SET current_clicks = current_clicks + 1 
                WHERE id = :ad_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ad_id' => $adId]);
        
        // সেশনে ক্লিক আপডেট
        $sessionKey = 'ad_' . $adId . '_' . date('Y-m-d');
        if(isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey]['clicks']++;
        }
        
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

/**
 * অ্যাড কোড পাওয়ার ফাংশন (একাধিক অ্যাড সাপোর্ট)
 */
function getAds($position, $limit = null) {
    global $pdo;
    
    $deviceType = detectDevice();
    $adsHtml = '';
    
    try {
        $sql = "SELECT * FROM ads 
                WHERE ad_position = :position 
                AND status = 1 
                AND (device_type = 'all' OR device_type = :device_type)
                AND (start_date IS NULL OR start_date <= NOW())
                AND (end_date IS NULL OR end_date >= NOW())";
        
        // লিমিট চেক করুন
        if(ENABLE_AD_LIMIT) {
            $sql .= " AND (max_impressions = 0 OR current_impressions < max_impressions)";
            $sql .= " AND (max_clicks = 0 OR current_clicks < max_clicks)";
        }
        
        $sql .= " ORDER BY priority ASC, display_order ASC, id ASC";
        
        if($limit) {
            $sql .= " LIMIT " . intval($limit);
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':position' => $position,
            ':device_type' => $deviceType
        ]);
        
        $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($ads as $ad) {
            // লিমিট চেক করুন
            if(checkAdLimit($ad['id'], $ad['ad_name'])) {
                // ইম্প্রেশন ট্র্যাক করুন
                updateImpression($ad['id']);
                
                // অ্যাড কোড中添加 ক্লিক ট্র্যাকিং
                $adCode = $ad['ad_code'];
                $trackingCode = getClickTrackingCode($ad['id']);
                
                // অ্যাড কোডে ক্লিক ট্র্যাকিং যোগ করুন
                $adsHtml .= str_replace('</ins>', '</ins>' . $trackingCode, $adCode);
                $adsHtml .= "\n";
            }
        }
        
        return $adsHtml;
        
    } catch(PDOException $e) {
        return '';
    }
}

/**
 * ক্লিক ট্র্যাকিং জাভাস্ক্রিপ্ট কোড
 */
function getClickTrackingCode($adId) {
    return '<script>
    (function() {
        var adContainer = document.currentScript.parentElement;
        if(adContainer) {
            adContainer.addEventListener("click", function() {
                fetch("' . SITE_URL . 'track_click.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "ad_id=' . $adId . '"
                });
            });
        }
    })();
    </script>';
}

/**
 * নির্দিষ্ট পজিশনের জন্য অ্যাড
 */
function getHeaderAds() {
    return getAds('header', 1); // হেডারে সর্বোচ্চ ১টি অ্যাড
}

function getSidebarAds($limit = 3) {
    return getAds('sidebar', $limit); // সাইডবারে ৩টি অ্যাড
}

function getContentTopAds() {
    return getAds('content_top', 1);
}

function getContentMiddleAds() {
    return getAds('content_middle', 2); // কন্টেন্টের মাঝে ২টি অ্যাড
}

function getContentBottomAds() {
    return getAds('content_bottom', 1);
}

function getFooterAds() {
    return getAds('footer', 1);
}

/**
 * আর্টিকেলের মধ্যে অ্যাড বসানোর ফাংশন
 */
function insertAdsInContent($content, $interval = 3) {
    $paragraphs = explode('</p>', $content);
    $totalParagraphs = count($paragraphs);
    $adCount = 0;
    
    // অ্যাডগুলো পেতে হবে
    $ads = [];
    $adsData = getAdsData('content_middle');
    
    foreach($adsData as $ad) {
        if(checkAdLimit($ad['id'], $ad['ad_name'])) {
            $ads[] = $ad;
        }
    }
    
    if(empty($ads)) {
        return $content;
    }
    
    $newContent = '';
    $adIndex = 0;
    
    for($i = 0; $i < $totalParagraphs; $i++) {
        $newContent .= $paragraphs[$i] . '</p>';
        
        // নির্দিষ্ট প্যারাগ্রাফের পর অ্যাড বসান
        if(($i + 1) % $interval == 0 && $i < $totalParagraphs - 1) {
            if(isset($ads[$adIndex])) {
                updateImpression($ads[$adIndex]['id']);
                $newContent .= $ads[$adIndex]['ad_code'] . getClickTrackingCode($ads[$adIndex]['id']);
                $adIndex++;
                
                if($adIndex >= count($ads)) {
                    $adIndex = 0; // রোটেট করুন
                }
            }
        }
    }
    
    return $newContent;
}

/**
 * অ্যাড ডাটা পাওয়ার জন্য হেল্পার ফাংশন
 */
function getAdsData($position) {
    global $pdo;
    
    $deviceType = detectDevice();
    
    try {
        $sql = "SELECT * FROM ads 
                WHERE ad_position = :position 
                AND status = 1 
                AND (device_type = 'all' OR device_type = :device_type)
                AND (start_date IS NULL OR start_date <= NOW())
                AND (end_date IS NULL OR end_date >= NOW())";
        
        if(ENABLE_AD_LIMIT) {
            $sql .= " AND (max_impressions = 0 OR current_impressions < max_impressions)";
            $sql .= " AND (max_clicks = 0 OR current_clicks < max_clicks)";
        }
        
        $sql .= " ORDER BY priority ASC, display_order ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':position' => $position,
            ':device_type' => $deviceType
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        return [];
    }
}