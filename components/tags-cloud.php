<!-- Tags / Topics -->
<?php
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
<div class="bg-white shadow-sm rounded p-3">
    <h4 class="font-bold mb-2">ট্যাগ ক্লাউড</h4>
    <div class="flex flex-wrap gap-2">
        <?php foreach ($uniqueTags as $tag):
            if(empty($tag)) continue;
            ?>
            <a href="search.html?tag=<?= urlencode($tag) ?>" class="bg-gray-100 px-2 py-1 text-xs rounded hover:bg-gray-200"><?= $tag ?></a>
        <?php endforeach; ?>
    </div>
</div>