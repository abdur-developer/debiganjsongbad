<?php
// index.php
require_once 'config.php';
require_once 'ad_functions.php';
?>
<!DOCTYPE html>
<html lang="bn">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>নিউজ পোর্টাল</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: Arial, sans-serif;
                background: #f4f4f4;
            }
            
            .container {
                max-width: 1200px;
                margin: auto;
                padding: 20px;
            }
            
            /* হেডার */
            .header {
                background: #fff;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                text-align: center;
            }
            
            /* মেনু */
            .menu {
                background: #333;
                color: #fff;
                padding: 10px;
                margin-bottom: 20px;
            }
            
            .menu a {
                color: #fff;
                padding: 10px;
                text-decoration: none;
            }
            
            /* মেইন এরিয়া */
            .main {
                display: flex;
                gap: 20px;
            }
            
            .content {
                flex: 3;
                background: #fff;
                padding: 20px;
                border-radius: 5px;
            }
            
            .sidebar {
                flex: 1;
            }
            
            /* সাইডবার উইজেট */
            .widget {
                background: #fff;
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 5px;
            }
            
            .widget h3 {
                margin-bottom: 10px;
                border-bottom: 2px solid #f0f0f0;
                padding-bottom: 10px;
            }
            
            /* ফুটার */
            .footer {
                background: #333;
                color: #fff;
                padding: 20px;
                margin-top: 20px;
                text-align: center;
            }
            
            /* অ্যাড স্টাইল */
            .ad-wrapper {
                margin: 15px 0;
                text-align: center;
                cursor: pointer;
            }
            
            .sidebar .ad-wrapper {
                margin: 10px 0;
            }
            
            @media (max-width: 768px) {
                .main {
                    flex-direction: column;
                }
            }
        </style>
        
        <!-- Google AdSense -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4520141412693223"
            crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <!-- হেডার -->
            <div class="header">
                <h1>নিউজ পোর্টাল</h1>
                <?php echo headerAds(); ?>
            </div>
            
            <!-- মেনু -->
            <div class="menu">
                <a href="#">হোম</a>
                <a href="#">রাজনীতি</a>
                <a href="#">বাণিজ্য</a>
                <a href="#">খেলা</a>
                <a href="#">বিনোদন</a>
            </div>
            
            <!-- মেইন কন্টেন্ট -->
            <div class="main">
                <!-- লেফট সাইড -->
                <div class="content">
                    <article>
                        <h2>সাম্প্রতিক সংবাদ</h2>
                        <p>প্রথম প্যারাগ্রাফ। এখানে সংবাদের বিস্তারিত বিবরণ থাকবে। দেশের গুরুত্বপূর্ণ ঘটনা সম্পর্কে জানুন।</p>
                        
                        <p>দ্বিতীয় প্যারাগ্রাফ। আরও বিস্তারিত তথ্য দেওয়া হবে। সংবাদটি সম্পূর্ণ পড়তে থাকুন।</p>
                        
                        <!-- কন্টেন্টের মধ্যে অ্যাড -->
                        <?php echo contentAds(); ?>
                        
                        <p>তৃতীয় প্যারাগ্রাফ। সংবাদের গুরুত্বপূর্ণ অংশ এখানে উল্লেখ করা হবে। বিস্তারিত বিশ্লেষণ।</p>
                        
                        <p>চতুর্থ প্যারাগ্রাফ। শেষ অংশ। আরও জানতে আমাদের সাথে থাকুন।</p>
                    </article>
                </div>
                
                <!-- রাইট সাইডবার -->
                <div class="sidebar">
                    <div class="widget">
                        <h3>বিজ্ঞাপন</h3>
                        <?php echo sidebarAds(); ?>
                    </div>
                    
                    <div class="widget">
                        <h3>জনপ্রিয় সংবাদ</h3>
                        <ul>
                            <li><a href="#">সংবাদ ১</a></li>
                            <li><a href="#">সংবাদ ২</a></li>
                            <li><a href="#">সংবাদ ৩</a></li>
                            <li><a href="#">সংবাদ ৪</a></li>
                        </ul>
                    </div>
                    
                    <div class="widget">
                        <h3>সাম্প্রতিক মন্তব্য</h3>
                        <p>ব্যবহারকারীর মন্তব্য এখানে দেখা যাবে</p>
                    </div>
                </div>
            </div>
            
            <!-- ফুটার -->
            <div class="footer">
                <?php echo footerAds(); ?>
                <p>&copy; 2024 নিউজ পোর্টাল - সর্বস্বত্ব সংরক্ষিত</p>
            </div>
        </div>
        
        <!-- ক্লিক ট্র্যাকিং জাভাস্ক্রিপ্ট -->
        <script>
        // অ্যাডে ক্লিক ট্র্যাক করা
        document.addEventListener('click', function(e) {
            // অ্যাডের প্যারেন্ট এলিমেন্ট খুঁজুন
            let target = e.target;
            let adWrapper = null;
            
            while(target && target !== document.body) {
                if(target.classList && target.classList.contains('ad-wrapper')) {
                    adWrapper = target;
                    break;
                }
                target = target.parentElement;
            }
            
            // যদি অ্যাডে ক্লিক হয়ে থাকে
            if(adWrapper) {
                let adId = adWrapper.getAttribute('data-ad-id');
                
                if(adId) {
                    // AJAX দিয়ে ট্র্যাক করুন
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', 'track_click.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('ad_id=' + adId);
                }
            }
        });
        </script>
    </body>
</html>