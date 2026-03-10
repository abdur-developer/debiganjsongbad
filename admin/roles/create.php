<?php
// admin/roles/create.php
require_once '../includes/header.php';

$auth->requirePermission('users');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $conn->real_escape_string(strtolower($_POST['role']));
    $permissions = [];
    
    // পারমিশন সংগ্রহ
    $permissionFields = ['news', 'categories', 'users', 'settings', 'ads', 'comments', 'gallery'];
    foreach ($permissionFields as $field) {
        $permissions[$field] = $_POST[$field] ?? 'none';
    }
    
    $permissions_json = json_encode($permissions);
    
    if (empty($role)) {
        $error = 'রোল নাম প্রয়োজন';
    } else {
        $checkSql = "SELECT id FROM roles_permissions WHERE role = '$role'";
        $checkResult = $conn->query($checkSql);
        
        if ($checkResult->num_rows > 0) {
            $error = 'এই রোল ইতিমধ্যে exists';
        } else {
            $sql = "INSERT INTO roles_permissions (role, permissions, created_at) 
                    VALUES ('$role', '$permissions_json', NOW())";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'রোল তৈরি হয়েছে';
                header('Location: index.php');
                exit();
            } else {
                $error = 'ত্রুটি: ' . $conn->error;
            }
        }
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">নতুন রোল তৈরি করুন</h2>
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
        <div class="mb-4">
            <label class="block font-semibold mb-2">রোল নাম *</label>
            <input type="text" name="role" value="<?php echo htmlspecialchars($_POST['role'] ?? ''); ?>" required
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500"
                   placeholder="যেমন: moderator, contributor">
        </div>
        
        <h3 class="font-semibold mb-3">পারমিশন সেট করুন</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- নিউজ পারমিশন -->
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2">নিউজ</label>
                <select name="news" class="w-full border rounded px-3 py-2">
                    <option value="none">কিছুই না</option>
                    <option value="view">শুধু দেখতে</option>
                    <option value="create_edit">তৈরি ও এডিট</option>
                    <option value="all">সম্পূর্ণ (তৈরি, এডিট, ডিলিট)</option>
                </select>
            </div>
            
            <!-- ক্যাটাগরি পারমিশন -->
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2">ক্যাটাগরি</label>
                <select name="categories" class="w-full border rounded px-3 py-2">
                    <option value="none">কিছুই না</option>
                    <option value="view">শুধু দেখতে</option>
                    <option value="create_edit">তৈরি ও এডিট</option>
                    <option value="all">সম্পূর্ণ</option>
                </select>
            </div>
            
            <!-- ইউজার পারমিশন -->
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2">ব্যবহারকারী</label>
                <select name="users" class="w-full border rounded px-3 py-2">
                    <option value="none">কিছুই না</option>
                    <option value="view">শুধু দেখতে</option>
                    <option value="create_edit">তৈরি ও এডিট</option>
                    <option value="all">সম্পূর্ণ</option>
                </select>
            </div>
            
            <!-- সেটিংস পারমিশন -->
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2">সেটিংস</label>
                <select name="settings" class="w-full border rounded px-3 py-2">
                    <option value="none">কিছুই না</option>
                    <option value="view">শুধু দেখতে</option>
                    <option value="edit">এডিট</option>
                </select>
            </div>
            
            <!-- বিজ্ঞাপন পারমিশন -->
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2">বিজ্ঞাপন</label>
                <select name="ads" class="w-full border rounded px-3 py-2">
                    <option value="none">কিছুই না</option>
                    <option value="view">শুধু দেখতে</option>
                    <option value="create_edit">তৈরি ও এডিট</option>
                    <option value="all">সম্পূর্ণ</option>
                </select>
            </div>
            
            <!-- কমেন্ট পারমিশন -->
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2">মন্তব্য</label>
                <select name="comments" class="w-full border rounded px-3 py-2">
                    <option value="none">কিছুই না</option>
                    <option value="view">শুধু দেখতে</option>
                    <option value="approve">অনুমোদন</option>
                    <option value="all">সম্পূর্ণ</option>
                </select>
            </div>
            
            <!-- গ্যালারি পারমিশন -->
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2">গ্যালারি</label>
                <select name="gallery" class="w-full border rounded px-3 py-2">
                    <option value="none">কিছুই না</option>
                    <option value="view">শুধু দেখতে</option>
                    <option value="create_edit">তৈরি ও এডিট</option>
                    <option value="all">সম্পূর্ণ</option>
                </select>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end gap-2">
            <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                বাতিল
            </a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                রোল তৈরি করুন
            </button>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>