<?php
$auth->requirePermission('settings');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key != 'submit') {
            $value = $conn->real_escape_string($value);
            $conn->query("UPDATE settings SET value = '$value' WHERE key_name = '$key'");
        }
    }
    
    // লোগো আপলোড
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $upload = $functions->uploadFile($_FILES['logo'], 'settings');
        if ($upload['success']) {
            $conn->query("UPDATE settings SET value = '{$upload['path']}' WHERE key_name = 'logo'");
        }
    }
    
    // ফেভিকন আপলোড
    if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] == 0) {
        $upload = $functions->uploadFile($_FILES['favicon'], 'settings', ['ico', 'png']);
        if ($upload['success']) {
            $conn->query("UPDATE settings SET value = '{$upload['path']}' WHERE key_name = 'favicon'");
        }
    }
    
    $_SESSION['success'] = 'সেটিংস সফলভাবে আপডেট হয়েছে';
}

$sql = "SELECT * FROM settings ORDER BY id";
$result = $conn->query($sql);
$settings = [];
while ($row = $result->fetch_assoc()) {
    $settings[$row['key_name']] = $row['value'];
}
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">সেটিংস</h2>
</div>

<?php if (isset($_SESSION['success'])): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- সাধারণ সেটিংস -->
        <!-- <div class="space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">সাধারণ সেটিংস</h3> -->
            
            <!-- <div>
                <label class="block font-semibold mb-2">সাইটের নাম</label>
                <input type="text" name="site_title" value="<php echo e($settings['site_title']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div> -->
            
            <!-- <div>
                <label class="block font-semibold mb-2">সাইট URL</label>
                <input type="url" name="site_url" value="<php echo e($settings['site_url']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div> -->
            
            <!-- <div>
                <label class="block font-semibold mb-2">সাইট বিবরণ</label>
                <textarea name="site_description" rows="3" 
                          class="w-full px-3 py-2 border rounded"><php echo e($settings['site_description']); ?></textarea>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">কীওয়ার্ড</label>
                <input type="text" name="site_keywords" value="<php echo e($settings['site_keywords']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div> -->
        <!-- </div> -->
        
        <!-- যোগাযোগ সেটিংস -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">যোগাযোগ তথ্য</h3>
            
            <!-- <div>
                <label class="block font-semibold mb-2">অ্যাডমিন ইমেইল</label>
                <input type="email" name="admin_email" value="<php echo e($settings['admin_email']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div> -->
            
            <div>
                <label class="block font-semibold mb-2">যোগাযোগ ইমেইল</label>
                <input type="email" name="contact_email" value="<?php echo e($settings['contact_email']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ফোন</label>
                <input type="text" name="phone" value="<?php echo e($settings['phone']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ঠিকানা</label>
                <textarea name="address" rows="2" 
                          class="w-full px-3 py-2 border rounded"><?php echo e($settings['address']); ?></textarea>
            </div>
        </div>
        
        <!-- সোশ্যাল মিডিয়া -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">সোশ্যাল মিডিয়া লিংক</h3>
            
            <div>
                <label class="block font-semibold mb-2">ফেসবুক</label>
                <input type="url" name="facebook_url" value="<?php echo e($settings['facebook_url']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <!-- <div>
                <label class="block font-semibold mb-2">টুইটার</label>
                <input type="url" name="twitter_url" value="<php echo e($settings['twitter_url']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div> -->
            
            <div>
                <label class="block font-semibold mb-2">ইউটিউব</label>
                <input type="url" name="youtube_url" value="<?php echo e($settings['youtube_url']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <!-- <div>
                <label class="block font-semibold mb-2">ইনস্টাগ্রাম</label>
                <input type="url" name="instagram_url" value="<php echo e($settings['instagram_url']); ?>" 
                       class="w-full px-3 py-2 border rounded">
            </div> -->
        </div>
        
        <!-- লোগো ও ফেভিকন -->
        <!-- <div class="space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">লোগো ও ফেভিকন</h3>
            
            <div>
                <label class="block font-semibold mb-2">বর্তমান লোগো</label>
                <php if (!empty($settings['logo'])): ?>
                <img src="<php echo $settings['logo']; ?>" class="h-16 mb-2" alt="">
                <php endif; ?>
                <input type="file" name="logo" accept="image/*" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">বর্তমান ফেভিকন</label>
                <php if (!empty($settings['favicon'])): ?>
                <img src="<php echo $settings['favicon']; ?>" class="h-8 mb-2" alt="">
                <php endif; ?>
                <input type="file" name="favicon" accept=".ico,.png" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ফুটার টেক্সট</label>
                <textarea name="footer_text" rows="2" 
                          class="w-full px-3 py-2 border rounded"><php echo e($settings['footer_text']); ?></textarea>
            </div>
        </div> -->
    </div>
    
    <div class="mt-6 flex justify-end">
        <button type="submit" name="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
            সেটিংস সংরক্ষণ করুন
        </button>
    </div>
</form>