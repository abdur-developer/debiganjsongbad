<?php
// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$where_clause = "";
if($search_key != $all_news){
    $where_clause = "WHERE news.title_bn LIKE '%$search_key%' OR news.title_en LIKE '%$search_key%' OR news.summary LIKE '%$search_key%' OR news.tags LIKE '%$search_key%'";
}

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM news $where_clause";
$count_result = $conn->query($count_sql);
$total_news = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_news / $limit);

$news_sql = "SELECT 
    news.id, news.slug, news.featured_image, news.title_bn, news.summary, news.created_at, users.full_name, categories.name_bn as category_name
    FROM news
    JOIN categories ON news.category_id = categories.id
    JOIN users ON news.author_id = users.id 
    $where_clause
    ORDER BY news.created_at DESC 
    LIMIT $limit OFFSET $offset";
$news_query = $conn->query($news_sql);

$news = [];
while ($row = $news_query->fetch_assoc()) {
    $news[] = $row;
}
?>
<!DOCTYPE html>
<html lang="bn">
<?php require_once "../components/head_search.php"; ?>
<body class="bg-gray-50 text-gray-800" id="body">

<?php require_once "../components/header.php"; ?>

<main class="container mx-auto px-2 sm:px-4 py-4">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center"><a href="../" class="text-blue-600">হোম</a><svg class="fill-current w-3 h-3 mx-2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center text-gray-500"><?= $search_key != $all_news ? 'সার্চ ফলাফল' : 'সব খবর' ?></li>
        </ol>
    </nav>
    
    <!-- Search Form -->
    <form class="mb-6" method="GET" action="">
        <h1 class="text-2xl font-bold mb-4"><?= $search_key != $all_news ? 'সার্চ ফলাফল' : 'সব খবর' ?></h1>
        <div class="flex">
            <input type="text" name="search" class="w-full border border-gray-300 rounded-l-lg px-4 py-3 focus:outline-none focus:border-blue-500" value="<?= ($search_key != $all_news) ? $search_key : '' ?>" placeholder="সার্চ করুন...">
            <button class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700" type="submit"><?= $search_key != $all_news ? 'সার্চ' : 'সব' ?></button>
        </div>
        <div class="text-sm text-gray-600 mt-2"><?=($search_key != $all_news) ? '"'.$search_key.'" এর জন্য ' : ''?> <?=bn_num($total_news)?>টি ফলাফল পাওয়া গেছে</div>
    </form>
    
    <!-- Filter Options -->
    <!-- <div class="flex flex-wrap gap-2 mb-6">
        <span class="text-sm font-semibold">ফিল্টার:</span>
        <select class="border rounded px-2 py-1 text-sm">
            <option>সব বিভাগ</option>
            <option>জাতীয়</option>
            <option>আন্তর্জাতিক</option>
            <option>অর্থনীতি</option>
        </select>
        <select class="border rounded px-2 py-1 text-sm">
            <option>সব সময়</option>
            <option>গত ২৪ ঘন্টা</option>
            <option>গত সপ্তাহ</option>
            <option>গত মাস</option>
        </select>
        <select class="border rounded px-2 py-1 text-sm">
            <option>প্রাসঙ্গিকতা</option>
            <option>সর্বশেষ</option>
            <option>সর্বাধিক পঠিত</option>
        </select>
    </div> -->
    
    <!-- Search Results -->
    <div class="space-y-4">
        <?php foreach ($news as $item) { ?>
            <div class="bg-white p-4 shadow-sm rounded flex gap-4 cursor-pointer hover:bg-gray-100 transition" 
                onclick="window.location.href='?feed=<?=$item['id']?>&slug=<?=$item['slug']?>'">
                <img class="w-24 h-24 object-cover rounded lazy" data-src="<?= $item['featured_image'] ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Crect width='100' height='100' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="result">
                <div>
                    <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded"><?=$item['category_name']?></span>
                    <h3 class="font-semibold mt-1 hover:text-blue-600"><?=$item['title_bn']?></h3>
                    <p class="text-sm text-gray-600 mt-1 max-w-[10em] line-clamp-1"><?=$item['summary']?></p>
                    <div class="text-xs text-gray-500 mt-2">প্রকাশ: <?=bn_date($item['created_at'])?></div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <!-- Pagination -->
    <?php if($total_pages > 1): ?>
    <div class="flex justify-center gap-2 mt-8">
        <a href="<?=($search_key != $all_news) ? '?search='.$search_key.'&' : '?'?>page=1" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 <?= $page == 1 ? 'opacity-50 pointer-events-none' : '' ?>">প্রথম</a>
        
        <?php
        $start = max(1, $page - 2);
        $end = min($total_pages, $page + 2);
        
        for($i = $start; $i <= $end; $i++):
        ?>
        <a href="<?=($search_key != $all_news) ? '?search='.$search_key.'&' : '?'?>page=<?= $i ?>" class="px-3 py-1 <?= $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300' ?> rounded"><?= bn_num($i) ?></a>
        <?php endfor; ?>
        
        <a href="<?=($search_key != $all_news) ? '?search='.$search_key.'&' : '?'?>page=<?= $total_pages ?>" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 <?= $page == $total_pages ? 'opacity-50 pointer-events-none' : '' ?>">শেষ</a>
    </div>
    <?php endif; ?>
</main>

<?php require_once "../components/footer.php"; ?>

<script src="../assets/js/app.js"></script>
</body>
</html>