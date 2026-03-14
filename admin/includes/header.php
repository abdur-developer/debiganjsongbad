<?php
require_once 'auth.php';
$auth->requireLogin();

$currentUser = $auth->getUser();

// নোটিফিকেশন মেসেজ সেশন থেকে নেওয়া
$success_message = $_SESSION['success'] ?? '';
$error_message = $_SESSION['error'] ?? '';
$warning_message = $_SESSION['warning'] ?? '';

// সেশন ক্লিয়ার করবেন না - footer-এ দেখানোর পর ক্লিয়ার হবে
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন প্যানেল - দেবীগঞ্জ সংবাদ</title>
    <link rel="icon" type="image/png" sizes="32x32" href="https://debiganjsongbad.com/uploads/settings/1773409974_favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://debiganjsongbad.com/uploads/settings/1773409974_favicon.png">
    
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
    
    <!-- Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    
    <!-- Bootstrap Timepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Hind Siliguri', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar - রেস্পন্সিভ ডিজাইন -->
        <div class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out z-30 w-64 bg-gray-900 text-white flex flex-col h-full" id="sidebar">
            <!-- মোবাইল হেডার - শুধু মোবাইলে দেখাবে -->
            <div class="md:hidden p-4 border-b border-gray-800 flex justify-between items-center">
                <h2 class="text-xl font-bold text-red-500">দেবীগঞ্জ সংবাদ</h2>
                <button id="close-sidebar" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- ডেস্কটপ হেডার - শুধু ডেস্কটপে দেখাবে -->
            <div class="hidden md:block p-4 border-b border-gray-800">
                <h2 class="text-xl font-bold text-red-500">দেবীগঞ্জ সংবাদ</h2>
                <p class="text-xs text-gray-400 mt-1">অ্যাডমিন প্যানেল</p>
            </div>
            
            <!-- ইউজার ইনফো - সব ডিভাইসে দেখাবে -->
            <div class="p-4 border-b border-gray-800">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0">
                        <?php if ($currentUser['avatar']): ?>
                        <img src="<?php echo $currentUser['avatar']; ?>" class="w-full h-full object-cover" alt="">
                        <?php else: ?>
                        <i class="fas fa-user text-gray-300 text-xl"></i>
                        <?php endif; ?>
                    </div>
                    <div class="ml-3 min-w-0 flex-1">
                        <p class="font-semibold text-sm truncate"><?php echo htmlspecialchars($currentUser['full_name']); ?></p>
                        <p class="text-xs text-gray-400 truncate">
                            <?php 
                                $roleNames = [
                                    'super_admin' => 'সুপার অ্যাডমিন',
                                    'admin' => 'অ্যাডমিন',
                                    'editor' => 'এডিটর',
                                    'reporter' => 'রিপোর্টার',
                                    'moderator' => 'মডারেটর'
                                ];
                                echo $roleNames[$currentUser['role']] ?? $currentUser['role'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <style>
                .active-nav {
                    --tw-bg-opacity: 1;
                    --tw-text-opacity: 1;
                    background-color: rgb(31 41 55 / var(--tw-bg-opacity, 1));
                    color: rgb(239 68 68 / var(--tw-text-opacity, 1));
                }
                
                /* সক্রিয় নেভিগেশন আইকনের জন্যও */
                .active-nav i {
                    color: rgb(239 68 68 / var(--tw-text-opacity, 1));
                }
                
                /* মোবাইলে সাইডবার ওপেন */
                .sidebar-open {
                    overflow: hidden;
                }
                
                .sidebar-open #sidebar {
                    transform: translateX(0);
                }
                
                .sidebar-open #sidebar-overlay {
                    display: block;
                }
            </style>
            
            <!-- নেভিগেশন মেনু - স্ক্রলযোগ্য -->
            <nav class="flex-1 overflow-y-auto p-4" style="scrollbar-width: thin; scrollbar-color: #4a5568 #2d3748;">
                <?php $active = $_GET['q'] ?? 'dashboard'; ?>
                <ul class="space-y-1">
                    <li>
                        <a href="./" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'dashboard' ? 'active-nav' : '' ?> transition-colors">
                            <i class="fas fa-tachometer-alt w-6 text-base <?= $active === 'dashboard' ? 'text-red-500' : 'text-gray-400' ?>"></i>
                            <span class="ml-2 text-sm truncate">ড্যাশবোর্ড</span>
                        </a>
                    </li>
                    
                    <li class="pt-4 mt-2 border-t border-gray-800">
                        <p class="text-xs text-gray-500 mb-2 px-2 uppercase tracking-wider">কন্টেন্ট</p>
                    </li>
                    
                    <li>
                        <a href="../index.php" target="_blank" class="flex items-center p-2 hover:bg-gray-800 rounded transition-colors">
                            <i class="fas fa-globe w-6 text-base text-gray-400"></i>
                            <span class="ml-2 text-sm truncate">ওয়েবসাইট দেখুন</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?q=news" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'news' ? 'active-nav' : '' ?> transition-colors">
                            <i class="fas fa-newspaper w-6 text-base <?= $active === 'news' ? 'text-red-500' : 'text-gray-400' ?>"></i>
                            <span class="ml-2 text-sm truncate">সংবাদ</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?q=categories" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'categories' ? 'active-nav' : '' ?> transition-colors">
                            <i class="fas fa-tags w-6 text-base <?= $active === 'categories' ? 'text-red-500' : 'text-gray-400' ?>"></i>
                            <span class="ml-2 text-sm truncate">ক্যাটাগরি</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?q=gallery" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'gallery' ? 'active-nav' : '' ?> transition-colors">
                            <i class="fas fa-images w-6 text-base <?= $active === 'gallery' ? 'text-red-500' : 'text-gray-400' ?>"></i>
                            <span class="ml-2 text-sm truncate">গ্যালারি</span>
                        </a>
                    </li>
                    
                    <!-- মন্তব্য - কমেন্ট আউট করা আছে -->
                    <!--
                    <li>
                        <a href="?q=comments" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'comments' ? 'active-nav' : '' ?>">
                            <i class="fas fa-comments w-6"></i>
                            <span>মন্তব্য</span>
                        </a>
                    </li>
                    -->
                    
                    <li class="pt-4 mt-2 border-t border-gray-800">
                        <p class="text-xs text-gray-500 mb-2 px-2 uppercase tracking-wider">ব্যবস্থাপনা</p>
                    </li>
                    
                    <?php if ($auth->hasPermission('users')): ?>
                    <!-- ব্যবহারকারী - কমেন্ট আউট করা আছে -->
                    <!--
                    <li>
                        <a href="?q=users" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'users' ? 'active-nav' : '' ?>">
                            <i class="fas fa-users w-6"></i>
                            <span>ব্যবহারকারী</span>
                        </a>
                    </li>
                    -->
                    <?php endif; ?>
                    
                    <!-- রোল - কমেন্ট আউট করা আছে -->
                    <!--
                    <li>
                        <a href="?q=roles" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'roles' ? 'active-nav' : '' ?>">
                            <i class="fas fa-user-tag w-6"></i>
                            <span>রোল ও পারমিশন</span>
                        </a>
                    </li>
                    -->
                    
                    <?php if ($auth->hasPermission('ads')): ?>
                    <!-- বিজ্ঞাপন - কমেন্ট আউট করা আছে -->
                    <!--
                    <li>
                        <a href="?q=ads" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'ads' ? 'active-nav' : '' ?>">
                            <i class="fas fa-ad w-6"></i>
                            <span>বিজ্ঞাপন</span>
                        </a>
                    </li>
                    -->
                    <?php endif; ?>
                    
                    <?php if ($auth->hasPermission('settings')): ?>
                    <!-- সেটিংস - কমেন্ট আউট করা আছে -->
                    <!--
                    <li>
                        <a href="?q=settings" class="flex items-center p-2 hover:bg-gray-800 rounded <?= $active === 'settings' ? 'active-nav' : '' ?>">
                            <i class="fas fa-cog w-6"></i>
                            <span>সেটিংস</span>
                        </a>
                    </li>
                    -->
                    <?php endif; ?>
                    
                    <!-- টুলস সেকশন - কমেন্ট আউট -->
                    <!--
                    <li class="pt-4 mt-2 border-t border-gray-800">
                        <p class="text-xs text-gray-500 mb-2 px-2">টুলস</p>
                    </li>
                    
                    <li>
                        <a href="?q=backup" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-database w-6"></i>
                            <span>ব্যাকআপ</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="?q=logs" class="flex items-center p-2 hover:bg-gray-800 rounded">
                            <i class="fas fa-history w-6"></i>
                            <span>অ্যাক্টিভিটি লগ</span>
                        </a>
                    </li>
                    -->
                </ul>
            </nav>
            
            <!-- নিচের মেনু -->
            <div class="p-4 border-t border-gray-800">
                <a href="?q=profile" class="flex items-center p-2 hover:bg-gray-800 rounded mb-1 transition-colors <?= $active === 'profile' ? 'active-nav' : '' ?>">
                    <i class="fas fa-user-circle w-6 text-base <?= $active === 'profile' ? 'text-red-500' : 'text-gray-400' ?>"></i>
                    <span class="ml-2 text-sm truncate">প্রোফাইল</span>
                </a>
                <a href="logout.php" class="flex items-center p-2 hover:bg-gray-800 rounded text-red-400 hover:text-red-300 transition-colors">
                    <i class="fas fa-sign-out-alt w-6 text-base"></i>
                    <span class="ml-2 text-sm truncate">লগআউট</span>
                </a>
            </div>
        </div>

        <!-- মোবাইল সাইডবার ওভারলে -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden transition-opacity"></div>

        <!-- মোবাইল টপবার - শুধু মোবাইলে দেখাবে -->
        <!-- <div class="md:hidden bg-white shadow-sm px-4 py-2 flex items-center justify-between sticky top-0 z-10">
            <button id="menu-toggle" class="p-2 text-gray-600 hover:text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h2 class="text-lg font-semibold text-red-600">দেবীগঞ্জ সংবাদ</h2>
            <a href="../index.php" target="_blank" class="p-2 text-gray-600 hover:text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </a>
        </div> -->

        <!-- Main Content - রেস্পন্সিভ টেক্সট সাইজ -->
        <div class="flex-1 flex flex-col overflow-hidden <?= $active === 'dashboard' ? '' : '' ?>">
            <!-- টপ বার - ডেস্কটপে দেখাবে, মোবাইলে হাইড (মোবাইল টপবার আলাদা আছে) -->
            <div class="hidden md:flex bg-white shadow-sm px-6 py-3 justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">
                    <?php
                    $titles = [
                        'profile' => 'আমার প্রোফাইল',
                        'dashboard' => 'ড্যাশবোর্ড',
                        'news' => 'সংবাদ ব্যবস্থাপনা',
                        'categories' => 'ক্যাটাগরি ব্যবস্থাপনা',
                        'gallery' => 'ছবি গ্যালারি',
                        'users' => 'ব্যবহারকারী ব্যবস্থাপনা',
                        'roles' => 'রোল ব্যবস্থাপনা',
                        'comments' => 'মন্তব্য ব্যবস্থাপনা',
                        'ads' => 'বিজ্ঞাপন ব্যবস্থাপনা',
                        'settings' => 'সেটিংস'
                    ];
                    echo $titles[$active] ?? 'অ্যাডমিন প্যানেল';
                    ?>
                </h1>
                
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <i class="far fa-calendar-alt mr-1"></i>
                        <?php 
                        $months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
                        $days = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
                        $date = getdate();
                        echo $days[$date['wday']] . ', ' . $date['mday'] . ' ' . $months[$date['mon']-1] . ' ' . $date['year'];
                        ?>
                    </div>
                    <a href="../index.php" target="_blank" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                        <i class="fas fa-external-link-alt mr-1"></i> সাইট দেখুন
                    </a>
                </div>
            </div>
            
            <!-- মোবাইল পেজ টাইটেল - শুধু মোবাইলে দেখাবে -->
            <div class="flex md:hidden bg-white px-4 py-2 border-b border-gray-800 items-center justify-between">
                <button id="menu-toggle" class="p-2 text-gray-600 hover:text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-base font-semibold text-gray-800">
                    <?php echo $titles[$active] ?? 'অ্যাডমিন প্যানেল'; ?>
                </h1>
                <a href="../index.php" target="_blank" class="p-2 text-gray-600 hover:text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
            
            <!-- কন্টেন্ট এরিয়া - রেস্পন্সিভ প্যাডিং -->
            <div class="flex-1 overflow-y-auto p-4 md:p-6">
                <!-- হিডেন সেশন ডাটা -->
                <div id="session-data" 
                    data-success="<?php echo htmlspecialchars($success_message); ?>"
                    data-error="<?php echo htmlspecialchars($error_message); ?>"
                    data-warning="<?php echo htmlspecialchars($warning_message); ?>"
                    class="hidden">
                </div>