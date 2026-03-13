<?php
    require_once "root.php";
    
    $logo = "./assets/img/logo.png";

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
<!DOCTYPE html>
<html lang="bn">
<?php require_once "components/head.php"; ?>
<body class="bg-gray-50 text-gray-800 antialiased" id="body">

<?php require_once "components/header.php"; ?>

<!-- MAIN CONTENT -->
<main class="container mx-auto px-2 sm:px-4 py-3">
    
    <!-- Search Bar (Live Search) -->
    <div class="hidden mb-4 relative">
        <div class="flex">
            <input type="text" id="search-input" class="w-full border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:border-blue-500" placeholder="সার্চ করুন...">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-r-lg hover:bg-blue-700 transition" id="search-btn">সার্চ</button>
        </div>
        <div id="search-suggestions" class="absolute bg-white border border-gray-200 w-full mt-1 rounded-lg shadow-lg hidden z-10"></div>
    </div>
    
    <!-- Breaking News Slider (Hero) -->
    <section class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Main Hero Slider -->
            <div class="md:col-span-2 relative hero-slider overflow-hidden rounded-lg" id="hero-slider">
                <div class="slider-container relative h-64 md:h-80">
                    <!-- Slide 1 -->
                    <div class="slider-slide active absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(0deg, #000000b3, #0000004d), url('https://picsum.photos/800/400?text=Slider+News+1')">
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <span class="bg-red-600 px-2 py-1 text-xs rounded">সর্বশেষ</span>
                            <h2 class="text-xl md:text-2xl font-bold mt-2">বাজেট অধিবেশন শুরু আজ, বাড়তে পারে বরাদ্দ</h2>
                            <p class="text-sm mt-1 hidden md:block">অর্থমন্ত্রী আজ জাতীয় সংসদে ২০২৬-২৭ অর্থবছরের বাজেট পেশ করবেন।</p>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="slider-slide absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(0deg, #000000b3, #0000004d), url('https://picsum.photos/800/400?text=Slider+News+2')">
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <span class="bg-red-600 px-2 py-1 text-xs rounded">ব্রেকিং</span>
                            <h2 class="text-xl md:text-2xl font-bold mt-2">বাংলাদেশ-ভারত বৈঠক আজ, সীমান্ত সমস্যা নিয়ে আলোচনা</h2>
                            <p class="text-sm mt-1 hidden md:block">দুই দেশের স্বরাষ্ট্র সচিব পর্যায়ের বৈঠক অনুষ্ঠিত হবে।</p>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="slider-slide absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(0deg, #000000b3, #0000004d), url('https://picsum.photos/800/400?text=Slider+News+3')">
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <span class="bg-red-600 px-2 py-1 text-xs rounded">খেলা</span>
                            <h2 class="text-xl md:text-2xl font-bold mt-2">টি-টোয়েন্টি সিরিজ জয় বাংলাদেশের</h2>
                            <p class="text-sm mt-1 hidden md:block">শেষ ম্যাচে ৫ উইকেটের জয়, সিরিজ ৩-২ ব্যবধানে জিতল টাইগাররা।</p>
                        </div>
                    </div>
                    
                    <!-- Slider Controls -->
                    <button class="slider-prev absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white w-8 h-8 rounded-full hover:bg-black/70">❮</button>
                    <button class="slider-next absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white w-8 h-8 rounded-full hover:bg-black/70">❯</button>
                    
                    <!-- Slider Dots -->
                    <div class="slider-dots absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1">
                        <span class="dot active w-2 h-2 bg-white rounded-full cursor-pointer"></span>
                        <span class="dot w-2 h-2 bg-white/50 rounded-full cursor-pointer"></span>
                        <span class="dot w-2 h-2 bg-white/50 rounded-full cursor-pointer"></span>
                    </div>
                </div>
            </div>
            
            <!-- Side Hero (2 small news) -->
            <div class="grid grid-cols-2 md:grid-cols-1 gap-3">
                <div class="relative h-32 md:h-36 rounded-lg overflow-hidden bg-cover bg-center" style="background-image: linear-gradient(0deg, #000000b3, #0000004d), url('https://picsum.photos/400/200?text=News+1')">
                    <div class="absolute bottom-0 left-0 p-2 text-white">
                        <h3 class="font-bold text-sm">আর্জেন্টিনার জার্সি গঞ্জনা ভক্তদের</h3>
                    </div>
                </div>
                <div class="relative h-32 md:h-36 rounded-lg overflow-hidden bg-cover bg-center" style="background-image: linear-gradient(0deg, #000000b3, #0000004d), url('https://picsum.photos/400/200?text=News+2')">
                    <div class="absolute bottom-0 left-0 p-2 text-white">
                        <h3 class="font-bold text-sm">ভারত-বাংলাদেশ ম্যাচ আজ</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Trending News Section (Compact Cards) -->
    <section class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2">ট্রেন্ডিং</h3>
            <a href="#" class="text-sm text-blue-600 hover:underline">আরও দেখুন</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
            <?php 
            if ($trendingResult->num_rows > 0) {
                while ($trend = $trendingResult->fetch_assoc()) {
            ?>
            <div class="trending-card bg-white shadow-sm rounded overflow-hidden min-w-[110px]">
                <img class="w-full h-16 md:h-20 object-cover lazy" data-src="https://picsum.photos/200/120?random=<?php echo $trend['id']; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='120'%3E%3Crect width='200' height='120' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="trend">
                <div class="p-1">
                    <h4 class="text-xs font-semibold line-clamp-2"><?php echo $trend['title_bn']; ?></h4>
                </div>
            </div>
            <?php 
                }
            } else {
                // ডেমো ডাটা
                for ($i=1; $i<=6; $i++) {
            ?>
            <div class="trending-card bg-white shadow-sm rounded overflow-hidden min-w-[110px]">
                <img class="w-full h-16 md:h-20 object-cover lazy" data-src="https://picsum.photos/200/120?random=<?php echo $i; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='120'%3E%3Crect width='200' height='120' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="trend">
                <div class="p-1">
                    <h4 class="text-xs font-semibold line-clamp-2">ট্রেন্ডিং নিউজ <?php echo $i; ?></h4>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </section>
    
    <!-- Main Grid: Latest News + Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (Latest News + Category Sections) -->
        <div class="lg:col-span-2">
            <!-- Latest News Grid -->
            <section class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2">সর্বশেষ সংবাদ</h3>
                    <a href="#" class="text-sm text-blue-600 hover:underline">সবগুলো</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <?php 
                    if ($latestResult->num_rows > 0) {
                        $count = 0;
                        while ($news = $latestResult->fetch_assoc()) {
                            if ($count++ >= 6) break;
                    ?>
                    <article class="news-card bg-white shadow-sm rounded overflow-hidden">
                        <img class="w-full h-24 md:h-28 object-cover lazy" data-src="<?php echo $news['featured_image']; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="news">
                        <div class="p-2">
                            <h4 class="text-xs md:text-sm font-semibold line-clamp-2"><?php echo $news['title_bn']; ?></h4>
                            <div class="flex items-center justify-between mt-1 text-xs text-gray-500">
                                <span><?php echo timeAgo($news['created_at']); ?></span>
                                <span class="bg-gray-100 px-1 rounded"><?php echo $news['category_name']; ?></span>
                            </div>
                        </div>
                    </article>
                    <?php 
                        }
                    } else {
                        // ডেমো ডাটা
                        for ($i=1; $i<=6; $i++) {
                    ?>
                    <article class="news-card bg-white shadow-sm rounded overflow-hidden">
                        <img class="w-full h-24 md:h-28 object-cover lazy" data-src="https://picsum.photos/300/180?random=<?php echo $i; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="news">
                        <div class="p-2">
                            <h4 class="text-xs md:text-sm font-semibold line-clamp-2">সর্বশেষ সংবাদ <?php echo $i; ?></h4>
                            <div class="flex items-center justify-between mt-1 text-xs text-gray-500">
                                <span><?php echo $i; ?> ঘন্টা আগে</span>
                                <span class="bg-gray-100 px-1 rounded">জাতীয়</span>
                            </div>
                        </div>
                    </article>
                    <?php
                        }
                    }
                    ?>
                </div>
                
                <!-- Between Sections Ad -->
                <div class="bg-gray-200 h-16 my-4 flex items-center justify-center text-gray-500 text-sm ad-placeholder">
                    বিজ্ঞাপন (মাঝের ব্যানার)
                </div>
            </section>
            
            <!-- Category Section: জাতীয় -->
            <section class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2">জাতীয়</h3>
                    <a href="category.html?cat=national" class="text-sm text-blue-600 hover:underline">আরও দেখুন</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <!-- Featured News (Big) -->
                    <div class="bg-white shadow-sm rounded overflow-hidden">
                        <img class="w-full h-40 object-cover lazy" data-src="https://picsum.photos/400/250?text=National+Featured" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='250'%3E%3Crect width='400' height='250' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="national featured">
                        <div class="p-2">
                            <h4 class="font-bold">বন্দরে পণ্য জট, শিপমেন্ট ব্যাহত</h4>
                            <p class="text-xs text-gray-600 mt-1">চট্টগ্রাম বন্দরে কন্টেইনার জট বেড়েই চলেছে, দুর্ভোগে আমদানিকারকরা।</p>
                        </div>
                    </div>
                    <!-- Small News List -->
                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex gap-2 border-b pb-2">
                            <span class="text-red-600 font-bold">•</span>
                            <div>
                                <h5 class="text-sm font-semibold">পাসপোর্ট অফিসে দুর্নীতি, তদন্ত শুরু</h5>
                                <span class="text-xs text-gray-500">২ ঘন্টা আগে</span>
                            </div>
                        </div>
                        <div class="flex gap-2 border-b pb-2">
                            <span class="text-red-600 font-bold">•</span>
                            <div>
                                <h5 class="text-sm font-semibold">সেতু উদ্বোধন কাল, প্রস্তুতি চূড়ান্ত</h5>
                                <span class="text-xs text-gray-500">৩ ঘন্টা আগে</span>
                            </div>
                        </div>
                        <div class="flex gap-2 border-b pb-2">
                            <span class="text-red-600 font-bold">•</span>
                            <div>
                                <h5 class="text-sm font-semibold">কৃষকদের মাঝে বীজ বিতরণ শুরু</h5>
                                <span class="text-xs text-gray-500">৫ ঘন্টা আগে</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-red-600 font-bold">•</span>
                            <div>
                                <h5 class="text-sm font-semibold">শীতার্তদের মাঝে কম্বল বিতরণ</h5>
                                <span class="text-xs text-gray-500">৬ ঘন্টা আগে</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Category Section: আন্তর্জাতিক -->
            <section class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-lg border-l-4 border-blue-600 pl-2">আন্তর্জাতিক</h3>
                    <a href="category.html?cat=international" class="text-sm text-blue-600 hover:underline">আরও দেখুন</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="bg-white shadow-sm rounded overflow-hidden">
                        <img class="w-full h-40 object-cover lazy" data-src="https://picsum.photos/400/250?text=International+Featured" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='250'%3E%3Crect width='400' height='250' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="international featured">
                        <div class="p-2">
                            <h4 class="font-bold">যুক্তরাষ্ট্রে শক্তিশালী তুষারঝড়, ১০ নিহত</h4>
                            <p class="text-xs text-gray-600 mt-1">নিউইয়র্কসহ বেশ কয়েকটি অঙ্গরাজ্যে জরুরি অবস্থা জারি।</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex gap-2 border-b pb-2"><span class="text-blue-600 font-bold">•</span><div><h5 class="text-sm font-semibold">মিয়ানমারে ভূমিকম্প, হতাহতের আশঙ্কা</h5><span class="text-xs text-gray-500">২ ঘন্টা আগে</span></div></div>
                        <div class="flex gap-2 border-b pb-2"><span class="text-blue-600 font-bold">•</span><div><h5 class="text-sm font-semibold">পাকিস্তানে জ্বালানি সংকট চরমে</h5><span class="text-xs text-gray-500">৪ ঘন্টা আগে</span></div></div>
                        <div class="flex gap-2 border-b pb-2"><span class="text-blue-600 font-bold">•</span><div><h5 class="text-sm font-semibold">চীনে রপ্তানি বাণিজ্যে রেকর্ড</h5><span class="text-xs text-gray-500">৬ ঘন্টা আগে</span></div></div>
                        <div class="flex gap-2"><span class="text-blue-600 font-bold">•</span><div><h5 class="text-sm font-semibold">যুক্তরাজ্যে মুদ্রাস্ফীতি কমেছে</h5><span class="text-xs text-gray-500">৭ ঘন্টা আগে</span></div></div>
                    </div>
                </div>
            </section>
            
            <!-- Category Section: খেলাধুলা -->
            <section class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-lg border-l-4 border-green-600 pl-2">খেলাধুলা</h3>
                    <a href="category.html?cat=sports" class="text-sm text-blue-600 hover:underline">আরও দেখুন</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="bg-white shadow-sm rounded overflow-hidden">
                        <img class="w-full h-40 object-cover lazy" data-src="https://picsum.photos/400/250?text=Sports+Featured" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='250'%3E%3Crect width='400' height='250' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="sports featured">
                        <div class="p-2">
                            <h4 class="font-bold">বাংলাদেশের ঐতিহাসিক জয়, সিরিজ সাফল্য</h4>
                            <p class="text-xs text-gray-600 mt-1">নিউজিল্যান্ডকে হারিয়ে প্রথমবার টেস্ট সিরিজ জিতল টাইগাররা।</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex gap-2 border-b pb-2"><span class="text-green-600 font-bold">•</span><div><h5 class="text-sm font-semibold">আইপিএলে ধোনির ঝলক, চেন্নাইয়ের জয়</h5><span class="text-xs text-gray-500">১ ঘন্টা আগে</span></div></div>
                        <div class="flex gap-2 border-b pb-2"><span class="text-green-600 font-bold">•</span><div><h5 class="text-sm font-semibold">ফিফা র্যাঙ্কিংয়ে বাংলাদেশের উন্নতি</h5><span class="text-xs text-gray-500">৩ ঘন্টা আগে</span></div></div>
                        <div class="flex gap-2 border-b pb-2"><span class="text-green-600 font-bold">•</span><div><h5 class="text-sm font-semibold">হকিতে পাকিস্তানের বিপক্ষে জয়</h5><span class="text-xs text-gray-500">৫ ঘন্টা আগে</span></div></div>
                        <div class="flex gap-2"><span class="text-green-600 font-bold">•</span><div><h5 class="text-sm font-semibold">দাবায় শেখর, গ্র্যান্ডমাস্টার সৃষ্টি</h5><span class="text-xs text-gray-500">৬ ঘন্টা আগে</span></div></div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Sidebar (Popular, Editor Picks, Ads) -->
        <aside class="lg:col-span-1 space-y-4">
            <!-- Popular News Tabs -->
            <div class="bg-white shadow-sm rounded overflow-hidden">
                <div class="flex border-b">
                    <button class="popular-tab active flex-1 py-2 text-sm font-medium text-center" data-tab="most-read">সর্বাধিক পঠিত</button>
                    <button class="popular-tab flex-1 py-2 text-sm font-medium text-center" data-tab="most-shared">সর্বাধিক শেয়ার</button>
                    <button class="popular-tab flex-1 py-2 text-sm font-medium text-center" data-tab="editor-picks">সম্পাদক পছন্দ</button>
                </div>
                <div class="p-3">
                    <!-- Most Read Tab -->
                    <div class="tab-content active" id="tab-most-read">
                        <ul class="space-y-2">
                            <li class="border-b pb-2 flex gap-2"><span class="bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded">১</span><span class="text-sm">ডলারের দাম আবার বেড়ে ১২০ টাকা</span></li>
                            <li class="border-b pb-2 flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">২</span><span class="text-sm">জ্বালানি তেলের মূল্যবৃদ্ধি কার্যকর</span></li>
                            <li class="border-b pb-2 flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">৩</span><span class="text-sm">বিএনপির মহাসমাবেশ আজ, কঠোর নিরাপত্তা</span></li>
                            <li class="border-b pb-2 flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">৪</span><span class="text-sm">পবিত্র রমজান শুরু বৃহস্পতিবার</span></li>
                            <li class="flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">৫</span><span class="text-sm">সিরিজ জয়ের নায়ক মুশফিক</span></li>
                        </ul>
                    </div>
                    <!-- Most Shared Tab (hidden initially) -->
                    <div class="tab-content hidden" id="tab-most-shared">
                        <ul class="space-y-2">
                            <li class="border-b pb-2"><span class="text-sm">🔗 ১. স্মার্টফোনের নতুন মডেল লঞ্চ</span></li>
                            <li class="border-b pb-2"><span class="text-sm">🔗 ২. যেসব খাবার ওষুধের মতো কাজ করে</span></li>
                            <li class="border-b pb-2"><span class="text-sm">🔗 ৩. বিয়েবাড়ির মেনুতে যা থাকছে</span></li>
                            <li class="border-b pb-2"><span class="text-sm">🔗 ৪. ভিসা প্রক্রিয়া সহজ হচ্ছে</span></li>
                            <li><span class="text-sm">🔗 ৫. নতুন বছরে বেতন বৃদ্ধির সম্ভাবনা</span></li>
                        </ul>
                    </div>
                    <!-- Editor Picks Tab -->
                    <div class="tab-content hidden" id="tab-editor-picks">
                        <ul class="space-y-2">
                            <li class="border-b pb-2"><span class="text-sm">📌 স্মার্ট বাংলাদেশের স্বপ্ন ও বাস্তবতা</span></li>
                            <li class="border-b pb-2"><span class="text-sm">📌 চিকিৎসায় নতুন মাত্রা, জিন থেরাপি</span></li>
                            <li class="border-b pb-2"><span class="text-sm">📌 পদ্মা সেতুর প্রভাব অর্থনীতিতে</span></li>
                            <li class="border-b pb-2"><span class="text-sm">📌 শিক্ষাক্ষেত্রে ডিজিটাল রূপান্তর</span></li>
                            <li><span class="text-sm">📌 পরিবেশ রক্ষায় তরুণদের ভূমিকা</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar Ad -->
            <div class="bg-gray-200 h-64 flex items-center justify-center text-gray-500 text-sm ad-placeholder">
                সাইডবার এডি ৩০০x২৫০
            </div>
            
            <!-- Tags / Topics -->
            <div class="bg-white shadow-sm rounded p-3">
                <h4 class="font-bold mb-2">ট্যাগ ক্লাউড</h4>
                <div class="flex flex-wrap gap-2">
                    <a href="search.html?tag=করোনা" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">করোনা</a>
                    <a href="search.html?tag=বাজেট" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">বাজেট</a>
                    <a href="search.html?tag=ক্রিকেট" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">ক্রিকেট</a>
                    <a href="search.html?tag=ভারত" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">ভারত</a>
                    <a href="search.html?tag=যুক্তরাষ্ট্র" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">যুক্তরাষ্ট্র</a>
                    <a href="search.html?tag=চীন" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">চীন</a>
                    <a href="search.html?tag=প্রবাসী" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">প্রবাসী</a>
                    <a href="search.html?tag=শিক্ষা" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">শিক্ষা</a>
                    <a href="search.html?tag=স্বাস্থ্য" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">স্বাস্থ্য</a>
                    <a href="search.html?tag=প্রযুক্তি" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">প্রযুক্তি</a>
                    <a href="search.html?tag=অর্থনীতি" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200">অর্থনীতি</a>
                </div>
            </div>
        </aside>
    </div>
    
    <!-- Video News Section -->
    <section class="mt-8 mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2">ভিডিও</h3>
            <a href="#" class="text-sm text-blue-600 hover:underline">আরও ভিডিও</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="video-card relative group">
                <img class="w-full h-28 object-cover rounded-lg lazy" data-src="https://picsum.photos/300/180?text=Video+1" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23ddd'/%3E%3C/svg%3E" alt="video">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-lg">
                    <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center group-hover:bg-red-700 transition">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <p class="text-xs font-semibold mt-1 line-clamp-2">প্রধানমন্ত্রীর সাক্ষাৎকার</p>
            </div>
            <div class="video-card relative group">
                <img class="w-full h-28 object-cover rounded-lg lazy" data-src="https://picsum.photos/300/180?text=Video+2" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23ddd'/%3E%3C/svg%3E" alt="video">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-lg">
                    <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">▶</div>
                </div>
                <p class="text-xs font-semibold mt-1">জাতীয় সংসদের বাজেট অধিবেশন</p>
            </div>
            <div class="video-card relative group">
                <img class="w-full h-28 object-cover rounded-lg lazy" data-src="https://picsum.photos/300/180?text=Video+3" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23ddd'/%3E%3C/svg%3E" alt="video">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-lg">
                    <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">▶</div>
                </div>
                <p class="text-xs font-semibold mt-1">শীতার্ত মানুষের পাশে তরুণরা</p>
            </div>
            <div class="video-card relative group">
                <img class="w-full h-28 object-cover rounded-lg lazy" data-src="https://picsum.photos/300/180?text=Video+4" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23ddd'/%3E%3C/svg%3E" alt="video">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-lg">
                    <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">▶</div>
                </div>
                <p class="text-xs font-semibold mt-1">ক্রিকেটারদের অনুশীলন</p>
            </div>
        </div>
    </section>
    
    <!-- Photo Gallery Section -->
    <section class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2"><a href="gallery.html">ছবি গ্যালারি</a></h3>
            <a href="gallery.html" class="text-sm text-blue-600 hover:underline">সব ছবি</a>
        </div>
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
            <a href="gallery.html" class="gallery-thumb relative">
                <img class="w-full h-16 object-cover rounded lazy" data-src="https://picsum.photos/150/100?text=Gallery+1" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery">
                <span class="absolute bottom-0 right-0 bg-red-600 text-white text-xs px-1">+৫</span>
            </a>
            <a href="gallery.html" class="gallery-thumb"><img class="w-full h-16 object-cover rounded lazy" data-src="https://picsum.photos/150/100?text=Gallery+2" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery"></a>
            <a href="gallery.html" class="gallery-thumb"><img class="w-full h-16 object-cover rounded lazy" data-src="https://picsum.photos/150/100?text=Gallery+3" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery"></a>
            <a href="gallery.html" class="gallery-thumb"><img class="w-full h-16 object-cover rounded lazy" data-src="https://picsum.photos/150/100?text=Gallery+4" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery"></a>
            <a href="gallery.html" class="gallery-thumb"><img class="w-full h-16 object-cover rounded lazy" data-src="https://picsum.photos/150/100?text=Gallery+5" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery"></a>
            <a href="gallery.html" class="gallery-thumb"><img class="w-full h-16 object-cover rounded lazy" data-src="https://picsum.photos/150/100?text=Gallery+6" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery"></a>
        </div>
    </section>
    
    <!-- Footer Ad -->
    <div class="bg-gray-200 h-20 my-4 flex items-center justify-center text-gray-500 ad-placeholder">
        ফুটার এডি ৭২০x৯০
    </div>
    
    <!-- Breadcrumb (Example) -->
    <nav class="text-sm mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center"><a href="index.html" class="text-blue-600">হোম</a><svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center"><a href="#" class="text-blue-600">জাতীয়</a><svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center text-gray-500">বন্দরে পণ্য জট</li>
        </ol>
    </nav>
</main>

<?php require_once "components/footer.php"; ?>

<!-- Dark Mode Toggle Button -->
<!-- <button id="dark-mode-toggle" class="fixed bottom-4 right-4 bg-gray-800 text-white p-3 rounded-full shadow-lg z-50 hover:bg-gray-700 transition" aria-label="Toggle Dark Mode">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
    </svg>
</button> -->

<!-- Main JavaScript -->
<script src="assets/js/app.js"></script>
</body>
</html>