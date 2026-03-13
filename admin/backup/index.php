<?php
$auth->requirePermission('settings');

$backupDir = $_SERVER['DOCUMENT_ROOT'] . '/backups/';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$backups = glob($backupDir . '*.sql');
usort($backups, function($a, $b) {
    return filemtime($b) - filemtime($a);
});
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">ডাটাবেজ ব্যাকআপ</h2>
    <button id="create-backup" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-database"></i> নতুন ব্যাকআপ তৈরি
    </button>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="font-semibold mb-3">ব্যাকআপ সম্পর্কে</h3>
    <p class="text-sm text-gray-600 mb-2">নিয়মিত ব্যাকআপ রাখা জরুরি। নিচের অপশনগুলো ব্যবহার করুন:</p>
    <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
        <li>ম্যানুয়ালি ব্যাকআপ নিতে "নতুন ব্যাকআপ তৈরি" বাটনে ক্লিক করুন</li>
        <li>পুরাতন ব্যাকআপ ৭ দিন পর স্বয়ংক্রিয়ভাবে মুছে যাবে</li>
        <li>ব্যাকআপ রিস্টোর করলে বর্তমান ডাটা ওভাররাইট হবে</li>
    </ul>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">ফাইলের নাম</th>
                <th class="px-4 py-3 text-left">আকার</th>
                <th class="px-4 py-3 text-left">তারিখ</th>
                <th class="px-4 py-3 text-left">সময়</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($backups)): ?>
                <?php foreach ($backups as $backup): 
                    $filename = basename($backup);
                    $size = filesize($backup);
                    $time = filemtime($backup);
                    
                    // সাইজ ফরম্যাট
                    if ($size < 1024) {
                        $sizeText = $size . ' B';
                    } elseif ($size < 1048576) {
                        $sizeText = round($size / 1024, 2) . ' KB';
                    } else {
                        $sizeText = round($size / 1048576, 2) . ' MB';
                    }
                ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2 font-mono text-sm"><?php echo $filename; ?></td>
                    <td class="px-4 py-2"><?php echo $sizeText; ?></td>
                    <td class="px-4 py-2"><?php echo date('d/m/Y', $time); ?></td>
                    <td class="px-4 py-2"><?php echo date('h:i A', $time); ?></td>
                    <td class="px-4 py-2">
                        <a href="<?php echo '/backups/' . $filename; ?>" download 
                           class="text-blue-600 hover:text-blue-800 mr-3" title="ডাউনলোড">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="text-green-600 hover:text-green-800 mr-3 restore-backup" 
                                data-file="<?php echo $filename; ?>" title="রিস্টোর">
                            <i class="fas fa-undo"></i>
                        </button>
                        <a href="?q=backup&delete_file=<?php echo urlencode($filename); ?>" 
                           class="text-red-600 hover:text-red-800 delete-confirm"
                           data-message="এই ব্যাকআপ ফাইল মুছে ফেলবেন?" title="ডিলিট">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                        <i class="fas fa-database text-4xl mb-3 text-gray-300"></i>
                        <p>কোনো ব্যাকআপ ফাইল নেই</p>
                        <p class="text-sm mt-2">প্রথম ব্যাকআপ তৈরি করুন</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- রিস্টোর কনফার্মেশন মোডাল -->
<div id="restore-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">ব্যাকআপ রিস্টোর</h3>
                <p class="text-gray-600 mb-4">
                    ব্যাকআপ রিস্টোর করলে বর্তমান ডাটা ওভাররাইট হবে। আপনি কি নিশ্চিত?
                </p>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-4">
                    <p class="text-sm text-yellow-700">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        রিস্টোর করার আগে বর্তমান ডাটার ব্যাকআপ নিয়ে নিন।
                    </p>
                </div>
                <div class="flex justify-end gap-2">
                    <button id="cancel-restore" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        বাতিল
                    </button>
                    <button id="confirm-restore" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        রিস্টোর করুন
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#create-backup').click(function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ব্যাকআপ হচ্ছে...');
        
        $.ajax({
            url: '../ajax/create-backup.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification(response.message, 'error');
                    btn.prop('disabled', false).html('<i class="fas fa-database"></i> নতুন ব্যাকআপ তৈরি');
                }
            },
            error: function() {
                showNotification('ব্যাকআপ ব্যর্থ হয়েছে', 'error');
                btn.prop('disabled', false).html('<i class="fas fa-database"></i> নতুন ব্যাকআপ তৈরি');
            }
        });
    });
    
    let restoreFile = '';
    
    $('.restore-backup').click(function() {
        restoreFile = $(this).data('file');
        $('#restore-modal').removeClass('hidden');
    });
    
    $('#cancel-restore').click(function() {
        $('#restore-modal').addClass('hidden');
    });
    
    $('#confirm-restore').click(function() {
        $('#restore-modal').addClass('hidden');
        
        $.ajax({
            url: '../ajax/restore-backup.php',
            method: 'POST',
            data: { file: restoreFile },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                } else {
                    showNotification(response.message, 'error');
                }
            }
        });
    });
});
</script>