<?php
$auth->requirePermission('news');

$id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;

if (!$id) {
    header('Location: index.php');
    exit();
}

$sql = "SELECT n.*, u.full_name as author_name 
        FROM news n 
        LEFT JOIN users u ON n.author_id = u.id 
        WHERE n.id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header('Location: index.php');
    exit();
}

$news = $result->fetch_assoc();

// ট্যাগ ডিকোড
$tags = !empty($news['tags']) ? implode(', ', json_decode($news['tags'], true)) : '';
$gallery = !empty($news['gallery_images']) ? json_decode($news['gallery_images'], true) : [];

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title_bn = $conn->real_escape_string($_POST['title_bn']);
    $title_en = $conn->real_escape_string($_POST['title_en']);
    $content = $conn->real_escape_string($_POST['content']);
    $summary = $conn->real_escape_string($_POST['summary']);
    $category_id = intval($_POST['category_id']);
    $tags_input = $_POST['tags'];
    $tags_array = array_map('trim', explode(',', $tags_input));
    $tags_json = json_encode($tags_array);
    $is_breaking = isset($_POST['is_breaking']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_trending = isset($_POST['is_trending']) ? 1 : 0;
    $status = $conn->real_escape_string($_POST['status']);
    $meta_title = $conn->real_escape_string($_POST['meta_title']);
    $meta_description = $conn->real_escape_string($_POST['meta_description']);
    $meta_keywords = $conn->real_escape_string($_POST['meta_keywords']);
    
    if (empty($title_bn)) {
        $error = 'শিরোনাম প্রয়োজন';
    } else {
        $slug = $functions->createSlug($title_en ?: $title_bn);
        
        // ফিচার ইমেজ আপলোড
        $featured_image = $news['featured_image'];
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
            $upload = $functions->uploadFile($_FILES['featured_image'], 'news');
            if ($upload['success']) {
                // পুরাতন ইমেজ ডিলিট
                if (!empty($featured_image) && file_exists($_SERVER['DOCUMENT_ROOT'] . $featured_image)) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $featured_image);
                }
                $featured_image = $upload['path'];
            }
        }
        
        // গ্যালারি ইমেজ
        $gallery_images = $news['gallery_images'] ? json_decode($news['gallery_images'], true) : [];
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
        
        $gallery_json = !empty($gallery_images) ? json_encode($gallery_images) : null;
        
        $published_at = ($status == 'published' && $news['status'] != 'published') ? 'NOW()' : "NULL";
        if ($status == 'published' && $news['status'] != 'published') {
            $published_at = 'NOW()';
        } else {
            $published_at = $news['published_at'] ? "'{$news['published_at']}'" : 'NULL';
        }
        
        $sql = "UPDATE news SET 
                title_bn = '$title_bn',
                title_en = '$title_en',
                slug = '$slug',
                content = '$content',
                summary = '$summary',
                featured_image = " . ($featured_image ? "'$featured_image'" : "NULL") . ",
                gallery_images = " . ($gallery_json ? "'$gallery_json'" : "NULL") . ",
                category_id = $category_id,
                tags = '$tags_json',
                is_breaking = $is_breaking,
                is_featured = $is_featured,
                is_trending = $is_trending,
                status = '$status',
                meta_title = '$meta_title',
                meta_description = '$meta_description',
                meta_keywords = '$meta_keywords',
                published_at = $published_at,
                updated_at = NOW()
                WHERE id = $id";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = 'সংবাদ আপডেট হয়েছে';
            header('Location: index.php');
            exit();
        } else {
            $error = 'ত্রুটি: ' . $conn->error;
        }
    }
}

