<?php
    require_once "root.php";
    
    $logo = "./assets/img/logo.png";

    // ব্রেকিং নিউজ
    $breakingSql = "SELECT * FROM news WHERE is_breaking = 1 AND status = 'published' ORDER BY created_at DESC LIMIT 5";
    $breakingResult = $conn->query($breakingSql);

    

    // সর্বশেষ নিউজ
    $latestSql = "SELECT n.*, c.name_bn as category_name 
                FROM news n 
                LEFT JOIN categories c ON n.category_id = c.id 
                WHERE n.status = 'published' 
                ORDER BY n.created_at DESC LIMIT 12";
    $latestResult = $conn->query($latestSql);


    // ভিডিও
    $videoSql = "SELECT * FROM news WHERE video_url IS NOT NULL AND video_url != '' AND status = 'published' ORDER BY created_at DESC LIMIT 4";
    $videoResult = $conn->query($videoSql);

      
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
    
    <?php require_once "components/trending-news.php"; ?>
        
    <!-- Main Grid: Latest News + Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (Latest News + Category Sections) -->
        <div class="lg:col-span-2">
            <?php require_once "components/latest-news.php"; ?>
            <?php require_once "components/three-cat-news.php"; ?>
        </div>
        
        <!-- Sidebar (Popular, Editor Picks, Ads) -->
        <aside class="lg:col-span-1 space-y-4">
            <?php require_once "components/tab.php"; ?>
            
            <!-- Sidebar Ad -->
            <div class="bg-gray-200 h-64 flex items-center justify-center text-gray-500 text-sm ad-placeholder">
                সাইডবার এডি ৩০০x২৫০
            </div>
            
            
            <?php require_once "components/tags-cloud.php"; ?>
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
    
    <?php require_once "components/photo-gallery.php"; ?>
    
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