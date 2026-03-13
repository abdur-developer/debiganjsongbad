<?php
$auth->requirePermission('categories');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_bn = $conn->real_escape_string($_POST['name_bn']);
    $name_en = $conn->real_escape_string($_POST['name_en']);
    $description = $conn->real_escape_string($_POST['description']);
    $parent_id = intval($_POST['parent_id']);
    $sort_order = intval($_POST['sort_order']);
    $status = $conn->real_escape_string($_POST['status']);
    
    // স্লাগ জেনারেট
    if (!empty($_POST['slug'])) {
        $slug = $conn->real_escape_string($_POST['slug']);
    } else {
        $slug = $functions->createSlug($name_en ?: $name_bn);
    }
    
    // ভ্যালিডেশন
    if (empty($name_bn)) {
        $error = 'ক্যাটাগরির নাম (বাংলা) প্রয়োজন';
    } else {
        // চেক ডুপ্লিকেট
        $checkSql = "SELECT id FROM categories WHERE name_bn = '$name_bn' OR slug = '$slug'";
        $checkResult = $conn->query($checkSql);
        
        if ($checkResult->num_rows > 0) {
            $error = 'এই নাম বা স্লাগ ইতিমধ্যে exists';
        } else {
            $created_by = $_SESSION['user_id'];
            
            $sql = "INSERT INTO categories (name_bn, name_en, slug, description, parent_id, sort_order, status, created_by, created_at) 
                    VALUES ('$name_bn', '$name_en', '$slug', '$description', $parent_id, $sort_order, '$status', $created_by, NOW())";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'ক্যাটাগরি সফলভাবে যোগ করা হয়েছে';
                echo "<script>window.location.href = 'index.php?q=categories';</script>";
                exit();
            } else {
                $error = 'ত্রুটি: ' . $conn->error;
            }
        }
    }
}

// প্যারেন্ট ক্যাটাগরি লিস্ট
$parentSql = "SELECT * FROM categories WHERE status = 'active' ORDER BY name_bn";
$parentResult = $conn->query($parentSql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">নতুন ক্যাটাগরি যোগ করুন</h2>
    <a href="index.php" class="bg-gray-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-gray-700">
        <i class="fas fa-arrow-left"></i> ফিরে যান
    </a>
</div>

<?php if ($error): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-2">নাম (বাংলা) *</label>
                <input type="text" name="name_bn" value="<?php echo htmlspecialchars($_POST['name_bn'] ?? ''); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">নাম (ইংরেজি)</label>
                <input type="text" name="name_en" value="<?php echo htmlspecialchars($_POST['name_en'] ?? ''); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500"
                       onkeyup="generateSlug(this.value)">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্লাগ</label>
                <input type="text" name="slug" id="slug" value="<?php echo htmlspecialchars($_POST['slug'] ?? ''); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
                <p class="text-xs text-gray-500 mt-1">ইংরেজি নাম থেকে অটো জেনারেট হবে</p>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">প্যারেন্ট ক্যাটাগরি</label>
                <select name="parent_id" class="w-full px-3 py-2 border rounded">
                    <option value="0">-- মূল ক্যাটাগরি --</option>
                    <?php while ($parent = $parentResult->fetch_assoc()): ?>
                    <option value="<?php echo $parent['id']; ?>" <?php echo ($_POST['parent_id'] ?? 0) == $parent['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($parent['name_bn']); ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">সর্ডার অর্ডার</label>
                <input type="number" name="sort_order" value="<?php echo htmlspecialchars($_POST['sort_order'] ?? '0'); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
                <p class="text-xs text-gray-500 mt-1">ছোট সংখ্যা আগে দেখাবে</p>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস</label>
                <select name="status" class="w-full px-3 py-2 border rounded">
                    <option value="active" <?php echo ($_POST['status'] ?? '') == 'active' ? 'selected' : ''; ?>>সক্রিয়</option>
                    <option value="inactive" <?php echo ($_POST['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>নিষ্ক্রিয়</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">বিবরণ</label>
                <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>
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
</div>

<script>
function generateSlug(value) {
    if (!value) return;
    
    const slug = value.toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/--+/g, '-')
        .trim();
    
    $('#slug').val(slug);
}
</script>