// ক্যাটাগরি লিস্ট
$catSql = "SELECT * FROM categories WHERE status = 'active' ORDER BY name_bn";
$catResult = $conn->query($catSql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">সংবাদ সম্পাদনা</h2>
    <div class="flex gap-2">
        <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            <i class="fas fa-arrow-left"></i> ফিরে যান
        </a>
        <a href="../preview.php?id=<?php echo $id; ?>" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-eye"></i> প্রিভিউ
        </a>
    </div>
</div>

<?php if ($error): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- বাম কলাম - কন্টেন্ট -->
        <div class="md:col-span-2 space-y-4">
            <div>
                <label class="block font-semibold mb-2">শিরোনাম (বাংলা) *</label>
                <input type="text" name="title_bn" value="<?php echo htmlspecialchars($news['title_bn']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">শিরোনাম (ইংরেজি)</label>
                <input type="text" name="title_en" value="<?php echo htmlspecialchars($news['title_en']); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">বিস্তারিত *</label>
                <textarea name="content" id="editor" rows="12"><?php echo htmlspecialchars($news['content']); ?></textarea>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">সারসংক্ষেপ</label>
                <textarea name="summary" rows="3" class="w-full px-3 py-2 border rounded"><?php echo htmlspecialchars($news['summary']); ?></textarea>
            </div>
        </div>
        
        <!-- ডান কলাম - মেটা ও সেটিংস -->
        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-3">পাবলিশ সেটিংস</h3>
                
                <div class="mb-3">
                    <label class="block font-semibold mb-2">ক্যাটাগরি *</label>
                    <select name="category_id" required class="w-full px-3 py-2 border rounded">
                        <option value="">নির্বাচন করুন</option>
                        <?php while ($cat = $catResult->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $news['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo $cat['name_bn']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="block font-semibold mb-2">স্ট্যাটাস</label>
                    <select name="status" class="w-full px-3 py-2 border rounded">
                        <option value="draft" <?php echo $news['status'] == 'draft' ? 'selected' : ''; ?>>খসড়া</option>
                        <option value="published" <?php echo $news['status'] == 'published' ? 'selected' : ''; ?>>প্রকাশিত</option>
                        <option value="archived" <?php echo $news['status'] == 'archived' ? 'selected' : ''; ?>>আর্কাইভ</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="block font-semibold mb-2">ট্যাগ (কমা দিয়ে আলাদা)</label>
                    <input type="text" name="tags" value="<?php echo htmlspecialchars($tags); ?>" 
                           class="w-full px-3 py-2 border rounded" placeholder="রাজনীতি, অর্থনীতি, ক্রিকেট">
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_breaking" class="mr-2" <?php echo $news['is_breaking'] ? 'checked' : ''; ?>>
                        <span>ব্রেকিং নিউজ</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" class="mr-2" <?php echo $news['is_featured'] ? 'checked' : ''; ?>>
                        <span>ফিচার্ড</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_trending" class="mr-2" <?php echo $news['is_trending'] ? 'checked' : ''; ?>>
                        <span>ট্রেন্ডিং</span>
                    </label>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-3">ফিচার ইমেজ</h3>
                
                <?php if (!empty($news['featured_image'])): ?>
                <div class="mb-3">
                    <img src="<?php echo $news['featured_image']; ?>" class="w-full h-32 object-cover rounded-lg" alt="">
                </div>
                <?php endif; ?>
                
                <input type="file" name="featured_image" accept="image/*" class="w-full">
                <p class="text-xs text-gray-500 mt-1">সর্বোচ্চ ৫MB (JPG, PNG, WEBP)</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-3">গ্যালারি ইমেজ</h3>
                
                <?php if (!empty($gallery)): ?>
                <div class="grid grid-cols-3 gap-2 mb-3">
                    <?php foreach ($gallery as $img): ?>
                    <div class="relative">
                        <img src="<?php echo $img; ?>" class="w-full h-16 object-cover rounded" alt="">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <input type="file" name="gallery_images[]" multiple accept="image/*" class="w-full">
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-3">SEO তথ্য</h3>
                
                <div class="mb-3">
                    <label class="block text-sm mb-1">মেটা টাইটেল</label>
                    <input type="text" name="meta_title" value="<?php echo htmlspecialchars($news['meta_title']); ?>"
                           class="w-full px-3 py-2 border rounded text-sm">
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm mb-1">মেটা বিবরণ</label>
                    <textarea name="meta_description" rows="2" class="w-full px-3 py-2 border rounded text-sm"><?php echo htmlspecialchars($news['meta_description']); ?></textarea>
                </div>
                
                <div>
                    <label class="block text-sm mb-1">মেটা কীওয়ার্ড</label>
                    <input type="text" name="meta_keywords" value="<?php echo htmlspecialchars($news['meta_keywords']); ?>"
                           class="w-full px-3 py-2 border rounded text-sm">
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end gap-2">
        <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
            বাতিল
        </a>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
            আপডেট করুন
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