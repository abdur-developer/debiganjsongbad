<?php
$auth->requirePermission('users');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role = $conn->real_escape_string($_POST['role']);
    $status = $conn->real_escape_string($_POST['status']);
    $bio = $conn->real_escape_string($_POST['bio']);
    
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'সব প্রয়োজনীয় তথ্য দিন';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'সঠিক ইমেইল দিন';
    } else {
        // চেক ডুপ্লিকেট
        $checkSql = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
        $checkResult = $conn->query($checkSql);
        
        if ($checkResult->num_rows > 0) {
            $error = 'এই ইউজারনেম বা ইমেইল ইতিমধ্যে exists';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            // ছবি আপলোড
            $avatar = '';
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $upload = $functions->uploadFile($_FILES['avatar'], 'avatars', ['jpg', 'jpeg', 'png']);
                if ($upload['success']) {
                    $avatar = $upload['path'];
                }
            }
            
            $sql = "INSERT INTO users (username, email, password, full_name, phone, role, status, bio, avatar, created_at) 
                    VALUES ('$username', '$email', '$hashed', '$full_name', '$phone', '$role', '$status', '$bio', '$avatar', NOW())";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'ব্যবহারকারী তৈরি হয়েছে';
                header('Location: index.php');
                exit();
            } else {
                $error = 'ত্রুটি: ' . $conn->error;
            }
        }
    }
}

// রোল লিস্ট
$roles = ['super_admin', 'admin', 'editor', 'reporter', 'moderator'];
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">নতুন ব্যবহারকারী তৈরি করুন</h2>
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
                <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">পূর্ণ নাম *</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ইমেইল *</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">পাসওয়ার্ড *</label>
                <input type="password" name="password" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ফোন</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">রোল *</label>
                <select name="role" required class="w-full px-3 py-2 border rounded">
                    <?php foreach ($roles as $r): ?>
                    <option value="<?php echo $r; ?>" <?php echo ($_POST['role'] ?? '') == $r ? 'selected' : ''; ?>>
                        <?php echo ucfirst($r); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস *</label>
                <select name="status" class="w-full px-3 py-2 border rounded">
                    <option value="active">সক্রিয়</option>
                    <option value="inactive">নিষ্ক্রিয়</option>
                    <option value="banned">নিষিদ্ধ</option>
                </select>
            </div>
            
            <div>
                <label class="block font-semibold mb-2">প্রোফাইল ছবি</label>
                <input type="file" name="avatar" accept="image/*" class="w-full">
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">বায়ো</label>
                <textarea name="bio" rows="3" class="w-full px-3 py-2 border rounded"><?php echo htmlspecialchars($_POST['bio'] ?? ''); ?></textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end gap-2">
            <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                বাতিল
            </a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                তৈরি করুন
            </button>
        </div>
    </form>
</div>