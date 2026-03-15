<?php
$colors = ["red", "green", "blue"];
$cat_en = ["national", "international", "sports"];
$cat_bn = ["জাতীয়", "আন্তর্জাতিক", "খেলাধুলা"];

$totalCat = count($cat_en);

for ($i = 0; $i < $totalCat; $i++) {

    $slug = $cat_en[$i];
    $name_bn = $cat_bn[$i];
    $color = $colors[$i];

    $sql = "SELECT n.id, n.slug, n.published_at, n.title_bn, n.featured_image, n.summary
        FROM news n
        LEFT JOIN categories c ON n.category_id = c.id
        WHERE n.status = 'published'
        AND (c.slug = '$slug' OR c.name_bn LIKE '%$name_bn%')
        ORDER BY n.published_at DESC
        LIMIT 5
    ";

    $result = $conn->query($sql);
    if ($result->num_rows == 0) continue;

    $isFeaturedPrinted = false;
    ?>
    <!-- Category Section : <?=$name_bn?> -->
    <section class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-lg border-l-4 border-<?= $color ?>-600 pl-2"><?= $name_bn ?></h3>
            <a href="news/?cat=<?= $slug ?>" class="text-sm text-blue-600 hover:underline">আরও দেখুন</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <?php
        while ($row = $result->fetch_assoc()) {
            if (!$isFeaturedPrinted) {
                $isFeaturedPrinted = true;
                ?>
                <!-- Featured News -->
                <div class="bg-white shadow-sm rounded overflow-hidden cursor-pointer" 
                onclick="window.location.href='news/?feed=<?=$row['id']?>&slug=<?=$row['slug']?>'">
                    <img class="w-full h-40 object-cover lazy"
                        data-src="<?= $row['featured_image'] ? $row['featured_image'] : 'https://picsum.photos/400/250?text=Featured_'.$i ?>"
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='250'%3E%3Crect width='400' height='250' fill='%23f1f5f9'/%3E%3C/svg%3E">

                    <div class="p-2">
                        <h4 class="font-bold"><?= $row['title_bn'] ?></h4>
                        <p class="text-xs text-gray-600 mt-1 max-w-[30em] line-clamp-3"><?= $row['summary'] ?></p>
                    </div>
                </div>

                <!-- Small News List -->
                <div class="grid grid-cols-1 gap-2">
            <?php
            } else {
            ?>
                <div class="flex gap-2 border-b pb-2 cursor-pointer"
                onclick="window.location.href='news/?feed=<?=$row['id']?>&slug=<?=$row['slug']?>'">
                    <span class="text-<?= $color ?>-600 font-bold">•</span>
                    <div>
                        <h5 class="text-sm font-semibold">
                            <?= $row['title_bn'] ?>
                        </h5>
                        <span class="text-xs text-gray-500">
                            <?= timeAgo($row['published_at']) ?>
                        </span>
                    </div>
                </div>
            <?php
            }
        }
        if ($isFeaturedPrinted) echo "</div>";
        ?>
        </div>
    </section>
<?php } ?>