<?php
$auth->requirePermission('gallery');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$where = $search ? "WHERE title_bn LIKE '%$search%' OR title_en LIKE '%$search%'" : '';

$sql = "SELECT g.*, u.full_name as uploader_name 
        FROM gallery g 
        LEFT JOIN users u ON g.uploaded_by = u.id 
        $where 
        ORDER BY g.created_at DESC 
        LIMIT $offset, $limit";
$result = $conn->query($sql);

$totalSql = "SELECT COUNT(*) as total FROM gallery $where";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">ছবি গ্যালারি</h2>
    <a href="?q=gallery&upload" class="bg-green-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-upload"></i> নতুন ছবি আপলোড
    </a>
</div>

<!-- সার্চ -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" placeholder="ছবির নাম সার্চ করুন..." 
               value="<?php echo e($search); ?>"
               class="flex-1 px-3 py-2 border rounded focus:outline-none focus:border-red-500">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-search"></i> সার্চ
        </button>
        <?php if ($search): ?>
        <a href="?q=gallery" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
            <i class="fas fa-times"></i> রিসেট
        </a>
        <?php endif; ?>
    </form>
</div>

<!-- ব্যাচ অ্যাকশন টুলবার -->
<div id="batch-actions" class="bg-gray-100 p-3 rounded-lg mb-4 hidden flex items-center gap-3">
    <span class="text-sm"><span id="selected-count">0</span> টি সিলেক্টেড</span>
    <select id="batch-action" class="border rounded px-3 py-1 text-sm">
        <option value="">অ্যাকশন নির্বাচন</option>
        <option value="activate_gallery">সক্রিয় করুন</option>
        <option value="deactivate_gallery">নিষ্ক্রিয় করুন</option>
        <option value="delete_gallery">মুছে ফেলুন</option>
    </select>
    <button id="apply-batch" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">
        প্রয়োগ করুন
    </button>
</div>

<!-- গ্যালারি গ্রিড -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($image = $result->fetch_assoc()): ?>
        <div class="bg-white rounded-lg shadow overflow-hidden group relative">
            <div class="absolute top-2 left-2 z-10">
                <input type="checkbox" class="select-item rounded" value="<?php echo $image['id']; ?>">
            </div>
            
            <div class="relative">
                <img src="<?php echo $image['image']; ?>" class="w-full h-40 object-cover" alt="<?php echo $image['title_bn']; ?>">
                
                <?php if ($image['status'] == 'inactive'): ?>
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <span class="bg-red-600 text-white px-2 py-1 text-xs rounded">নিষ্ক্রিয়</span>
                </div>
                <?php endif; ?>
                
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                    <button class="bg-blue-600 text-white p-1 rounded hover:bg-blue-700 preview-image" 
                            data-src="<?php echo $image['image']; ?>"
                            data-title="<?php echo $image['title_bn']; ?>">
                        <i class="fas fa-eye text-xs"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-2">
                <p class="font-semibold text-sm truncate" title="<?php echo $image['title_bn']; ?>">
                    <?php echo $image['title_bn']; ?>
                </p>
                <p class="text-xs text-gray-500"><?php echo $image['uploader_name']; ?></p>
                <p class="text-xs text-gray-400"><?php echo date('d/m/Y', strtotime($image['created_at'])); ?></p>
                
                <div class="flex justify-end gap-2 mt-2">
                    <a href="?q=gallery&edit_id=<?php echo $image['id']; ?>" class="text-blue-600 hover:text-blue-800 text-sm" title="এডিট">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="?q=gallery&delete_id=<?php echo $image['id']; ?>" 
                       class="text-red-600 hover:text-red-800 text-sm delete-confirm"
                       data-message="এই ছবি মুছে ফেলবেন?">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-span-full text-center py-12 text-gray-500">
            <i class="fas fa-images text-5xl mb-3 text-gray-300"></i>
            <p>কোনো ছবি পাওয়া যায়নি</p>
            <a href="?q=gallery&upload" class="inline-block mt-3 text-blue-600 hover:underline">প্রথম ছবি আপলোড করুন</a>
        </div>
    <?php endif; ?>
</div>

<!-- পেজিনেশন -->
<?php if ($totalPages > 1): ?>
<div class="flex justify-center mt-6">
    <div class="flex gap-2">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
           class="px-3 py-1 <?php echo $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
    </div>
</div>
<?php endif; ?>

<!-- প্রিভিউ মোডাল -->
<div id="preview-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-75"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-3xl w-full max-h-screen overflow-auto">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="font-bold" id="preview-title"></h3>
                <button class="text-gray-500 hover:text-gray-700" onclick="closePreview()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-4">
                <img id="preview-image" src="" class="w-full h-auto" alt="">
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // সিলেক্ট অল
    $('#select-all').click(function() {
        $('.select-item').prop('checked', $(this).prop('checked'));
        updateSelectedCount();
    });
    
    $('.select-item').click(function() {
        updateSelectAll();
        updateSelectedCount();
    });
    
    function updateSelectAll() {
        const allChecked = $('.select-item:checked').length === $('.select-item').length;
        $('#select-all').prop('checked', allChecked);
    }
    
    function updateSelectedCount() {
        const count = $('.select-item:checked').length;
        $('#selected-count').text(count);
        
        if (count > 0) {
            $('#batch-actions').removeClass('hidden');
        } else {
            $('#batch-actions').addClass('hidden');
        }
    }
    
    // ব্যাচ অ্যাকশন
    $('#apply-batch').click(function() {
        const action = $('#batch-action').val();
        const ids = [];
        
        $('.select-item:checked').each(function() {
            ids.push($(this).val());
        });
        
        if (!action) {
            alert('একটি অ্যাকশন নির্বাচন করুন');
            return;
        }
        
        if (ids.length === 0) {
            alert('কোন আইটেম নির্বাচন করা হয়নি');
            return;
        }
        
        if (confirm('নির্বাচিত আইটেমগুলিতে অ্যাকশন প্রয়োগ করবেন?')) {
            $.ajax({
                url: './ajax/batch-action.php',
                method: 'POST',
                data: {
                    action: action,
                    ids: ids
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
    
    // ইমেজ প্রিভিউ
    $('.preview-image').click(function() {
        const src = $(this).data('src');
        const title = $(this).data('title');
        
        $('#preview-image').attr('src', src);
        $('#preview-title').text(title);
        $('#preview-modal').removeClass('hidden');
    });
});

function closePreview() {
    $('#preview-modal').addClass('hidden');
}
</script>