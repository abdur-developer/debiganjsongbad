<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title_bn = $conn->real_escape_string($_POST['title_bn']);
    $title_en = $conn->real_escape_string($_POST['title_en']);
    $content = $conn->real_escape_string($_POST['content']);
    $summary = $conn->real_escape_string($_POST['summary']);
    $category_id = intval($_POST['category_id']);
    $author_id = intval($_POST['author_id']);
    $tags = isset($_POST['tags']) 
    ? json_encode(array_map('trim', explode(',', $_POST['tags'])), JSON_UNESCAPED_UNICODE) 
    : null;

    $is_breaking = isset($_POST['is_breaking']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_trending = isset($_POST['is_trending']) ? 1 : 0;
    $status = $conn->real_escape_string($_POST['status']);
    $meta_title = $conn->real_escape_string($_POST['meta_title']);
    $meta_description = $conn->real_escape_string($_POST['meta_description']);
    $meta_keywords = $conn->real_escape_string($_POST['meta_keywords']);
    
    $slug = $functions->createSlug($title_en ?: $title_bn);
    
    // ফিচার ইমেজ আপলোড
    $featured_image = '';
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        $upload = $functions->uploadFile($_FILES['featured_image'], 'news');
        if ($upload['success']) {
            $featured_image = $upload['path'];
        }
    }
    
    // গ্যালারি ইমেজ আপলোড
    $gallery_images = [];
    if (isset($_FILES['gallery_images'])) {
        $files = $_FILES['gallery_images'];
        $fileCount = count($files['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            if ($files['error'][$i] == 0) {
                $file = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                ];
                $upload = $functions->uploadFile($file, 'gallery');
                if ($upload['success']) {
                    $gallery_images[] = $upload['path'];
                }
            }
        }
    }
    
    $gallery_json = !empty($gallery_images) ? json_encode($gallery_images, JSON_UNESCAPED_UNICODE) : '[]';

    
    $published_at = $status == 'published' ? 'NOW()' : 'NULL';
    
    $sql = "INSERT INTO news (title_bn, title_en, slug, content, summary, featured_image, gallery_images, 
            category_id, tags, author_id, is_breaking, is_featured, is_trending, status, 
            meta_title, meta_description, meta_keywords, published_at, created_at) 
            VALUES ('$title_bn', '$title_en', '$slug', '$content', '$summary', '$featured_image', 
            '$gallery_json', $category_id, '$tags', $author_id, $is_breaking, $is_featured, $is_trending, 
            '$status', '$meta_title', '$meta_description', '$meta_keywords', $published_at, NOW())";
    $conn->set_charset("utf8mb4");
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'সংবাদ সফলভাবে যোগ করা হয়েছে';
        echo "<script>window.location.href = 'index.php?q=news';</script>";
        exit();
    } else {
        $error = 'ত্রুটি: ' . $conn->error;
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">নতুন সংবাদ যোগ করুন</h2>
    <a href="index.php" class="bg-gray-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-gray-700">
        <i class="fas fa-arrow-left"></i> ফিরে যান
    </a>
</div>

<?php if (isset($error)): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <?= $error; ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- বাম কলাম -->
        <div class="space-y-4">
            <div>
                <label class="block font-semibold mb-2">শিরোনাম (বাংলা) *</label>
                <input type="text" name="title_bn" required 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">শিরোনাম (ইংরেজি) *</label>
                <input type="text" name="title_en" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ক্যাটাগরি *</label>
                <select name="category_id" required class="w-full px-3 py-2 border rounded">
                    <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                    <?php
                    $catSql = "SELECT * FROM categories WHERE status = 'active' ORDER BY name_bn";
                    $catResult = $conn->query($catSql);
                    while ($cat = $catResult->fetch_assoc()):
                    ?>
                    <option value="<?= $cat['id']; ?>"><?= $cat['name_bn']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-2">প্রতিনিধি *</label>
                <select name="author_id" required class="w-full px-3 py-2 border rounded">
                    <option value="">প্রতিনিধি নির্বাচন করুন</option>
                    <?php
                    $authorSql = "SELECT id, full_name FROM users ORDER BY full_name";
                    $authorResult = $conn->query($authorSql);
                    while ($author = $authorResult->fetch_assoc()):
                    ?>
                    <option value="<?= $author['id']; ?>"><?= $author['full_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ট্যাগ (কমা দিয়ে আলাদা করুন)</label>
                <input type="text" name="tags" placeholder="রাজনীতি, অর্থনীতি, ক্রিকেট" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ফিচার ইমেজ</label>
                <input type="file" name="featured_image" accept="image/*"
                       class="w-full px-3 py-2 border rounded">
                <p class="text-xs text-gray-500 mt-1">সর্বোচ্চ সাইজ: ৫MB (JPG, PNG, WEBP)</p>
            </div>
            
            <!-- <div>
                <label class="block font-semibold mb-2">গ্যালারি ইমেজ (একাধিক)</label>
                <input type="file" name="gallery_images[]" multiple accept="image/*"
                       class="w-full px-3 py-2 border rounded">
            </div> -->
        </div>
        
        <!-- ডান কলাম -->
        <div class="space-y-4">
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস *</label>
                <select name="status" required class="w-full px-3 py-2 border rounded">
                    <option value="draft">খসড়া</option>
                    <option value="published">প্রকাশিত</option>
                    <option value="archived">আর্কাইভ</option>
                </select>
            </div>
            
            <div class="flex gap-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_breaking" class="mr-2">
                    <span>ব্রেকিং নিউজ</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" class="mr-2">
                    <span>ফিচার্ড</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_trending" class="mr-2">
                    <span>ট্রেন্ডিং</span>
                </label>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">সারসংক্ষেপ</label>
                <textarea name="summary" rows="3" 
                          class="w-full px-3 py-2 border rounded"></textarea>
                <p class="text-xs text-gray-500">সংক্ষিপ্ত বিবরণ (SEO-এর জন্য)</p>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">মেটা টাইটেল</label>
                <input type="text" name="meta_title" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">মেটা বিবরণ</label>
                <textarea name="meta_description" rows="2" 
                          class="w-full px-3 py-2 border rounded"></textarea>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">মেটা কীওয়ার্ড</label>
                <input type="text" name="meta_keywords" 
                       class="w-full px-3 py-2 border rounded">
            </div>
        </div>
    </div>
    
    <!-- কন্টেন্ট এডিটর -->
    <div class="mt-6">
        <label class="block font-semibold mb-2">বিস্তারিত *</label>
        <textarea name="content" id="editor" rows="10" 
                  class="w-full px-3 py-2 border rounded"></textarea>
    </div>
    
    <div class="mt-6 flex justify-end gap-2">
        <button type="reset" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
            রিসেট
        </button>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
            সংরক্ষণ করুন
        </button>
    </div>
</form>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>