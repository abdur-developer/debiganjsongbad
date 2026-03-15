<?php
// Fetch featured news once
$sql = "SELECT n.id, n.slug, n.featured_image, n.title_bn, n.summary, 
    c.name_bn as category_name
    FROM news n
    LEFT JOIN categories c ON n.category_id = c.id
    WHERE n.status = 'published' AND n.is_featured = 1
    ORDER BY n.created_at DESC
    LIMIT 5
";

$result = $conn->query($sql);
$featuredNews = [];

while ($row = $result->fetch_assoc()) {
    $featuredNews[] = $row;
}
?>

<!-- Breaking News Slider (Hero) -->
<section class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <!-- Main Hero Slider -->
        <div class="md:col-span-2 relative hero-slider overflow-hidden rounded-lg" id="hero-slider">
            <div class="slider-container relative h-64 md:h-80">
                <?php foreach (array_slice($featuredNews, 0, 3) as $index => $news): ?>
                <div class="slider-slide <?= $index == 0 ? 'active' : '' ?> absolute inset-0 bg-cover bg-center cursor-pointer"
                    style="background-image: linear-gradient(0deg,#000000b3,#0000004d),url('<?= $news['featured_image']; ?>')"
                    onclick="window.location.href='news/?feed=<?= $news['id'] ?>&slug=<?= $news['slug'] ?>'">
                    <div class="absolute bottom-0 left-0 p-4 text-white">
                        <span class="bg-red-600 px-2 py-1 text-xs rounded"><?= $news['category_name'] ?></span>
                        <h2 class="text-xl md:text-2xl font-bold mt-2"><?= $news['title_bn'] ?></h2>
                        <p class="text-sm mt-1 hidden md:block"><?= $news['summary'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Controls -->
                <button
                    class="slider-prev absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white w-8 h-8 rounded-full hover:bg-black/70">❮</button>
                <button
                    class="slider-next absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white w-8 h-8 rounded-full hover:bg-black/70">❯</button>

                <!-- Dots -->
                <div class="slider-dots absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1">
                    <?php for ($i = 0; $i < 3; $i++): ?>
                    <span
                        class="dot <?= $i == 0 ? 'active' : '' ?> w-2 h-2 bg-white rounded-full cursor-pointer"></span>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- Side Hero -->
        <div class="grid grid-cols-2 md:grid-cols-1 gap-3">
            <?php foreach (array_slice($featuredNews, 3, 2) as $news): ?>
            <div class="relative h-32 md:h-36 rounded-lg overflow-hidden bg-cover bg-center cursor-pointer"
                style="background-image: linear-gradient(0deg,#000000b3,#0000004d),url('<?= $news['featured_image']; ?>')"
                onclick="window.location.href='news/?feed=<?= $news['id'] ?>&slug=<?= $news['slug'] ?>'">
                <div class="absolute bottom-0 left-0 p-2 text-white">
                    <h3 class="font-bold text-sm"><?= $news['title_bn'] ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>