<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

if ($auth->isLoggedIn()) {
    header('Location: ./');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($auth->login($username, $password)) {
        header('Location: ./');
        exit();
    } else {
        $error = 'ভুল ব্যবহারকারী নাম বা পাসওয়ার্ড';
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লগইন - দেবীগঞ্জ সংবাদ অ্যাডমিন</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Hind Siliguri', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-red-600">দেবীগঞ্জ সংবাদ</h2>
                    <p class="text-gray-600 mt-2">অ্যাডমিন প্যানেলে লগইন করুন</p>
                </div>
                
                <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            <i class="fas fa-user"></i> ব্যবহারকারী নাম / ইমেইল
                        </label>
                        <input type="text" name="username" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-red-500">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            <i class="fas fa-lock"></i> পাসওয়ার্ড
                        </label>
                        <input type="password" name="password" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-red-500">
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
                        লগইন করুন
                    </button>
                </form>
                
                <div class="mt-6 text-center text-sm text-gray-600">
                    <?php
                    //"<p>ডিফল্ট লগইন: <strong>superadmin / Admin@123</strong></p>"
                    ?>
                </div>
            </div>
            
            <div class="border-t px-8 py-4 bg-gray-50 text-center text-xs text-gray-500">
                &copy; <?php echo date('Y'); ?> দেবীগঞ্জ সংবাদ। সর্বসত্ত্ব সংরক্ষিত।
            </div>
        </div>
    </div>
</body>
</html>