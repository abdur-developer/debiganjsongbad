<?php
// staff.php - আমাদের পরিবার (Staff List)
require_once 'admin/includes/config.php';
require_once 'admin/includes/db.php';
require_once 'admin/includes/functions.php';

// স্টাফ লিস্ট
$sql = "SELECT * FROM staffs WHERE status = 'active' ORDER BY sort_order ASC, id ASC";
$result = $conn->query($sql);

// ডিপার্টমেন্ট অনুযায়ী গ্রুপিং
$staffByDept = [];
while ($staff = $result->fetch_assoc()) {
    $dept = $staff['department'] ?? 'অন্যান্য';
    if (!isset($staffByDept[$dept])) {
        $staffByDept[$dept] = [];
    }
    $staffByDept[$dept][] = $staff;
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমাদের পরিবার - দেবীগঞ্জ সংবাদ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Hind Siliguri', sans-serif; }
        
        .staff-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .staff-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .staff-img {
            transition: transform 0.3s ease;
        }
        
        .staff-card:hover .staff-img {
            transform: scale(1.05);
        }
        
        .social-link {
            transition: all 0.2s ease;
        }
        
        .social-link:hover {
            transform: translateY(-2px);
        }
        
        .department-badge {
            transition: all 0.3s ease;
        }
        
        .department-badge:hover {
            background-color: #dc2626;
            color: white;
        }
        
        /* মোবাইল অ্যাডজাস্টমেন্ট */
        @media (max-width: 768px) {
            .staff-card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-block bg-red-100 rounded-full px-4 py-1 mb-4">
                <span class="text-red-600 text-sm font-semibold">আমাদের টিম</span>
            </div>
            <h1 class="text-2xl md:text-5xl font-bold text-gray-800 mb-3">আমাদের পরিবার</h1>
            <div class="w-24 h-1 bg-red-600 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-xs md:text-base">
                দেবীগঞ্জ সংবাদের পেছনে যারা নিরলসভাবে কাজ করে যাচ্ছেন, তাদের নিয়েই আমাদের এই পরিবার। 
                প্রতিটি সদস্য আমাদের শক্তি, প্রতিটি মুখ আমাদের পরিচয়।
            </p>
        </div>
        
        <!-- Stats Section -->
        <!-- <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <i class="fas fa-users text-2xl text-red-500 mb-2"></i>
                <div class="text-2xl font-bold text-gray-800"><php echo count($result->fetch_all() ?: []); ?></div>
                <div class="text-sm text-gray-500">মোট সদস্য</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <i class="fas fa-newspaper text-2xl text-blue-500 mb-2"></i>
                <div class="text-2xl font-bold text-gray-800"><php echo count($staffByDept); ?></div>
                <div class="text-sm text-gray-500">বিভাগ</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <i class="fas fa-calendar-alt text-2xl text-green-500 mb-2"></i>
                <div class="text-2xl font-bold text-gray-800">২০১৮</div>
                <div class="text-sm text-gray-500">প্রতিষ্ঠাকাল</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <i class="fas fa-chart-line text-2xl text-purple-500 mb-2"></i>
                <div class="text-2xl font-bold text-gray-800"><php echo rand(10000, 50000); ?>+</div>
                <div class="text-sm text-gray-500">দৈনিক পাঠক</div>
            </div>
        </div> -->
        
        <!-- Staff List by Department -->
        <?php foreach ($staffByDept as $dept => $staffList): ?>
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-1 bg-red-500 rounded-full"></div>
                <h2 class="text-xl font-bold text-gray-800">
                    <?php 
                    $deptNames = [
                        'Editorial' => 'সম্পাদকীয় বিভাগ',
                        'News' => 'সংবাদ বিভাগ',
                        'Crime' => 'ক্রাইম বিভাগ',
                        'Sports' => 'খেলাধুলা বিভাগ',
                        'Photography' => 'ফটোগ্রাফি বিভাগ',
                        'Digital' => 'ডিজিটাল বিভাগ',
                        'Video' => 'ভিডিও বিভাগ',
                        'Marketing' => 'মার্কেটিং বিভাগ',
                        'অন্যান্য' => 'অন্যান্য বিভাগ'
                    ];
                    echo $deptNames[$dept] ?? $dept;
                    ?>
                </h2>
                <span class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full"><?php echo count($staffList); ?> জন</span>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($staffList as $staff): ?>
                <div class="staff-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                    <!-- Image Section -->
                    <div class="relative h-24 md:h-44 lg:h-52 overflow-hidden bg-gradient-to-br from-red-500 to-red-700">
                        <?php if (!empty($staff['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $staff['image'])): ?>
                        <img src="<?php echo $staff['image']; ?>" alt="<?php echo $staff['name_bn']; ?>" class="staff-img w-full h-full object-cover">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-user-circle text-4xl text-white opacity-50"></i>
                                <p class="text-white text-sm mt-2">ছবি নেই</p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Social Links Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <div class="flex justify-center gap-3">
                                <?php if (!empty($staff['facebook'])): ?>
                                <a href="<?php echo $staff['facebook']; ?>" target="_blank" class="social-link w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                    <i class="fab fa-facebook-f text-white text-sm"></i>
                                </a>
                                <?php endif; ?>
                                <?php if (!empty($staff['twitter'])): ?>
                                <a href="<?php echo $staff['twitter']; ?>" target="_blank" class="social-link w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-sky-500 transition">
                                    <i class="fab fa-twitter text-white text-sm"></i>
                                </a>
                                <?php endif; ?>
                                <?php if (!empty($staff['linkedin'])): ?>
                                <a href="<?php echo $staff['linkedin']; ?>" target="_blank" class="social-link w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                    <i class="fab fa-linkedin-in text-white text-sm"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Section -->
                    <div class="p-2 text-center">
                        <h5 class="text-base font-bold text-gray-800 mb-1"><?php echo $staff['name_bn']; ?></h5>
                        <?php if (!empty($staff['name_en'])): ?>
                        <p class="text-xs text-gray-500 mb-2"><?php echo $staff['name_en']; ?></p>
                        <?php endif; ?>
                        <div class="inline-block bg-red-50 text-red-600 text-xs font-semibold px-3 pt-1 rounded-full">
                            <?php echo $staff['designation_bn']; ?>
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600 mt-3">
                            <?php if (!empty($staff['email'])): ?>
                            <div class="flex items-center justify-center gap-2">
                                <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                <a href="mailto:<?php echo $staff['email']; ?>" class="hover:text-red-500 transition break-all w-48" style="font-size: 0.75rem;"><?= $staff['email']; ?></a>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($staff['phone'])): ?>
                            <div class="flex items-center justify-center gap-2">
                                <i class="fas fa-phone-alt text-gray-400 text-xs"></i>
                                <span class="text-xs"><?php echo $staff['phone']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($staff['joining_date'])): ?>
                            <div class="flex items-center justify-center gap-2">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                <span class="text-xs">যোগদান: <?php echo date('d M Y', strtotime($staff['joining_date'])); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($staff['bio'])): ?>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 line-clamp-2"><?php echo $staff['bio']; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Join Our Team Section -->
        <!-- <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 md:p-12 mt-12 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">আমাদের টিমে যোগ দিন</h2>
            <p class="text-white/90 text-sm md:text-base max-w-2xl mx-auto mb-6">
                আপনি কি সংবাদপত্রের সাথে কাজ করতে আগ্রহী? আমাদের টিমের অংশ হতে চাইলে আপনার সিভি পাঠান।
            </p>
            <a href="contact.php" class="inline-flex items-center gap-2 bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                <i class="fas fa-paper-plane"></i>
                <span>আবেদন করুন</span>
            </a>
        </div> -->
        
        <!-- Footer Note -->
        <div class="text-center mt-8 text-sm text-gray-500">
            <p>দেবীগঞ্জ সংবাদ পরিবারের সকল সদস্যকে ধন্যবাদ জানাই তাদের নিরলস প্রচেষ্টার জন্য।</p>
            <p class="mt-1">© ২০২৬ দেবীগঞ্জ সংবাদ। সর্বস্বত্ব সংরক্ষিত।</p>
        </div>
    </div>
</body>
</html>