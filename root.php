<?php
    require_once 'admin/includes/config.php';
    require_once 'admin/includes/db.php';
    function timeAgo($datetime){
        $time = strtotime($datetime);
        $current = time();
        $diff = $current - $time;

        if($diff < 60){
            return $diff . " সেকেন্ড আগে";
        }

        $diff = floor($diff / 60);
        if($diff < 60){
            return $diff . " মিনিট আগে";
        }

        $diff = floor($diff / 60);
        if($diff < 24){
            return $diff . " ঘণ্টা আগে";
        }

        $diff = floor($diff / 24);
        if($diff < 7){
            return $diff . " দিন আগে";
        }

        $diff = floor($diff / 7);
        if($diff < 4){
            return $diff . " সপ্তাহ আগে";
        }

        $diff = floor($diff / 4);
        if($diff < 12){
            return $diff . " মাস আগে";
        }

        $diff = floor($diff / 12);
        return $diff . " বছর আগে";
    }
    
    function bn_num($value) {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        return str_replace($en, $bn, $value);
    }
    function bn_date($date) {
        $en = ['0','1','2','3','4','5','6','7','8','9','January','February','March','April','May','June','July','August','September','October','November','December','am','pm','AM','PM'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','am','pm','am','pm'];
        $formatted = date('j F Y, g:i A', strtotime($date));
        return str_replace($en, $bn, $formatted);
    }
    $roleNames = [
        'super_admin' => 'সুপার অ্যাডমিন',
        'admin' => 'অ্যাডমিন',
        'editor' => 'এডিটর',
        'reporter' => 'রিপোর্টার',
        'moderator' => 'মডারেটর'
    ];
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
        global $conn;
        
        $device = getDevice();
        $html = '';
        
        $sql = "SELECT * FROM ads 
                WHERE ad_position = '$position' 
                AND status = 1 
                AND (device_type = 'all' OR device_type = '$device')";
        
        if($limit) {
            $sql .= " LIMIT $limit";
        }
        
        
        
        
        $ads = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        
        foreach($ads as $ad) {
            $clicks = isset($_COOKIE['adClicks_'.$ad['id']]) ? $_COOKIE['adClicks_'.$ad['id']] : 0;
            $impressions = isset($_COOKIE['adImpressions_'.$ad['id']]) ? $_COOKIE['adImpressions_'.$ad['id']] : 0;
            
            if($clicks >= $ad['max_clicks'] || $impressions >= $ad['max_impressions']) {
                continue;
            }
            $impressions++;
            // ইম্প্রেশন আপডেট
            // $conn->query("UPDATE ads SET current_impressions = current_impressions + 1 WHERE id = ".$ad['id']);
            // setcookie("adImpressions_".$ad['id'], ($impressions + 1), time() + (2 * 60 * 60), "/");
            
            // অ্যাড কোড দেখান
            $html .= '<div class="ad-wrapper" data-ad-id="'.$ad['id'].'">';
            $html .= '<script>setCookie("adImpressions_'.$ad['id'].'", '.$impressions.'); </script>';
            $html .= $ad['ad_code'];
            $html .= '</div>';
        }

        // echo "<script> console.log('Showing $position ads for $device'); </script>";
        
        return $html;
    }

    // আলাদা পজিশনের জন্য ফাংশন
    function headerAds() {
        return showAds('header', 1);
    }

    function sidebarAds() {
        return showAds('sidebar', 1);
    }

    function contentAds() {
        return showAds('content_middle', 2);
    }

    function footerAds() {
        return showAds('footer', 1);
    }
?>