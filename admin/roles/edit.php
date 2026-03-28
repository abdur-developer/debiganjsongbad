<?php
$auth->requirePermission('users');

$id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;

if (!$id) {
    echo "<script>window.location.href = 'index.php?q=roles';</script>";
    exit();
}

$sql = "SELECT * FROM roles_permissions WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>window.location.href = 'index.php?q=roles';</script>";
    exit();
}

$role = $result->fetch_assoc();
$permissions = json_decode($role['permissions'], true);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role_name = $conn->real_escape_string(strtolower($_POST['role']));
    $new_permissions = [];
    
    $permissionFields = ['news', 'categories', 'users', 'settings', 'ads', 'comments', 'gallery'];
    foreach ($permissionFields as $field) {
        $new_permissions[$field] = $_POST[$field] ?? 'none';
    }
    
    $permissions_json = json_encode($new_permissions);
    
    if (empty($role_name)) {
        $error = 'রোল নাম প্রয়োজন';
    } elseif ($role['role'] == 'super_admin') {
        $error = 'সুপার অ্যাডমিন এডিট করা যাবে না';
    } else {
        $checkSql = "SELECT id FROM roles_permissions WHERE role = '$role_name' AND id != $id";
        $checkResult = $conn->query($checkSql);
        
        if ($checkResult->num_rows > 0) {
            $error = 'এই রোল ইতিমধ্যে exists';
        } else {
            $updateSql = "UPDATE roles_permissions SET 
                          role = '$role_name',
                          permissions = '$permissions_json',
                          created_at = NOW()
                          WHERE id = $id";
            
            if ($conn->query($updateSql)) {
                $_SESSION['success'] = 'রোল আপডেট হয়েছে';
                echo "<script>window.location.href = 'index.php?q=roles';</script>";
                exit();
            } else {
                $error = 'ত্রুটি: ' . $conn->error;
            }
        }
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">রোল সম্পাদনা</h2>
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
        <div class="mb-4">
            <label class="block font-semibold mb-2">রোল নাম *</label>
            <input type="text" name="role" value="<?php echo e($role['role']); ?>" required
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500"
                   <?php echo $role['role'] == 'super_admin' ? 'readonly' : ''; ?>>
        </div>
        
        <h3 class="font-semibold mb-3">পারমিশন সেট করুন</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            $permissionFields = [
                'news' => 'নিউজ',
                'categories' => 'ক্যাটাগরি',
                'users' => 'ব্যবহারকারী',
                'settings' => 'সেটিংস',
                'ads' => 'বিজ্ঞাপন',
                'comments' => 'মন্তব্য',
                'gallery' => 'গ্যালারি'
            ];
            
            $options = [
                'news' => ['none' => 'কিছুই না', 'view' => 'শুধু দেখতে', 'create_edit' => 'তৈরি ও এডিট', 'all' => 'সম্পূর্ণ'],
                'categories' => ['none' => 'কিছুই না', 'view' => 'শুধু দেখতে', 'create_edit' => 'তৈরি ও এডিট', 'all' => 'সম্পূর্ণ'],
                'users' => ['none' => 'কিছুই না', 'view' => 'শুধু দেখতে', 'create_edit' => 'তৈরি ও এডিট', 'all' => 'সম্পূর্ণ'],
                'settings' => ['none' => 'কিছুই না', 'view' => 'শুধু দেখতে', 'create_edit' => 'এডিট', 'all' => 'সম্পূর্ণ'],
                'ads' => ['none' => 'কিছুই না', 'view' => 'শুধু দেখতে', 'create_edit' => 'তৈরি ও এডিট', 'all' => 'সম্পূর্ণ'],
                'comments' => ['none' => 'কিছুই না', 'view' => 'শুধু দেখতে', 'approve' => 'অনুমোদন', 'all' => 'সম্পূর্ণ'],
                'gallery' => ['none' => 'কিছুই না', 'view' => 'শুধু দেখতে', 'create_edit' => 'তৈরি ও এডিট', 'all' => 'সম্পূর্ণ']
            ];
            
            foreach ($permissionFields as $key => $label):
            ?>
            <div class="border rounded-lg p-4">
                <label class="font-semibold block mb-2"><?php echo $label; ?></label>
                <select name="<?php echo $key; ?>" class="w-full border rounded px-3 py-2">
                    <?php foreach ($options[$key] as $val => $text): ?>
                    <option value="<?php echo $val; ?>" <?php echo ($permissions[$key] ?? 'none') == $val ? 'selected' : ''; ?>>
                        <?php echo $text; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endforeach; ?>
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