<?php if(!isset($news)){
    echo "<script>window.location.href = './';</script>";
    exit();
} ?>
<!DOCTYPE html>
<html lang="bn">

<?php require_once "../components/head_news.php"; ?>
<body class="bg-gray-50 text-gray-800 antialiased" id="body">

<?php require_once "../components/header.php"; ?>


<!-- MAIN CONTENT - NEWS DETAILS -->
<main class="container mx-auto px-2 sm:px-4 py-4">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center"><a href="../" class="text-blue-600 hover:underline">হোম</a><svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center"><a href="?cat=national" class="text-blue-600 hover:underline"><?= $news['category_name'] ?></a><svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center text-gray-500"><?=$news['title_en']?></li>
        </ol>
    </nav>
    
    <!-- Main Grid: News Content + Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Column -->
        <div class="lg:col-span-2">
            <!-- Article Header -->
            <header class="mb-4">
                <h1 class="text-2xl md:text-3xl font-bold mb-3"><?=$news['title_bn']?></h1>
                <div class="inline-block bg-red-600 text-white px-2 py-1 text-xs rounded mb-2"><?=$news['category_name']?></div>
                
                <!-- Author & Date -->
                <div class="flex flex-wrap items-center justify-between text-sm text-gray-600 border-b border-gray-200 pb-3 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">
                            <img class="w-full h-full object-cover rounded-full" src="<?=$news['avatar']?>" alt="Author Avatar">
                        </div>
                        <div>
                            <span class="font-semibold"><?=$news['full_name']?></span>
                            <span class="text-xs text-gray-500 block"><?=$role?></span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span>প্রকাশ: <?php echo bn_date($news['created_at']); ?></span>          
                        <span>আপডেট: <?php echo bn_date($news['updated_at']); ?></span>
                    </div>
                </div>
                <!-- Share Buttons -->
                <div class="flex gap-2 mb-6 justify-end">
                    <!-- ShareThis BEGIN -->
                    <div class="sharethis-inline-share-buttons"></div>
                    <!-- ShareThis END -->
                </div>
            </header>
            
            <!-- Featured Image -->
            <figure class="mb-4">
                <img class="w-full h-auto rounded-lg lazy" data-src="<?=$news['featured_image']?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='450'%3E%3Crect width='800' height='450' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="বন্দরে কন্টেইনার জট">
                <!-- <figcaption class="text-xs text-gray-500 mt-1">ছবি: দেবীগঞ্জ | সংগৃহীত</figcaption> -->
            </figure>
            
            <!-- Article Content -->
            <article class="prose prose-lg max-w-none mb-6">
                <p style="font-family: 'SolaimanLipi', sans-serif;">
                    <?=$news['content']?>
                </p>
                
                <div class="flex flex-wrap gap-2 mt-6 pt-4 border-t">
                    <span class="text-sm font-semibold">ট্যাগ:</span>
                    <?php
                    while($tag = array_shift($tags)){
                        echo '<a href="./?search=' . urlencode($tag) . '" class="bg-gray-200 px-2 py-1 text-xs rounded hover:bg-gray-300">' . e($tag) . '</a>';
                    }
                    ?>
                </div>
            </article>
            
            <!-- Comment Section -->
            <section class="mt-8 mb-8">
                <h3 class="text-xl font-bold mb-4 border-b pb-2">মন্তব্য করুন</h3>
                
                <!-- Comment Form -->
                <form class="mb-6" id="comment-form">
                    <textarea rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500" placeholder="আপনার মন্তব্য লিখুন..."></textarea>
                    <div class="flex gap-3 mt-2">
                        <input type="text" placeholder="আপনার নাম" class="flex-1 border border-gray-300 rounded-lg p-2 text-sm">
                        <input type="email" placeholder="ইমেইল" class="flex-1 border border-gray-300 rounded-lg p-2 text-sm">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg mt-3 hover:bg-blue-700 transition">মন্তব্য পাঠান</button>
                </form>
                
                <!-- Existing Comments -->
                <div class="space-y-4">
                    <?php
                        $sql = "SELECT * FROM comments WHERE news_id = '$news_id' ORDER BY created_at DESC";
                        $query = $conn->query($sql);
                    ?>
                    <h4 class="font-semibold"><?= $query->num_rows ?> টি মন্তব্য</h4>
                    <?php while($comment = $query->fetch_assoc()){ ?>
                    <div class="border rounded-lg p-3">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-6 h-6 bg-gray-400 rounded-full">
                                <img class="w-full h-full object-cover rounded-full" src="https://www.gravatar.com/avatar/<?= md5(strtolower(trim($comment['email']))) ?>?s=48&d=identicon" alt="User Avatar">
                            </div>
                            <span class="font-semibold"><?= e($comment['name']) ?></span>
                            <span class="text-xs text-gray-500"><?= timeAgo($comment['created_at']) ?></span>
                        </div>
                        <p class="text-sm"> <?= e($comment['comment']) ?> </p>
                    </div>
                    <?php } ?>                    
                </div>
            </section>
            
            <!-- Related News -->
            <section class="mt-8">
                <h3 class="text-xl font-bold mb-4 border-l-4 border-red-600 pl-2">আরও পড়ুন</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <?php
                        $sql = "SELECT id, title_bn, featured_image, slug FROM news WHERE news.category_id = '{$news['category_id']}' OR news.tags LIKE '%{$news['tags']}%' OR news.id != '$news_id' ORDER BY created_at DESC LIMIT 6";
                        $query = $conn->query($sql);
                    ?>
                    <?php while($news_more = $query->fetch_assoc()){ ?>
                    <div class="bg-white shadow-sm rounded overflow-hidden cursor-pointer" onclick="window.location.href='./?feed=<?=$news_more['id']?>&slug=<?=$news_more['slug']?>'">
                        <img class="w-full h-24 object-cover lazy" data-src="<?=$news_more['featured_image']?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='120'%3E%3Crect width='200' height='120' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="related">
                        <div class="p-2">
                            <h4 class="text-sm font-semibold"><?=$news_more['title_bn']?></h4>
                        </div>
                    </div>
                    <?php } ?>  
                </div>
            </section>
        </div>
        
        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-4">
            <!-- Author Info Card -->
            <div class="bg-white shadow-sm rounded p-4 text-center">
                <div class="w-20 h-20 bg-gray-400 rounded-full mx-auto mb-3 flex items-center justify-center text-white text-2xl font-bold">
                    <?php
                        if($news['avatar']){
                            echo '<img class="w-full h-full object-cover rounded-full" src="' . $news['avatar'] . '" alt="Author Avatar">';
                        } else {
                            echo 'আ';
                        }
                    ?>
                </div>
                <h4 class="font-bold"><?=$news['full_name']?></h4>
                <p class="text-sm text-gray-600 mb-2"><?=$role?></p>
                <p class="text-xs text-gray-500"><?=$news['bio']?></p>
                <a href="../author.php?username=<?=$news['username']?>" class="inline-block mt-3 text-blue-600 text-sm hover:underline">সব লেখা দেখুন</a>
            </div>
            
            <!-- Popular News -->
            <div class="bg-white shadow-sm rounded p-3">
                <h4 class="font-bold mb-3 border-b pb-1">সর্বাধিক পঠিত</h4>
                <ul class="space-y-2">
                    <li class="text-sm border-b pb-2">ডলারের দাম আবার বেড়ে ১২০ টাকা</li>
                    <li class="text-sm border-b pb-2">জ্বালানি তেলের মূল্যবৃদ্ধি কার্যকর</li>
                    <li class="text-sm border-b pb-2">বিএনপির মহাসমাবেশ আজ, কঠোর নিরাপত্তা</li>
                    <li class="text-sm border-b pb-2">পবিত্র রমজান শুরু বৃহস্পতিবার</li>
                    <li class="text-sm">সিরিজ জয়ের নায়ক মুশফিক</li>
                </ul>
            </div>
            
            <!-- Sidebar Ad -->
            <div class="bg-gray-200 h-64 flex items-center justify-center text-gray-500 text-sm ad-placeholder">
                সাইডবার এডি ৩০০x২৫০
            </div>
            
            <!-- Newsletter -->
            <div class="bg-blue-50 p-4 rounded">
                <h4 class="font-bold mb-2">নিউজলেটার</h4>
                <p class="text-xs mb-2">দৈনিক সংবাদ পেতে সাবস্ক্রাইব করুন</p>
                <input type="email" placeholder="ইমেইল" class="w-full p-2 border rounded text-sm mb-2">
                <button class="w-full bg-blue-600 text-white py-2 rounded text-sm hover:bg-blue-700">সাবস্ক্রাইব</button>
            </div>
        </aside>
    </div>
</main>

<?php require_once "../components/footer.php"; ?>

<!-- Dark Mode Toggle -->
<!-- <button id="dark-mode-toggle" class="fixed bottom-4 right-4 bg-gray-800 text-white p-3 rounded-full shadow-lg z-50 hover:bg-gray-700 transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
    </svg>
</button> -->

<!-- Main JavaScript -->
<script src="../assets/js/app.js"></script>
</body>
</html>