<?php
$auth->requirePermission('ads');

$sql = "SELECT a.*, u.full_name as creator_name 
        FROM advertisements a 
        LEFT JOIN users u ON a.created_by = u.id 
        ORDER BY a.created_at DESC";
$result = $conn->query($sql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">বিজ্ঞাপন ব্যবস্থাপনা</h2>
    <a href="?q=ads&create" class="bg-green-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> নতুন বিজ্ঞাপন
    </a>
</div>

<!-- ব্যাচ অ্যাকশন -->
<div id="batch-actions" class="bg-gray-100 p-3 rounded-lg mb-4 hidden flex items-center gap-3">
    <span class="text-sm"><span id="selected-count">0</span> টি সিলেক্টেড</span>
    <select id="batch-action" class="border rounded px-3 py-1 text-sm">
        <option value="">অ্যাকশন নির্বাচন</option>
        <option value="activate_ads">সক্রিয় করুন</option>
        <option value="deactivate_ads">নিষ্ক্রিয় করুন</option>
        <option value="delete_ads">মুছে ফেলুন</option>
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
                <!-- <th class="px-4 py-3 text-left">আইডি</th> -->
                <th class="px-4 py-3 text-left">শিরোনাম</th>
                <th class="px-4 py-3 text-left">টাইপ</th>
                <th class="px-4 py-3 text-left">পজিশন</th>
                <th class="px-4 py-3 text-left">স্ট্যাটাস</th>
                <th class="px-4 py-3 text-left">স্টার্ট</th>
                <th class="px-4 py-3 text-left">এন্ড</th>
                <th class="px-4 py-3 text-left">ক্লিক</th>
                <th class="px-4 py-3 text-left">ইমপ্রেশন</th>
                <th class="px-4 py-3 text-left">তৈরি করেছেন</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($ad = $result->fetch_assoc()): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">
                        <input type="checkbox" class="select-item rounded" value="<?php echo $ad['id']; ?>">
                    </td>
                    <!-- <td class="px-4 py-2"><php echo $ad['id']; ?></td> -->
                    <td class="px-4 py-2 font-semibold"><?php echo e($ad['title']); ?></td>
                    <td class="px-4 py-2"><?php echo ucfirst($ad['type']); ?></td>
                    <td class="px-4 py-2"><?php echo $ad['position']; ?></td>
                    <td class="px-4 py-2">
                        <?php if ($ad['status'] == 'active'): ?>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">সক্রিয়</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">নিষ্ক্রিয়</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 text-sm"><?php echo $ad['start_date']; ?></td>
                    <td class="px-4 py-2 text-sm"><?php echo $ad['end_date']; ?></td>
                    <td class="px-4 py-2"><?php echo number_format($ad['clicks']); ?></td>
                    <td class="px-4 py-2"><?php echo number_format($ad['impressions']); ?></td>
                    <td class="px-4 py-2 text-sm"><?php echo $ad['creator_name']; ?></td>
                    <td class="px-4 py-2">
                        <a href="?q=ads&edit_id=<?php echo $ad['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?q=ads&delete_id=<?php echo $ad['id']; ?>" 
                           class="text-red-600 hover:text-red-800 delete-confirm"
                           data-message="এই বিজ্ঞাপন মুছে ফেলবেন?">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="px-4 py-8 text-center text-gray-500">
                        কোনো বিজ্ঞাপন পাওয়া যায়নি
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
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
        
        if (confirm('নির্বাচিত বিজ্ঞাপনে এই অ্যাকশন প্রয়োগ করবেন?')) {
            $.ajax({
                url: '../ajax/batch-action.php',
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