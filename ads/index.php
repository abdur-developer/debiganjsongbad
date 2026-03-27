<?php
// index.php
require_once 'config.php';

// নিউজ ডাটা (আপনার ডাটাবেজ থেকে)
$newsTitle = "সাম্প্রতিক সংবাদ";
$newsContent = "<p>প্রথম প্যারাগ্রাফের কন্টেন্ট। এখানে সংবাদের বিস্তারিত বিবরণ থাকবে।...</p>
<p>দ্বিতীয় প্যারাগ্রাফ। আরও বিস্তারিত তথ্য...</p>
<p>তৃতীয় প্যারাগ্রাফ। সংবাদের গুরুত্বপূর্ণ অংশ...</p>
<p>চতুর্থ প্যারাগ্রাফ। শেষ অংশ...</p>";
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo $newsTitle; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* হেডার */
        .header {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .ad-container {
            margin: 15px 0;
            text-align: center;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .header .ad-container {
            margin: 0;
        }
        
        /* মেইন কন্টেন্ট */
        .main-content {
            display: flex;
            gap: 20px;
        }
        
        .content-area {
            flex: 3;
        }
        
        .sidebar {
            flex: 1;
        }
        
        .news-article {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .news-article h1 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .news-article p {
            line-height: 1.8;
            margin-bottom: 15px;
            color: #555;
        }
        
        .content-ad {
            margin: 30px 0;
        }
        
        .sidebar-widget {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-widget h3 {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .footer {
            background: #333;
            color: #fff;
            padding: 30px;
            margin-top: 30px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            
            .sidebar {
                order: 2;
            }
        }
    </style>
    
    <!-- Google AdSense Script -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8406156397897492"
         crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <!-- হেডার সেকশন -->
        <div class="header">
            <h1><?php echo SITE_NAME; ?></h1>
            <?php echo getHeaderAds(); ?>
        </div>
        
        <!-- মেইন কন্টেন্ট -->
        <div class="main-content">
            <!-- লেফট সাইড কন্টেন্ট -->
            <div class="content-area">
                <div class="news-article">
                    <h1><?php echo $newsTitle; ?></h1>
                    
                    <!-- কন্টেন্ট টপ অ্যাড -->
                    <?php echo getContentTopAds(); ?>
                    
                    <!-- নিউজ কন্টেন্টের মধ্যে অ্যাড বসানো -->
                    <?php 
                    $processedContent = insertAdsInContent($newsContent, 2);
                    echo $processedContent;
                    ?>
                    
                    <!-- কন্টেন্ট বটম অ্যাড -->
                    <?php echo getContentBottomAds(); ?>
                </div>
            </div>
            
            <!-- রাইট সাইডবার -->
            <div class="sidebar">
                <div class="sidebar-widget">
                    <h3>বিজ্ঞাপন</h3>
                    <?php echo getSidebarAds(3); ?>
                </div>
                
                <div class="sidebar-widget">
                    <h3>সর্বশেষ সংবাদ</h3>
                    <ul>
                        <li><a href="#">সংবাদ ১</a></li>
                        <li><a href="#">সংবাদ ২</a></li>
                        <li><a href="#">সংবাদ ৩</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- ফুটার সেকশন -->
        <div class="footer">
            <?php echo getFooterAds(); ?>
            <p>&copy; 2024 <?php echo SITE_NAME; ?> - সর্বস্বত্ব সংরক্ষিত</p>
        </div>
    </div>
    
    <script>
    // Google AdSense রেন্ডার
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</body>
</html>