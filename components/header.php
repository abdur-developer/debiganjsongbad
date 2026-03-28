<?php
$catLink = $isRoot ? "news" : "."; 
$rootLink = $isRoot ? "./" : "../"; 
?>
<script>
    function setCookie(name, value) {
        let date = new Date();
        date.setTime(date.getTime() + (2 * 60 * 60 * 1000)); // 2 hours
        document.cookie = name + "=" + value + "; expires=" + date.toUTCString() + "; path=/";
    }
</script>
<!-- HEADER SECTION -->
<header class="my-header top-0 z-50 bg-white shadow-md border-b border-gray-200 transition-colors">
    <div class="container mx-auto px-2 sm:px-4">
        <!-- Top Header: Date & Time + Social + Login -->
        <div class="flex flex-wrap justify-between items-center text-xs py-1 border-b border-gray-100">
            <div class="flex gap-2 items-center">
                <span id="live-datetime" class="font-medium text-gray-600">শুক্রবার, ৮ মার্চ ২০২৬</span>
                <!-- <span class="bg-red-600 text-white px-1.5 py-0.5 rounded text-[10px]">লাইভ</span> -->
            </div>
            <div class="flex gap-3 items-center">
                <div class="flex gap-2">
                    <a href="#" aria-label="facebook" class="text-gray-600 hover:text-blue-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.99h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.99C18.343 21.128 22 16.991 22 12z"/></svg></a>
                    <a href="#" aria-label="twitter" class="text-gray-600 hover:text-blue-400"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg></a>
                    <a href="#" aria-label="youtube" class="text-gray-600 hover:text-red-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                </div>
                <!-- <a href="#" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium hover:bg-blue-700 transition">লগইন / রেজিস্টার</a> -->
            </div>
        </div>
        
        <!-- Breaking News Ticker -->
        <div class="flex items-center gap-2 py-1 overflow-hidden border-b border-gray-100 text-sm">
            <span class="bg-red-600 text-white px-2 py-0.5 rounded font-bold whitespace-nowrap">ব্রেকিং</span>
            <div class="overflow-hidden relative w-full h-6">
                <div class="absolute whitespace-nowrap ticker-animate text-gray-700 font-medium" id="breaking-ticker">
                    <?php
                        // ব্রেকিং নিউজ
                        $breakingSql = "SELECT id, title_bn, slug FROM news WHERE is_breaking = 1 AND status = 'published' ORDER BY created_at DESC LIMIT 5";
                        $breakingResult = $conn->query($breakingSql);
                        
                        foreach($breakingResult as $breaking){
                            echo "<a href='$catLink/?feed={$breaking['id']}&slug={$breaking['slug']}' class='hover:text-blue-600'>🔴 {$breaking['title_bn']}</a> | ";
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Logo Area + Ad -->
        <div class="flex flex-col md:flex-row justify-between items-center py-3 gap-3">
            <div class="flex items-center gap-4">
                <button id="menuBtn" class="md:hidden p-2 text-xl">☰</button>
                <img src="<?=$logo?>" class="w-[40%] cursor-pointer" onclick="window.location.href='<?=$rootLink?>'" />
            </div>
            <?= headerAds() ?>
        </div>
        
        <!-- Navigation Menu -->
        <nav id="navMenu" class="hidden md:flex flex-wrap items-center text-sm font-semibold gap-1 py-2 border-b">
            <a href="<?=$rootLink?>" class="nav-link">হোম</a>
            <?php
                // ক্যাটাগরি লোড                
                $catSql = "SELECT * FROM categories c
                    WHERE c.status = 'active' AND c.parent_id = 0
                    AND (
                        EXISTS (SELECT 1 FROM news n WHERE n.category_id = c.id)                        
                    )
                    ORDER BY c.sort_order, c.name_bn
                    LIMIT 12";
                $catResult = $conn->query($catSql);
            ?>
            <?php
                // $count = 0;
                while ($cat = $catResult->fetch_assoc()) {
                    // $count++;
                    // if($count == 7){
                    //     echo '<button onclick="toggleMore()" class="nav-link">See More</button>';
                    //     echo '<div id="moreMenu" class="hidden md:flex flex-wrap gap-1">';
                    // }
                    $childCatSql = "SELECT * FROM categories WHERE status='active' AND parent_id='".$cat['id']."' ORDER BY sort_order,name_bn";

                    $childCatResult = $conn->query($childCatSql);
                    if($childCatResult->num_rows > 0){ ?>
                        <div class="dropdown">
                            <button class="nav-link flex items-center">
                                <?= $cat['name_bn']; ?>
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="dropdown-content">
                                <?php
                                    while ($childCat = $childCatResult->fetch_assoc()) {
                                        echo '<a href="'.$catLink.'/?cat='.$childCat['slug'].'">'.$childCat['name_bn'].'</a>';
                                    }
                                ?>
                            </div>
                        </div>
                    <?php
                    }else{
                        echo '<a href="'.$catLink.'/?cat='.$cat['slug'].'" class="nav-link">'.$cat['name_bn'].'</a>';
                    }

                }
                // if($count > 6) echo '</div>';
            ?>

            <!-- <a href="gallery.html" class="nav-link">ছবি</a> -->

        </nav>
        <script>
            const menuBtn = document.getElementById("menuBtn");
            const navMenu = document.getElementById("navMenu");

            menuBtn.onclick = () => {
                if(navMenu.classList.contains("hidden")){
                    navMenu.classList.remove("hidden");
                    navMenu.classList.add("flex","flex-col","p-3");
                }else{
                    navMenu.classList.add("hidden");
                }
            };

            // function toggleMore(){
            //     document.getElementById("moreMenu").classList.toggle("hidden");
            // }

            document.querySelectorAll(".dropdown button").forEach(btn=>{
                btn.addEventListener("click",function(){
                    let dropdown=this.nextElementSibling;
                    dropdown.classList.toggle("hidden");
                });
            });

        </script>
    </div>
</header>