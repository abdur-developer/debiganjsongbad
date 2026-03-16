<?php
    require_once "root.php";
    $isRoot = true;
    $logo = "./assets/img/logo.png";
?>
<!DOCTYPE html>
<html lang="bn">
<?php require_once "components/head.php"; ?>
<body class="bg-gray-50 text-gray-800 antialiased" id="body">

<!-- <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3940256099942544" data-ad-slot="6300978111" data-ad-format="auto" data-full-width-responsive="true"></ins>

<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script> -->
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
    
    
    <?php require_once "components/hero-section.php"; ?>
    
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
               <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8406156397897492" data-ad-slot="7731728586" data-ad-format="auto" data-ad-test="on" data-full-width-responsive="true"></ins>
            </div>
            
            
            <?php require_once "components/tags-cloud.php"; ?>
        </aside>
    </div>
    
    <?php require_once "components/video-news.php"; ?>
    <!-- <php require_once "components/photo-gallery.php"; ?> -->
    
    <!-- Footer Ad -->
    <div class="bg-gray-200 h-20 my-4 flex items-center justify-center text-gray-500 ad-placeholder">
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8406156397897492" data-ad-slot="7731728586" data-ad-format="auto" data-ad-test="on" data-full-width-responsive="true"></ins>
    </div>
    
    <!-- Breadcrumb (Example) -->
    <!-- <nav class="text-sm mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center"><a href="index.html" class="text-blue-600">হোম</a><svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center"><a href="#" class="text-blue-600">জাতীয়</a><svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center text-gray-500">বন্দরে পণ্য জট</li>
        </ol>
    </nav> -->
</main>

<?php require_once "components/footer.php"; ?>

<!-- Dark Mode Toggle Button -->
<!-- <button id="dark-mode-toggle" class="fixed bottom-4 right-4 bg-gray-800 text-white p-3 rounded-full shadow-lg z-50 hover:bg-gray-700 transition" aria-label="Toggle Dark Mode">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
    </svg>
</button> -->
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!-- Main JavaScript -->
<script src="assets/js/app.js"></script>
</body>
</html>