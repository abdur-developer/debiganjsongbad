<?php
$auth->requirePermission('categories');

$id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;

if (!$id) {
    header('Location: index.php');
    exit();
}

// ক্যাটাগরি তথ্য
$sql = "SELECT * FROM categories WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header('Location: index.php');
    exit();
}

$category = $result->fetch_assoc();

$error = '';

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
    
    if (empty($name_bn)) {
        $error = 'ক্যাটাগরির নাম (বাংলা) প্রয়োজন';
    } else {
        // চেক ডুপ্লিকেট (নিজে বাদে)
        $checkSql = "SELECT id FROM categories WHERE (name_bn = '$name_bn' OR slug = '$slug') AND id != $id";
        $checkResult = $conn->query($checkSql);
        
        if ($checkResult->num_rows > 0) {
            $error = 'এই নাম বা স্লাগ ইতিমধ্যে exists';
        } else {
            $sql = "UPDATE categories SET 
                    name_bn = '$name_bn',
                    name_en = '$name_en',
                    slug = '$slug',
                    description = '$description',
                    parent_id = $parent_id,
                    sort_order = $sort_order,
                    status = '$status',
                    updated_at = NOW()
                    WHERE id = $id";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'ক্যাটাগরি আপডেট হয়েছে';
                header('Location: index.php');
                exit();
            } else {
                $error = 'ত্রুটি: ' . $conn->error;
            }
        }
    }
}

// প্যারেন্ট ক্যাটাগরি লিস্ট (নিজে বাদে)
$parentSql = "SELECT * FROM categories WHERE status = 'active' AND id != $id ORDER BY name_bn";
$parentResult = $conn->query($parentSql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">ক্যাটাগরি সম্পাদনা</h2>
    <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
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
                <input type="text" name="name_bn" value="<?php echo htmlspecialchars($category['name_bn']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">নাম (ইংরেজি)</label>
                <input type="text" name="name_en" value="<?php echo htmlspecialchars($category['name_en']); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500"
                       onkeyup="generateSlug(this.value)">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্লাগ</label>
                <input type="text" name="slug" id="slug" value="<?php echo htmlspecialchars($category['slug']); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">প্যারেন্ট ক্যাটাগরি</label>
                <select name="parent_id" class="w-full px-3 py-2 border rounded">
                    <option value="0">-- মূল ক্যাটাগরি --</option>
                    <?php while ($parent = $parentResult->fetch_assoc()): ?>
                    <option value="<?php echo $parent['id']; ?>" <?php echo $category['parent_id'] == $parent['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($parent['name_bn']); ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">সর্ডার অর্ডার</label>
                <input type="number" name="sort_order" value="<?php echo $category['sort_order']; ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস</label>
                <select name="status" class="w-full px-3 py-2 border rounded">
                    <option value="active" <?php echo $category['status'] == 'active' ? 'selected' : ''; ?>>সক্রিয়</option>
                    <option value="inactive" <?php echo $category['status'] == 'inactive' ? 'selected' : ''; ?>>নিষ্ক্রিয়</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">বিবরণ</label>
                <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded"><?php echo htmlspecialchars($category['description']); ?></textarea>
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