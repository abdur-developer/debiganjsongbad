<?php
$auth->requirePermission('ads');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $type = $conn->real_escape_string($_POST['type']);
    $position = $conn->real_escape_string($_POST['position']);
    $link = $conn->real_escape_string($_POST['link']);
    $code = $conn->real_escape_string($_POST['code']);
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $status = $conn->real_escape_string($_POST['status']);
    
    if (empty($title)) {
        $error = 'শিরোনাম প্রয়োজন';
    } else {
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload = $functions->uploadFile($_FILES['image'], 'ads', ['jpg', 'jpeg', 'png', 'gif']);
            if ($upload['success']) {
                $image = $upload['path'];
            } else {
                $error = $upload['error'];
            }
        }
        
        if (empty($error)) {
            $created_by = $_SESSION['user_id'];
            
            $sql = "INSERT INTO advertisements (title, type, position, image, code, link, start_date, end_date, status, created_by, created_at) 
                    VALUES ('$title', '$type', '$position', '$image', '$code', '$link', '$start_date', '$end_date', '$status', $created_by, NOW())";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'বিজ্ঞাপন যোগ করা হয়েছে';
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
    <h2 class="text-lg md:text-2xl font-bold">নতুন বিজ্ঞাপন যোগ করুন</h2>
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-2">শিরোনাম *</label>
                <input type="text" name="title" value="<?php echo e($_POST['title'] ?? ''); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">টাইপ *</label>
                <select name="type" required class="w-full px-3 py-2 border rounded">
                    <?php foreach ($types as $t): ?>
                    <option value="<?php echo $t; ?>"><?php echo ucfirst($t); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">পজিশন *</label>
                <select name="position" required class="w-full px-3 py-2 border rounded">
                    <?php foreach ($positions as $p): ?>
                    <option value="<?php echo $p; ?>"><?php echo ucfirst($p); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">লিংক</label>
                <input type="url" name="link" value="<?php echo e($_POST['link'] ?? ''); ?>"
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্টার্ট তারিখ</label>
                <input type="date" name="start_date" value="<?php echo $_POST['start_date'] ?? date('Y-m-d'); ?>"
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">এন্ড তারিখ</label>
                <input type="date" name="end_date" value="<?php echo $_POST['end_date'] ?? date('Y-m-d', strtotime('+30 days')); ?>"
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস *</label>
                <select name="status" required class="w-full px-3 py-2 border rounded">
                    <option value="active">সক্রিয়</option>
                    <option value="inactive">নিষ্ক্রিয়</option>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ছবি আপলোড</label>
                <input type="file" name="image" accept="image/*" class="w-full">
                <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (সর্বোচ্চ ২MB)</p>
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">HTML কোড (যদি থাকে)</label>
                <textarea name="code" rows="4" class="w-full px-3 py-2 border rounded font-mono text-sm"><?php echo e($_POST['code'] ?? ''); ?></textarea>
                <p class="text-xs text-gray-500 mt-1">ছবি এবং লিংকের পরিবর্তে সরাসরি HTML কোড দিতে চাইলে</p>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end gap-2">
            <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                বাতিল
            </a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                সংরক্ষণ করুন
            </button>
        </div>
    </form>
</div>