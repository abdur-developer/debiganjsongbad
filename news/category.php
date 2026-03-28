<?php
$cat_name = $conn->query("SELECT name_bn FROM categories WHERE slug = '$cat_slug'")->fetch_assoc()['name_bn'] ?? "";

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total 
    FROM news 
    JOIN categories ON news.category_id = categories.id 
    WHERE categories.slug = '$cat_slug'";
$count_result = $conn->query($count_sql);
$total_news = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_news / $limit);

$news_sql = "SELECT 
    news.id, news.slug, news.featured_image, news.title_bn, news.summary, news.created_at, users.full_name
    FROM news 
    JOIN categories ON news.category_id = categories.id 
    JOIN users ON news.author_id = users.id 
    WHERE categories.slug = '$cat_slug' 
    ORDER BY news.created_at DESC 
    LIMIT $limit OFFSET $offset";
$news_query = $conn->query($news_sql);

// if(!isset($news_query) || $news_query->num_rows == 0){
//     echo "<script>window.location.href = './';</script>";
//     exit();
// } 

$news = [];
while ($row = $news_query->fetch_assoc()) {
    $news[] = $row;
}
?>
<!DOCTYPE html>
<html lang="bn">
<?php require_once "../components/head_cat.php"; ?>
<body class="bg-gray-50 text-gray-800" id="body">
<?php require_once "../components/header.php"; ?>
<main class="container mx-auto px-2 sm:px-4 py-4">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center"><a href="index.html" class="text-blue-600">হোম</a><svg class="fill-current w-3 h-3 mx-2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center text-gray-500"><?= $cat_name ?></li>
        </ol>
    </nav>
    
    <!-- Category Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl md:text-3xl font-bold border-l-4 border-red-600 pl-3"><?= $cat_name ?></h1>
        <div class="text-sm text-gray-600">মোট <?= bn_num($total_news) ?>টি সংবাদ</div>
    </div>
    
    <!-- Featured Category News -->
    <section class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php
            $firstPrint = false;            
            foreach(array_slice($news, 0, 4) as $index => $row):
                if($firstPrint == false){
                    $firstPrint = true; ?>
                    <div class="bg-white shadow-md rounded overflow-hidden cursor-pointer"
                    onclick="window.location.href='./?feed=<?= $row['id'] ?>&slug=<?= $row['slug'] ?>'">
                        <img class="w-full h-56 object-cover lazy" data-src="<?= $row['featured_image'] ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='600' height='400'%3E%3Crect width='600' height='400' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="featured">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-2"><?= $row['title_bn'] ?></h2>
                            <p class="text-gray-600 text-sm mb-2 max-w-[30em] line-clamp-3"><?= $row['summary'] ?></p>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span><?= timeAgo($row['created_at']) ?></span>
                                <span><?= $row['full_name'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                <?php } else { ?>
                    <div class="bg-white p-3 shadow-sm rounded flex gap-3 cursor-pointer"
                    onclick="window.location.href='./?feed=<?= $row['id'] ?>&slug=<?= $row['slug'] ?>'">
                        <img class="w-24 h-20 object-cover rounded lazy" data-src="<?= $row['featured_image'] ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='80'%3E%3Crect width='100' height='80' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="news">
                        <div>
                            <h3 class="font-semibold text-sm"><?= $row['title_bn'] ?></h3>
                            <p class="text-xs text-gray-500 mt-1 max-w-[30em] line-clamp-3"><?= $row['summary'] ?></p>
                        </div>
                    </div>
                <?php } ?>
            <?php endforeach; if($firstPrint) echo "</div>"; ?>
        </div>
    </section>
    
    <!-- Category News Grid -->
    <section class="mb-8">
        <h3 class="text-xl font-bold mb-4">সর্বশেষ <?= $cat_name ?> সংবাদ</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach(array_slice($news, 4) as $row): ?>
            <article class="bg-white shadow-sm rounded overflow-hidden cursor-pointer"
            onclick="window.location.href='./?feed=<?= $row['id'] ?>&slug=<?= $row['slug'] ?>'">
                <img class="w-full h-36 object-cover lazy" data-src="<?= $row['featured_image'] ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='200'%3E%3Crect width='300' height='200' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="news">
                <div class="p-3">
                    <h4 class="font-semibold mb-1"><?= $row['title_bn'] ?></h4>
                    <p class="text-xs text-gray-500 mb-2 max-w-[30em] line-clamp-3"><?= $row['summary'] ?></p>
                    <div class="flex justify-between text-xs">
                        <span><?= timeAgo($row['created_at']) ?></span>
                        <span class="bg-gray-100 px-2 py-0.5 rounded"><?= $cat_name ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    
    <!-- Pagination -->
    <?php if($total_pages > 1): ?>
    <div class="flex justify-center items-center gap-2 mt-8">
        <a href="?cat=<?= $cat_slug ?>&page=1" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 <?= $page == 1 ? 'opacity-50 pointer-events-none' : '' ?>">প্রথম</a>
        
        <?php
        $start = max(1, $page - 2);
        $end = min($total_pages, $page + 2);
        
        for($i = $start; $i <= $end; $i++):
        ?>
        <a href="?cat=<?= $cat_slug ?>&page=<?= $i ?>" class="px-3 py-1 <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300' ?> rounded"><?= bn_num($i) ?></a>
        <?php endfor; ?>
        
        <a href="?cat=<?= $cat_slug ?>&page=<?= $total_pages ?>" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 <?= $page == $total_pages ? 'opacity-50 pointer-events-none' : '' ?>">শেষ</a>
    </div>
    <?php endif; ?>
</main>

<?php require_once "../components/footer.php"; ?>
<?php require_once "../components/ads_script.php"; ?>
<script src="../assets/js/app.js"></script>
</body>
</html>