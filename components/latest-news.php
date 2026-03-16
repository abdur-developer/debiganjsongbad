<?php
// সর্বশেষ নিউজ
$latestSql = "SELECT n.*, c.name_bn as category_name 
            FROM news n 
            LEFT JOIN categories c ON n.category_id = c.id 
            WHERE n.status = 'published' 
            ORDER BY n.created_at DESC LIMIT 12";
$latestResult = $conn->query($latestSql);  

?>
<!-- Latest News Grid -->
<section class="mb-6">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2">সর্বশেষ সংবাদ</h3>
        <a href="news/" class="text-sm text-blue-600 hover:underline">সবগুলো</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        <?php 
        if ($latestResult->num_rows > 0) {
            $count = 0;
            while ($news = $latestResult->fetch_assoc()) {
                if ($count++ >= 6) break;
        ?>
            <article class="news-card bg-white shadow-sm rounded overflow-hidden cursor-pointer"
            onclick="window.location.href='news/?feed=<?=$news['id']?>&slug=<?=$news['slug']?>'">
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
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8406156397897492" data-ad-slot="7731728586" data-ad-format="auto" data-ad-test="on" data-full-width-responsive="true"></ins>
    </div>
</section>