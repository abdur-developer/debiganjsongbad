<?php
$userId = $_SESSION['user_id'];
$user = $auth->getUser($userId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $bio = $conn->real_escape_string($_POST['bio']);
    
    // আপডেট
    $sql = "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$phone', bio = '$bio' WHERE id = $userId";
    
    // পাসওয়ার্ড আপডেট
    if (!empty($_POST['new_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // পুরাতন পাসওয়ার্ড চেক
        if (password_verify($old_password, $user['password'])) {
            if ($new_password == $confirm_password) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$phone', bio = '$bio', password = '$hashed' WHERE id = $userId";
            } else {
                $error = 'নতুন পাসওয়ার্ড মিলছে না';
            }
        } else {
            $error = 'পুরাতন পাসওয়ার্ড সঠিক নয়';
        }
    }
    
    // ছবি আপলোড
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $upload = $functions->uploadFile($_FILES['avatar'], 'avatars', ['jpg', 'jpeg', 'png']);
        if ($upload['success']) {
            $avatar = $upload['path'];
            $sql = "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$phone', bio = '$bio', avatar = '$avatar' WHERE id = $userId";
        }
    }
    
    if (!isset($error) && $conn->query($sql)) {
        $_SESSION['full_name'] = $full_name;
        $success = 'প্রোফাইল আপডেট হয়েছে';
        $user = $auth->getUser($userId); // রিলোড
    } elseif (!isset($error)) {
        $error = 'আপডেট ব্যর্থ: ' . $conn->error;
    }
}
?>

<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">আমার প্রোফাইল</h2>
    
    <?php if (isset($success)): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?php echo $success; ?>
    </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- বাম কলাম - প্রোফাইল ছবি -->
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="w-32 h-32 mx-auto bg-gray-300 rounded-full overflow-hidden">
                                <?php if ($user['avatar']): ?>
                                <img src="<?php echo $user['avatar']; ?>" class="w-full h-full object-cover" alt="">
                                <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-4xl text-gray-600">
                                    <?php echo mb_substr($user['full_name'], 0, 1); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-2">প্রোফাইল ছবি পরিবর্তন</label>
                            <input type="file" name="avatar" accept="image/*" class="w-full text-sm">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG (সর্বোচ্চ ২MB)</p>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            <p>সদস্যতা: <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
                            <p>লাস্ট লগিন: <?php echo $user['last_login'] ? date('d M Y h:i A', strtotime($user['last_login'])) : 'নেই'; ?></p>
                        </div>
                    </div>
                    
                    <!-- ডান কলাম - তথ্য -->
                    <div class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-2">পূর্ণ নাম *</label>
                            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required 
                                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-2">ইউজারনেম</label>
                            <input type="text" value="<?php echo $user['username']; ?>" disabled 
                                   class="w-full px-3 py-2 border rounded bg-gray-100">
                            <p class="text-xs text-gray-500 mt-1">ইউজারনেম পরিবর্তন করা যাবে না</p>
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-2">ইমেইল *</label>
                            <input type="email" name="email" value="<?php echo $user['email']; ?>" required 
                                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-2">ফোন</label>
                            <input type="text" name="phone" value="<?php echo $user['phone']; ?>" 
                                   class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-2">রোল</label>
                            <input type="text" value="<?php 
                                $roles = ['super_admin' => 'সুপার অ্যাডমিন', 'admin' => 'অ্যাডমিন', 'editor' => 'এডিটর', 'reporter' => 'রিপোর্টার'];
                                echo $roles[$user['role']] ?? $user['role']; 
                            ?>" disabled 
                                   class="w-full px-3 py-2 border rounded bg-gray-100">
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-2">বায়ো</label>
                            <textarea name="bio" rows="3" class="w-full px-3 py-2 border rounded"><?= $user['bio'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- পাসওয়ার্ড পরিবর্তন সেকশন -->
                <div class="mt-8 pt-6 border-t">
                    <h3 class="text-lg font-semibold mb-4">পাসওয়ার্ড পরিবর্তন</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold mb-2">পুরাতন পাসওয়ার্ড</label>
                            <input type="password" name="old_password" class="w-full px-3 py-2 border rounded">
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-2">নতুন পাসওয়ার্ড</label>
                            <input type="password" name="new_password" class="w-full px-3 py-2 border rounded">
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-2">নতুন পাসওয়ার্ড (আবার)</label>
                            <input type="password" name="confirm_password" class="w-full px-3 py-2 border rounded">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">পাসওয়ার্ড পরিবর্তন না চাইলে ফাঁকা রাখুন</p>
                </div>
                
                <div class="mt-6 flex justify-end gap-2">
                    <button type="reset" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        বাতিল
                    </button>
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                        আপডেট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>