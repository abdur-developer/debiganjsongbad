<?php
// ভিডিও
$videoSql = "SELECT * FROM news WHERE video_url IS NOT NULL AND video_url != '' AND status = 'published' ORDER BY created_at DESC LIMIT 4";
$videoResult = $conn->query($videoSql);
if($videoResult->num_rows > 0) { 
?>
    <!-- Video News Section -->
    <section class="mt-8 mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2">ভিডিও</h3>
            <a href="#" class="text-sm text-blue-600 hover:underline">আরও ভিডিও</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <?php while($video = $videoResult->fetch_assoc()): ?>
            <div class="video-card relative group cursor-pointer">
                <img class="w-full h-28 object-cover rounded-lg lazy" data-src="https://picsum.photos/300/180?text=Video+1" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23ddd'/%3E%3C/svg%3E" alt="video">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-lg">
                    <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center group-hover:bg-red-700 transition">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <p class="text-xs font-semibold mt-1 line-clamp-2">প্রধানমন্ত্রীর সাক্ষাৎকার</p>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

<?php } ?>