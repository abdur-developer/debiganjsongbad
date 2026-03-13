<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col" id="body">
    <!-- MAIN CONTENT -->
    <main class="flex-1 container-custom py-3">        
        <!-- মেইন গ্রিড: নিউজ + সাইডবার -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- লেফট কলাম (লেটেস্ট + ক্যাটাগরি) -->
            <div class="lg:col-span-2">
                
                <!-- ক্যাটাগরি সেকশন: জাতীয় -->
                <section class="mb-4 md:mb-6">
                    <div class="flex items-center justify-between mb-2 md:mb-3">
                        <h3 class="font-bold text-base md:text-lg border-l-4 border-red-600 pl-2">জাতীয়</h3>
                        <a href="category.php?slug=national" class="text-xs md:text-sm text-blue-600 hover:underline">আরও দেখুন</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
                        <!-- ফিচার্ড নিউজ -->
                        <div class="bg-white shadow-sm rounded overflow-hidden">
                            <img class="w-full h-36 md:h-40 object-cover lazy" data-src="https://picsum.photos/400/250?random=10" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='250'%3E%3Crect width='400' height='250' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="national featured">
                            <div class="p-2">
                                <h4 class="font-bold text-sm md:text-base">বন্দরে পণ্য জট, শিপমেন্ট ব্যাহত</h4>
                                <p class="text-xs text-gray-600 mt-1 line-clamp-2">চট্টগ্রাম বন্দরে কন্টেইনার জট বেড়েই চলেছে, দুর্ভোগে আমদানিকারকরা।</p>
                            </div>
                        </div>
                        <!-- ছোট নিউজ লিস্ট -->
                        <div class="grid grid-cols-1 gap-1 md:gap-2">
                            <?php 
                            if ($nationalResult->num_rows > 0) {
                                $count = 0;
                                while ($news = $nationalResult->fetch_assoc()) {
                                    if ($count++ >= 4) break;
                            ?>
                            <div class="flex gap-2 border-b pb-1 md:pb-2">
                                <span class="text-red-600 font-bold text-xs md:text-sm">•</span>
                                <div>
                                    <h5 class="text-xs md:text-sm font-semibold line-clamp-1"><?php echo $news['title_bn']; ?></h5>
                                    <span class="text-xs text-gray-500"><?php echo timeAgo($news['created_at']); ?></span>
                                </div>
                            </div>
                            <?php 
                                }
                            } else {
                                for ($i=1; $i<=4; $i++) {
                            ?>
                            <div class="flex gap-2 border-b pb-1 md:pb-2">
                                <span class="text-red-600 font-bold text-xs md:text-sm">•</span>
                                <div>
                                    <h5 class="text-xs md:text-sm font-semibold line-clamp-1">জাতীয় সংবাদ <?php echo $i; ?></h5>
                                    <span class="text-xs text-gray-500"><?php echo $i; ?> ঘন্টা আগে</span>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>
                
                <!-- ক্যাটাগরি সেকশন: আন্তর্জাতিক -->
                <section class="mb-4 md:mb-6">
                    <div class="flex items-center justify-between mb-2 md:mb-3">
                        <h3 class="font-bold text-base md:text-lg border-l-4 border-blue-600 pl-2">আন্তর্জাতিক</h3>
                        <a href="category.php?slug=international" class="text-xs md:text-sm text-blue-600 hover:underline">আরও দেখুন</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
                        <div class="bg-white shadow-sm rounded overflow-hidden">
                            <img class="w-full h-36 md:h-40 object-cover lazy" data-src="https://picsum.photos/400/250?random=20" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='250'%3E%3Crect width='400' height='250' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="international featured">
                            <div class="p-2">
                                <h4 class="font-bold text-sm md:text-base">যুক্তরাষ্ট্রে শক্তিশালী তুষারঝড়, ১০ নিহত</h4>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 md:gap-2">
                            <?php for ($i=1; $i<=4; $i++): ?>
                            <div class="flex gap-2 border-b pb-1 md:pb-2">
                                <span class="text-blue-600 font-bold">•</span>
                                <div>
                                    <h5 class="text-xs md:text-sm font-semibold line-clamp-1">আন্তর্জাতিক সংবাদ <?php echo $i; ?></h5>
                                    <span class="text-xs text-gray-500"><?php echo $i; ?> ঘন্টা আগে</span>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </section>
                
                <!-- ক্যাটাগরি সেকশন: খেলাধুলা -->
                <section class="mb-4 md:mb-6">
                    <div class="flex items-center justify-between mb-2 md:mb-3">
                        <h3 class="font-bold text-base md:text-lg border-l-4 border-green-600 pl-2">খেলাধুলা</h3>
                        <a href="category.php?slug=sports" class="text-xs md:text-sm text-blue-600 hover:underline">আরও দেখুন</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
                        <div class="bg-white shadow-sm rounded overflow-hidden">
                            <img class="w-full h-36 md:h-40 object-cover lazy" data-src="https://picsum.photos/400/250?random=30" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='250'%3E%3Crect width='400' height='250' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="sports featured">
                            <div class="p-2">
                                <h4 class="font-bold text-sm md:text-base">বাংলাদেশের ঐতিহাসিক জয়, সিরিজ সাফল্য</h4>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 md:gap-2">
                            <?php for ($i=1; $i<=4; $i++): ?>
                            <div class="flex gap-2 border-b pb-1 md:pb-2">
                                <span class="text-green-600 font-bold">•</span>
                                <div>
                                    <h5 class="text-xs md:text-sm font-semibold line-clamp-1">খেলাধুলার সংবাদ <?php echo $i; ?></h5>
                                    <span class="text-xs text-gray-500"><?php echo $i; ?> ঘন্টা আগে</span>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </section>
            </div>
            
            <!-- সাইডবার -->
            <aside class="lg:col-span-1 space-y-3 md:space-y-4">
                <!-- জনপ্রিয় নিউজ ট্যাব -->
                <div class="bg-white shadow-sm rounded overflow-hidden">
                    <div class="flex border-b text-xs md:text-sm">
                        <button class="popular-tab active flex-1 py-2 font-medium text-center" data-tab="most-read">সর্বাধিক পঠিত</button>
                        <button class="popular-tab flex-1 py-2 font-medium text-center" data-tab="most-shared">সর্বাধিক শেয়ার</button>
                        <button class="popular-tab flex-1 py-2 font-medium text-center" data-tab="editor-picks">সম্পাদক পছন্দ</button>
                    </div>
                    <div class="p-2 md:p-3">
                        <!-- মোস্ট রিড ট্যাব -->
                        <div class="tab-content active" id="tab-most-read">
                            <ul class="space-y-1 md:space-y-2">
                                <?php 
                                if ($popularResult->num_rows > 0) {
                                    $i = 1;
                                    while ($pop = $popularResult->fetch_assoc()) {
                                ?>
                                <li class="border-b pb-1 md:pb-2 flex gap-2 text-xs md:text-sm">
                                    <span class="bg-red-600 text-white w-4 h-4 md:w-5 md:h-5 flex items-center justify-center rounded text-[10px] md:text-xs"><?php echo $i++; ?></span>
                                    <span class="line-clamp-1"><?php echo $pop['title_bn']; ?></span>
                                </li>
                                <?php 
                                    }
                                } else {
                                    for ($i=1; $i<=5; $i++) {
                                ?>
                                <li class="border-b pb-1 md:pb-2 flex gap-2 text-xs md:text-sm">
                                    <span class="bg-red-600 text-white w-4 h-4 md:w-5 md:h-5 flex items-center justify-center rounded text-[10px] md:text-xs"><?php echo $i; ?></span>
                                    <span class="line-clamp-1">জনপ্রিয় সংবাদ <?php echo $i; ?></span>
                                </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- মোস্ট শেয়ারড ট্যাব -->
                        <div class="tab-content hidden" id="tab-most-shared">
                            <ul class="space-y-1 md:space-y-2">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                <li class="border-b pb-1 md:pb-2 text-xs md:text-sm">🔗 শেয়ারকৃত সংবাদ <?php echo $i; ?></li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                        <!-- এডিটর পিকস ট্যাব -->
                        <div class="tab-content hidden" id="tab-editor-picks">
                            <ul class="space-y-1 md:space-y-2">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                <li class="border-b pb-1 md:pb-2 text-xs md:text-sm">📌 সম্পাদক পছন্দ <?php echo $i; ?></li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- সাইডবার অ্যাড -->
                <div class="bg-gray-200 h-48 md:h-64 flex items-center justify-center text-gray-500 text-xs md:text-sm ad-placeholder">
                    সাইডবার এডি ৩০০x২৫০
                </div>
                
                <!-- ট্যাগ ক্লাউড -->
                <div class="bg-white shadow-sm rounded p-2 md:p-3">
                    <h4 class="font-bold mb-2 text-sm md:text-base">ট্যাগ ক্লাউড</h4>
                    <div class="flex flex-wrap gap-1 md:gap-2">
                        <?php 
                        if (!empty($uniqueTags)) {
                            foreach ($uniqueTags as $tag) {
                        ?>
                        <a href="search.php?tag=<?php echo urlencode($tag); ?>" class="bg-gray-100 px-2 py-1 text-[10px] md:text-xs rounded hover:bg-gray-200"><?php echo $tag; ?></a>
                        <?php 
                            }
                        } else {
                            $demoTags = ['করোনা', 'বাজেট', 'ক্রিকেট', 'ভারত', 'যুক্তরাষ্ট্র', 'চীন', 'শিক্ষা', 'স্বাস্থ্য', 'প্রযুক্তি', 'অর্থনীতি'];
                            foreach ($demoTags as $tag) {
                        ?>
                        <a href="#" class="bg-gray-100 px-2 py-1 text-[10px] md:text-xs rounded hover:bg-gray-200"><?php echo $tag; ?></a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </aside>
        </div>
        
        <!-- ভিডিও নিউজ সেকশন -->
        <section class="mt-4 md:mt-6 mb-4 md:mb-6">
            <div class="flex items-center justify-between mb-2 md:mb-3">
                <h3 class="font-bold text-base md:text-lg border-l-4 border-red-600 pl-2">ভিডিও</h3>
                <a href="#" class="text-xs md:text-sm text-blue-600 hover:underline">আরও ভিডিও</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 md:gap-3">
                <?php for ($i=1; $i<=4; $i++): ?>
                <div class="video-card relative group">
                    <img class="w-full h-20 md:h-28 object-cover rounded-lg lazy" data-src="https://picsum.photos/300/180?video=<?php echo $i; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23ddd'/%3E%3C/svg%3E" alt="video">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-lg">
                        <div class="w-6 h-6 md:w-8 md:h-8 bg-red-600 rounded-full flex items-center justify-center group-hover:bg-red-700 transition">
                            <svg class="w-3 h-3 md:w-4 md:h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] md:text-xs font-semibold mt-1 line-clamp-2">ভিডিও নিউজ <?php echo $i; ?></p>
                </div>
                <?php endfor; ?>
            </div>
        </section>
        
        <!-- ফটো গ্যালারি সেকশন -->
        <section class="mb-4 md:mb-6">
            <div class="flex items-center justify-between mb-2 md:mb-3">
                <h3 class="font-bold text-base md:text-lg border-l-4 border-red-600 pl-2"><a href="gallery.php">ছবি গ্যালারি</a></h3>
                <a href="gallery.php" class="text-xs md:text-sm text-blue-600 hover:underline">সব ছবি</a>
            </div>
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-1 md:gap-2">
                <?php 
                if ($galleryResult->num_rows > 0) {
                    $count = 0;
                    while ($gallery = $galleryResult->fetch_assoc()) {
                        if ($count++ >= 6) break;
                ?>
                <a href="gallery.php" class="gallery-thumb">
                    <img class="w-full h-12 md:h-16 object-cover rounded lazy" data-src="<?php echo $gallery['image']; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery">
                </a>
                <?php 
                    }
                } else {
                    for ($i=1; $i<=6; $i++) {
                ?>
                <a href="gallery.php" class="gallery-thumb">
                    <img class="w-full h-12 md:h-16 object-cover rounded lazy" data-src="https://picsum.photos/150/100?gallery=<?php echo $i; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery">
                </a>
                <?php
                    }
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>