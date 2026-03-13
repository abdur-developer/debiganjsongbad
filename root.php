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

    // ক্যাটাগরি লোড
    $catSql = "SELECT * FROM categories WHERE status = 'active' AND parent_id = 0 ORDER BY sort_order, name_bn LIMIT 12";
    $catResult = $conn->query($catSql);


    // ব্রেকিং নিউজ
    $breakingSql = "SELECT * FROM news WHERE is_breaking = 1 AND status = 'published' ORDER BY created_at DESC LIMIT 5";
    $breakingResult = $conn->query($breakingSql);

    // ট্রেন্ডিং নিউজ
    $trendingSql = "SELECT * FROM news WHERE is_trending = 1 AND status = 'published' ORDER BY views DESC, created_at DESC LIMIT 6";
    $trendingResult = $conn->query($trendingSql);

    // সর্বশেষ নিউজ
    $latestSql = "SELECT n.*, c.name_bn as category_name 
                FROM news n 
                LEFT JOIN categories c ON n.category_id = c.id 
                WHERE n.status = 'published' 
                ORDER BY n.created_at DESC LIMIT 12";
    $latestResult = $conn->query($latestSql);

    // জাতীয় নিউজ
    $nationalSql = "SELECT n.*, c.name_bn as category_name 
                    FROM news n 
                    LEFT JOIN categories c ON n.category_id = c.id 
                    WHERE n.status = 'published' AND (c.slug = 'national' OR c.name_bn LIKE '%জাতীয়%')
                    ORDER BY n.created_at DESC LIMIT 6";
    $nationalResult = $conn->query($nationalSql);

    // আন্তর্জাতিক নিউজ
    $internationalSql = "SELECT n.*, c.name_bn as category_name 
                        FROM news n 
                        LEFT JOIN categories c ON n.category_id = c.id 
                        WHERE n.status = 'published' AND (c.slug = 'international' OR c.name_bn LIKE '%আন্তর্জাতিক%')
                        ORDER BY n.created_at DESC LIMIT 6";
    $internationalResult = $conn->query($internationalSql);

    // খেলাধুলা নিউজ
    $sportsSql = "SELECT n.*, c.name_bn as category_name 
                FROM news n 
                LEFT JOIN categories c ON n.category_id = c.id 
                WHERE n.status = 'published' AND (c.slug = 'sports' OR c.name_bn LIKE '%খেলা%')
                ORDER BY n.created_at DESC LIMIT 6";
    $sportsResult = $conn->query($sportsSql);

    // ভিডিও
    $videoSql = "SELECT * FROM news WHERE video_url IS NOT NULL AND video_url != '' AND status = 'published' ORDER BY created_at DESC LIMIT 4";
    $videoResult = $conn->query($videoSql);

    // গ্যালারি
    $gallerySql = "SELECT * FROM gallery WHERE status = 'active' ORDER BY created_at DESC LIMIT 6";
    $galleryResult = $conn->query($gallerySql);

    // সর্বাধিক পঠিত
    $popularSql = "SELECT n.*, c.name_bn as category_name 
                FROM news n 
                LEFT JOIN categories c ON n.category_id = c.id 
                WHERE n.status = 'published' 
                ORDER BY n.views DESC LIMIT 5";
    $popularResult = $conn->query($popularSql);

    // ট্যাগ ক্লাউড
    $tagSql = "SELECT tags FROM news WHERE tags IS NOT NULL AND status = 'published' ORDER BY created_at DESC LIMIT 50";
    $tagResult = $conn->query($tagSql);
    $allTags = [];
    while ($tagRow = $tagResult->fetch_assoc()) {
        $tags = json_decode($tagRow['tags'], true);
        if (is_array($tags)) {
            $allTags = array_merge($allTags, $tags);
        }
    }
    $uniqueTags = array_slice(array_unique($allTags), 0, 15);
?>