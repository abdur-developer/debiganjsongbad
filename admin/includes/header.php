<?php
// admin/includes/header.php
require_once 'auth.php';
$auth->requireLogin();

$currentUser = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন প্যানেল - দেবীগঞ্জ সংবাদ</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white">
            <div class="p-4 border-b border-gray-800">
                <h2 class="text-xl font-bold text-red-500">দেবীগঞ্জ সংবাদ</h2>
                <p class="text-xs text-gray-400 mt-1">অ্যাডমিন প্যানেল</p>
            </div>
            
            <div class="p-4 border-b border-gray-800">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-300"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold"><?php echo $currentUser['full_name']; ?></p>
                        <p class="text-xs text-gray-400"><?php echo ucfirst($currentUser['role']); ?></p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="dashboard.php" class="flex items-center p-2 hover:bg-gray-800 rounded <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-gray-800' : ''; ?>">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span>ড্যাশবোর্ড</span>
                        </a>
                    </li>
                    
                    <li class="pt-2 border-t border-gray-800">
                        <p class="text-xs text-gray-500 mb-2">কন্টেন্ট</p>
                    </li>
                    
                    <li>
                        <a href="news/index.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-newspaper w-6"></i>
                            <span>সংবাদ</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="categories/index.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-tags w-6"></i>
                            <span>ক্যাটাগরি</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="gallery/index.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-images w-6"></i>
                            <span>গ্যালারি</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="comments/index.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-comments w-6"></i>
                            <span>মন্তব্য</span>
                        </a>
                    </li>
                    
                    <li class="pt-2 border-t border-gray-800">
                        <p class="text-xs text-gray-500 mb-2">ব্যবস্থাপনা</p>
                    </li>
                    
                    <?php if ($auth->hasPermission('users')): ?>
                    <li>
                        <a href="users/index.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-users w-6"></i>
                            <span>ব্যবহারকারী</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($auth->hasPermission('ads')): ?>
                    <li>
                        <a href="ads/index.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-ad w-6"></i>
                            <span>বিজ্ঞাপন</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($auth->hasPermission('settings')): ?>
                    <li>
                        <a href="settings/index.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-cog w-6"></i>
                            <span>সেটিংস</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <li class="pt-2 border-t border-gray-800">
                        <a href="profile.php" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-user-circle w-6"></i>
                            <span>প্রোফাইল</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="logout.php" class="flex items-center p-2 hover:bg-gray-800 rounded text-red-400">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span>লগআউট</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">
                    <?php
                    $pageTitle = basename($_SERVER['PHP_SELF']);
                    switch($pageTitle) {
                        case 'dashboard.php': echo 'ড্যাশবোর্ড'; break;
                        case 'profile.php': echo 'প্রোফাইল'; break;
                        default: echo 'অ্যাডমিন প্যানেল';
                    }
                    ?>
                </h1>
                
                <div class="flex items-center gap-4">
                    <a href="<?php echo SITE_URL; ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-external-link-alt"></i> সাইট দেখুন
                    </a>
                    <span class="text-sm text-gray-600"><?php echo date('l, d F Y'); ?></span>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="p-6">