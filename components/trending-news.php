<!-- Trending News Section (Compact Cards) -->
<?php
    $trendingSql = "SELECT id, slug, featured_image, title_bn FROM news WHERE is_trending = 1 AND status = 'published' ORDER BY views DESC, created_at DESC LIMIT 6";
    $trendingResult = $conn->query($trendingSql);
    if ($trendingResult->num_rows > 0) {
?>
<section class="mb-6">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2">ট্রেন্ডিং</h3>
        <a href="#" class="text-sm text-blue-600 hover:underline">আরও দেখুন</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
        <?php 
            while ($trend = $trendingResult->fetch_assoc()) {
        ?>
        <div class="trending-card bg-white shadow-sm rounded overflow-hidden min-w-[110px] cursor-pointer"
        onclick="window.location.href='news/?feed=<?=$trend['id']?>&slug=<?=$trend['slug']?>'">
            <img class="w-full h-16 md:h-20 object-cover lazy" data-src="<?=$trend['featured_image']; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='120'%3E%3Crect width='200' height='120' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="trend">
            <div class="p-1">
                <h4 class="text-xs font-semibold line-clamp-2"><?php echo $trend['title_bn']; ?></h4>
            </div>
        </div>
        <?php } ?>        
    </div>
</section>
<?php } ?>