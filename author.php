<?php
require_once "root.php";
$isRoot = true;
$logo = "assets/img/logo.png";
$sql = "SELECT * FROM users WHERE username = '{$_GET['username']}'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $author = $result->fetch_assoc();
} else {
    header("Location: ./");
    exit();
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $author['full_name'] ?> - লেখক পাতা | দেবীগঞ্জ সংবাদ</title>
    <meta name="robots" content="index, follow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50 text-gray-800" id="body">

<?php 
require_once "components/header.php";
?>

<main class="container mx-auto px-2 sm:px-4 py-4">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center"><a href="./" class="text-blue-600">হোম</a><svg class="fill-current w-3 h-3 mx-2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6v12z"/></svg></li>
            <li class="flex items-center text-gray-500">লেখক: <?= $author['full_name'] ?></li>
        </ol>
    </nav>
    
    <!-- Author Profile Header -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6 flex flex-col md:flex-row items-center gap-6">
        <div class="w-32 h-32 bg-blue-400 rounded-full flex items-center justify-center text-white text-4xl font-bold">
            <img class="w-full h-full object-cover rounded-full" src="<?= $author['avatar'] ?>" alt="Author Avatar">
        </div>
        <div class="text-center md:text-left">
            <h1 class="text-3xl font-bold"><?= $author['full_name'] ?></h1>
            <p class="text-blue-600 mb-2"><?=$roleNames[$author['role']] ?? $author['role']?></p>
            <p class="text-gray-600 max-w-2xl"><?= $author['bio'] ?></p>
            <div class="flex gap-4 mt-3 justify-center md:justify-start">
                <span class="text-sm">📧 <?= $author['email'] ?></span>
                <span class="text-sm">📞 <?= $author['phone'] ?></span>
            </div>
            <!-- <div class="flex gap-3 mt-3 justify-center md:justify-start">
                <a href="#" class="text-blue-600">ফেসবুক</a>
                <a href="#" class="text-sky-400">টুইটার</a>
                <a href="#" class="text-red-600">ইউটিউব</a>
            </div> -->
        </div>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 gap-3 mb-6">
        <div class="bg-white shadow-sm rounded p-3 text-center">
            <div class="text-2xl font-bold">
                <?php
                    $sql = "SELECT COUNT(*) as num FROM news WHERE author_id = '{$author['id']}'";
                    echo $conn->query($sql)->fetch_assoc()['num'];
                ?>
            </div>
            <div class="text-xs text-gray-500">মোট সংবাদ</div>
        </div>
        <div class="bg-white shadow-sm rounded p-3 text-center">
            <div class="text-2xl font-bold">
                <?php
                    $sql = "SELECT SUM(views) as view FROM news WHERE author_id = '{$author['id']}'";
                    echo $conn->query($sql)->fetch_assoc()['view'];
                ?>
            </div>
            <div class="text-xs text-gray-500">মোট ভিউ</div>
        </div>
        <!-- <div class="bg-white shadow-sm rounded p-3 text-center">
            <div class="text-2xl font-bold">৫</div>
            <div class="text-xs text-gray-500">পুরস্কার</div>
        </div> -->
    </div>
    
    <!-- Author's Latest News -->
    <h3 class="text-xl font-bold mb-4 border-l-4 border-red-600 pl-2">সর্বশেষ লেখা</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php
            $sql = "SELECT 
            news.id as news_id, title_bn, featured_image, news.slug as news_slug, categories.name_bn as category_name , news.created_at
            FROM news JOIN categories ON news.category_id = categories.id 
            WHERE news.author_id = '{$author['id']}' 
            ORDER BY created_at DESC LIMIT 30";
            // die($sql);
            $query = $conn->query($sql);
        ?>
        <?php while($news_more = $query->fetch_assoc()){ ?>
        <div class="bg-white shadow-sm rounded overflow-hidden" onclick="window.location.href='./?feed=<?=$news_more['news_id']?>&slug=<?=$news_more['news_slug']?>'">
            <img class="w-full h-36 object-cover lazy" data-src="<?=$news_more['featured_image']?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='200'%3E%3Crect width='300' height='200' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="article">
            <div class="p-3">
                <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded"> <?=$news_more['category_name']?></span>
                <h4 class="font-semibold mt-1"><?=$news_more['title_bn']?></h4>
                <p class="text-xs text-gray-500 mt-1"><?php echo date('j F Y', strtotime($news_more['created_at'])); ?></p>
            </div>
        </div>
        <?php } ?>  
    </div>
</main>


<?php require_once "components/footer.php"; ?>
<?php require_once "components/ads_script.php"; ?>

<!-- Dark Mode Toggle -->
<!-- <button id="dark-mode-toggle" class="fixed bottom-4 right-4 bg-gray-800 text-white p-3 rounded-full shadow-lg">ডার্ক</button> -->
<script src="assets/js/app.js"></script>
</body>
</html>