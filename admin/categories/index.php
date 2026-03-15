<?php
$auth->requirePermission('categories');

// ক্যাটাগরি লিস্ট
$sql = "SELECT c.*, u.full_name as creator_name,
        (SELECT COUNT(*) FROM news WHERE category_id = c.id) as news_count 
        FROM categories c 
        LEFT JOIN users u ON c.created_by = u.id 
        ORDER BY c.sort_order ASC, c.name_bn ASC";
$result = $conn->query($sql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">ক্যাটাগরি ব্যবস্থাপনা</h2>
    <a href="?q=categories&create" class="bg-green-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> নতুন ক্যাটাগরি
    </a>
</div>

<!-- ব্যাচ অ্যাকশন টুলবার -->
<div id="batch-actions" class="bg-gray-100 p-3 rounded-lg mb-4 hidden flex items-center gap-3">
    <span class="text-sm"><span id="selected-count">0</span> টি সিলেক্টেড</span>
    <select id="batch-action" class="border rounded px-3 py-1 text-sm">
        <option value="">অ্যাকশন নির্বাচন</option>
        <option value="activate_categories">সক্রিয় করুন</option>
        <option value="deactivate_categories">নিষ্ক্রিয় করুন</option>
        <option value="delete_categories">মুছে ফেলুন</option>
    </select>
    <button id="apply-batch" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">
        প্রয়োগ করুন
    </button>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left w-10">
                    <input type="checkbox" id="select-all" class="rounded">
                </th>
                <th class="px-4 py-3 text-left hidden md:table-cell">আইডি</th>
                <th class="px-4 py-3 text-left">নাম (বাংলা)</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">নাম (ইংরেজি)</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">স্লাগ</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">প্যারেন্ট</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">নিউজ সংখ্যা</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">স্ট্যাটাস</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">সর্ডার</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">তৈরি করেছেন</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($cat = $result->fetch_assoc()): 
                    // প্যারেন্ট ক্যাটাগরি নাম
                    $parentName = '-';
                    if ($cat['parent_id'] > 0) {
                        $parentSql = "SELECT name_bn FROM categories WHERE id = " . $cat['parent_id'];
                        $parentResult = $conn->query($parentSql);
                        if ($parentResult && $parentResult->num_rows > 0) {
                            $parent = $parentResult->fetch_assoc();
                            $parentName = $parent['name_bn'];
                        }
                    }
                ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">
                        <input type="checkbox" class="select-item rounded" value="<?php echo $cat['id']; ?>">
                    </td>
                    <td class="px-4 py-2 hidden md:table-cell"><?php echo $cat['id']; ?></td>
                    <td class="px-4 py-2 font-semibold"><?php echo e($cat['name_bn']); ?></td>
                    <td class="px-4 py-2 hidden md:table-cell"><?php echo e($cat['name_en']); ?></td>
                    <td class="px-4 py-2 hidden md:table-cell text-sm"><?php echo $cat['slug']; ?></td>
                    <td class="px-4 py-2 hidden md:table-cell text-sm"><?php echo $parentName; ?></td>
                    <td class="px-4 py-2 hidden md:table-cell text-center"><?php echo $cat['news_count']; ?></td>
                    <td class="px-4 py-2 hidden md:table-cell">
                        <?php if ($cat['status'] == 'active'): ?>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">সক্রিয়</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">নিষ্ক্রিয়</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 hidden md:table-cell"><?php echo $cat['sort_order']; ?></td>
                    <td class="px-4 py-2 hidden md:table-cell text-sm"><?php echo $cat['creator_name']; ?></td>
                    <td class="px-4 py-2">
                        <a href="?q=categories&edit_id=<?php echo $cat['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2" title="এডিট">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if ($cat['news_count'] == 0): ?>
                        <a href="?q=categories&delete_id=<?php echo $cat['id']; ?>" 
                           class="text-red-600 hover:text-red-800 delete-confirm" 
                           title="ডিলিট"
                           data-message="এই ক্যাটাগরি মুছে ফেলবেন?">
                            <i class="fas fa-trash"></i>
                        </a>
                        <?php else: ?>
                        <span class="text-gray-400 cursor-not-allowed" title="এই ক্যাটাগরিতে নিউজ আছে">
                            <i class="fas fa-trash"></i>
                        </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="px-4 py-8 text-center text-gray-500">
                        কোনো ক্যাটাগরি পাওয়া যায়নি
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
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
        
        let confirmMessage = '';
        switch(action) {
            case 'activate_categories':
                confirmMessage = 'নির্বাচিত ক্যাটাগরি সক্রিয় করবেন?';
                break;
            case 'deactivate_categories':
                confirmMessage = 'নির্বাচিত ক্যাটাগরি নিষ্ক্রিয় করবেন?';
                break;
            case 'delete_categories':
                confirmMessage = 'নির্বাচিত ক্যাটাগরি মুছে ফেলবেন? এতে কোনো নিউজ থাকলে ডিলিট হবে না।';
                break;
        }
        
        if (confirm(confirmMessage)) {
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
});
</script>