<!-- Popular News Tabs -->
<?php
$sql = "SELECT id, slug, title_bn FROM news WHERE status = 'published' ORDER BY views DESC LIMIT 5";
$popularResult = $conn->query($sql);

$sql = "SELECT id, slug, title_bn FROM news WHERE status = 'published' AND is_featured = 1 ORDER BY created_at DESC LIMIT 5";
$featureResult = $conn->query($sql);

$sql = "SELECT id, slug, title_bn FROM news WHERE status = 'published' and is_trending = 1 ORDER BY created_at DESC LIMIT 5";
$trandingResult = $conn->query($sql);

?>
<div class="bg-white shadow-sm rounded overflow-hidden">
    <div class="flex border-b">
        <button class="popular-tab active flex-1 py-2 text-sm font-medium text-center" data-tab="most-read">সর্বাধিক পঠিত</button>
        <button class="popular-tab flex-1 py-2 text-sm font-medium text-center" data-tab="most-shared">ট্রেন্ডিং</button>
        <button class="popular-tab flex-1 py-2 text-sm font-medium text-center" data-tab="editor-picks">সম্পাদক পছন্দ</button>
    </div>
    <div class="p-3">
        <!-- Most Read Tab -->
        <div class="tab-content active" id="tab-most-read">
            <ul class="space-y-2">
                <?php
                $p = 0;
                while ($popular = $popularResult->fetch_assoc()) {
                    $p++;
                ?>
                <li class="border-b pb-2 flex gap-2 cursor-pointer hover:text-blue-500"
                onclick="window.location.href='news/?feed=<?=$popular['id']?>&slug=<?=$popular['slug']?>'">
                    <span class="bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded">
                        <!-- position -->
                        <?= bn_num($p) ?>
                    </span>
                    <span class="text-sm"><?php echo $popular['title_bn']; ?></span>
                </li>
                <?php } ?>
            </ul>
        </div>
        <!-- Most Shared Tab (hidden initially) -->
        <div class="tab-content hidden" id="tab-most-shared">
            <ul class="space-y-2">
                <?php
                $p = 0;
                while ($popular = $trandingResult->fetch_assoc()) {
                    $p++;
                ?>
                <li class="border-b pb-2 flex gap-2 cursor-pointer hover:text-blue-500"
                onclick="window.location.href='news/?feed=<?=$popular['id']?>&slug=<?=$popular['slug']?>'">
                    <span class="bg-blue-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded">
                        <!-- position -->
                        <?= bn_num($p) ?>
                    </span>
                    <span class="text-sm"><?php echo $popular['title_bn']; ?></span>
                </li>
                <?php } ?>
            </ul>
        </div>
        <!-- Editor Picks Tab -->
        <div class="tab-content hidden" id="tab-editor-picks">
            <ul class="space-y-2">
                <?php
                $p = 0;
                while ($popular = $featureResult->fetch_assoc()) {
                    $p++;
                ?>
                <li class="border-b pb-2 flex gap-2 cursor-pointer hover:text-blue-500"
                onclick="window.location.href='news/?feed=<?=$popular['id']?>&slug=<?=$popular['slug']?>'">
                    <span class="bg-green-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded">
                        <!-- position -->
                        <?= bn_num($p) ?>
                    </span>
                    <span class="text-sm"><?php echo $popular['title_bn']; ?></span>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script>
// Tab switching for Popular News Tabs
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.popular-tab');
    const tabContents = document.querySelectorAll('.tab-content');
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons and contents
            tabButtons.forEach(b => b.classList.remove('active'));
            tabContents.forEach(tc => tc.classList.add('hidden'));
            tabContents.forEach(tc => tc.classList.remove('active'));
            // Add active to clicked button
            this.classList.add('active');
            // Show corresponding tab content
            const tabId = this.getAttribute('data-tab');
            const content = document.getElementById('tab-' + tabId);
            if (content) {
                content.classList.remove('hidden');
                content.classList.add('active');
            }
        });
    });
});
</script>