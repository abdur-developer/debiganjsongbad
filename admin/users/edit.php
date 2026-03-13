<?php
$auth->requirePermission('users');

$id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;

if (!$id) {
    echo "<script>window.location.href = 'index.php?q=users';</script>";
    exit();
}

$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>window.location.href = 'index.php?q=users';</script>";
    exit();
}

$user = $result->fetch_assoc();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role = $conn->real_escape_string($_POST['role']);
    $status = $conn->real_escape_string($_POST['status']);
    $bio = $conn->real_escape_string($_POST['bio']);
    
    if (empty($username) || empty($email) || empty($full_name)) {
        $error = 'সব প্রয়োজনীয় তথ্য দিন';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'সঠিক ইমেইল দিন';
    } else {
        $checkSql = "SELECT id FROM users WHERE (username = '$username' OR email = '$email') AND id != $id";
        $checkResult = $conn->query($checkSql);
        
        if ($checkResult->num_rows > 0) {
            $error = 'এই ইউজারনেম বা ইমেইল ইতিমধ্যে exists';
        } else {
            // পাসওয়ার্ড আপডেট
            $passwordSql = '';
            if (!empty($_POST['password'])) {
                $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $passwordSql = ", password = '$hashed'";
            }
            
            // ছবি আপলোড
            $avatar = $user['avatar'];
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $upload = $functions->uploadFile($_FILES['avatar'], 'avatars', ['jpg', 'jpeg', 'png']);
                if ($upload['success']) {
                    // পুরাতন ছবি ডিলিট
                    if (!empty($avatar) && file_exists($_SERVER['DOCUMENT_ROOT'] . $avatar)) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $avatar);
                    }
                    $avatar = $upload['path'];
                }
            }
            
            $sql = "UPDATE users SET 
                    username = '$username',
                    email = '$email',
                    full_name = '$full_name',
                    phone = '$phone',
                    role = '$role',
                    status = '$status',
                    bio = '$bio',
                    avatar = '$avatar'
                    $passwordSql
                    WHERE id = $id";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'ব্যবহারকারী আপডেট হয়েছে';
                echo "<script>window.location.href = 'index.php?q=users';</script>";
                exit();
            } else {
                $error = 'ত্রুটি: ' . $conn->error;
            }
        }
    }
}

$roles = ['super_admin', 'admin', 'editor', 'reporter', 'moderator'];
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">ব্যবহারকারী সম্পাদনা</h2>
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
    <form method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-2">ইউজারনেম *</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">পূর্ণ নাম *</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ইমেইল *</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">নতুন পাসওয়ার্ড (যদি পরিবর্তন চান)</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
                <p class="text-xs text-gray-500 mt-1">পাসওয়ার্ড পরিবর্তন না চাইলে ফাঁকা রাখুন</p>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ফোন</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">রোল *</label>
                <select name="role" required class="w-full px-3 py-2 border rounded">
                    <?php foreach ($roles as $r): ?>
                    <option value="<?php echo $r; ?>" <?php echo $user['role'] == $r ? 'selected' : ''; ?>>
                        <?php echo ucfirst($r); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস *</label>
                <select name="status" class="w-full px-3 py-2 border rounded">
                    <option value="active" <?php echo $user['status'] == 'active' ? 'selected' : ''; ?>>সক্রিয়</option>
                    <option value="inactive" <?php echo $user['status'] == 'inactive' ? 'selected' : ''; ?>>নিষ্ক্রিয়</option>
                    <option value="banned" <?php echo $user['status'] == 'banned' ? 'selected' : ''; ?>>নিষিদ্ধ</option>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">প্রোফাইল ছবি</label>
                <?php if (!empty($user['avatar'])): ?>
                <div class="mb-2">
                    <img src="<?php echo $user['avatar']; ?>" class="h-16 w-16 object-cover rounded-full" alt="">
                </div>
                <?php endif; ?>
                <input type="file" name="avatar" accept="image/*" class="w-full">
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">বায়ো</label>
                <textarea name="bio" rows="3" class="w-full px-3 py-2 border rounded"><?php echo htmlspecialchars($user['bio']); ?></textarea>
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