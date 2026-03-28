<?php
$auth->requirePermission('ads');
$id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;

if (!$id) {
    echo "<script>window.location.href = 'index.php?q=ads';</script>";
    exit();
}

$sql = "SELECT * FROM ads WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>window.location.href = 'index.php?q=ads';</script>";
    exit();
}

$ad = $result->fetch_assoc();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $ad_name = $conn->real_escape_string($_POST['ad_name']);
    $ad_code = $conn->real_escape_string($_POST['ad_code']);
    $ad_position = $conn->real_escape_string($_POST['ad_position']);
    $ad_size = $conn->real_escape_string($_POST['ad_size']);
    $device_type = $conn->real_escape_string($_POST['device_type']);
    $max_impressions = $conn->real_escape_string($_POST['max_impressions']);
    $max_clicks = $conn->real_escape_string($_POST['max_clicks']);
    $status = $conn->real_escape_string($_POST['status']);
    
    if (empty($ad_name)) {
        $error = 'শিরোনাম প্রয়োজন';
    } else {
        
        if (empty($error)) {
            $sql = "UPDATE ads SET 
                    ad_name = '$ad_name',
                    ad_code = '$ad_code',
                    -- ad_position = '$ad_position',
                    -- ad_size = '$ad_size',
                    -- device_type = '$device_type',
                    max_impressions = '$max_impressions',
                    max_clicks = '$max_clicks',
                    status = '$status'
                    WHERE id = $id";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'বিজ্ঞাপন আপডেট হয়েছে';
                echo "<script>window.location.href = 'index.php?q=ads';</script>";
                exit();
            } else {
                $error = 'ত্রুটি: ' . $conn->error;
            }
        }
    }
}

$positions = ['header', 'sidebar', 'footer', 'between_news', 'popup'];
$types = ['banner', 'sidebar', 'popup', 'video'];
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">বিজ্ঞাপন সম্পাদনা</h2>
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
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $ad['id']; ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-2">শিরোনাম *</label>
                <input type="text" name="ad_name" value="<?php echo e($ad['ad_name']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            <div>
                <label class="block font-semibold mb-2">অবস্থান *</label>
                <select name="ad_position" required class="w-full px-3 py-2 border rounded" readonly>
                    <?php foreach ($positions as $pos): ?>
                    <option value="<?php echo $pos; ?>" <?php echo $ad['ad_position'] == $pos ? 'selected' : ''; ?>>
                        <?php echo ucfirst($pos); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-2">সাইজ *</label>
                <select name="ad_size" required class="w-full px-3 py-2 border rounded" readonly>
                    <option value="300x250" <?php echo $ad['ad_size'] == '300x250' ? 'selected' : ''; ?>>300x250</option>
                    <option value="728x90" <?php echo $ad['ad_size'] == '728x90' ? 'selected' : ''; ?>>728x90</option>
                    <option value="160x600" <?php echo $ad['ad_size'] == '160x600' ? 'selected' : ''; ?>>160x600</option>
                    <option value="320x50" <?php echo $ad['ad_size'] == '320x50' ? 'selected' : ''; ?>>320x50</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-2">ডিভাইস *</label>
                <select name="device_type" required class="w-full px-3 py-2 border rounded" readonly>
                    <option value="all" <?php echo $ad['device_type'] == 'all' ? 'selected' : ''; ?>>সব</option>
                    <option value="desktop" <?php echo $ad['device_type'] == 'desktop' ? 'selected' : ''; ?>>ডেস্কটপ</option>
                    <option value="mobile" <?php echo $ad['device_type'] == 'mobile' ? 'selected' : ''; ?>>মোবাইল</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-2">ম্যাক্স ইমপ্রেশন *</label>
                <input type="number" name="max_impressions" value="<?php echo e($ad['max_impressions']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            <div>
                <label class="block font-semibold mb-2">ম্যাক্স ক্লিক *</label>
                <input type="number" name="max_clicks" value="<?php echo e($ad['max_clicks']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস *</label>
                <select name="status" required class="w-full px-3 py-2 border rounded">
                    <option value="1" <?php echo $ad['status'] == '1' ? 'selected' : ''; ?>>সক্রিয়</option>
                    <option value="0" <?php echo $ad['status'] == '0' ? 'selected' : ''; ?>>নিষ্ক্রিয়</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">HTML কোড</label>
                <textarea name="ad_code" rows="4" class="w-full px-3 py-2 border rounded font-mono text-sm"><?php echo e($ad['ad_code']); ?></textarea>
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