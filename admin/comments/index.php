<?php
$auth->requirePermission('comments');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$where = [];
if ($status) {
    $where[] = "c.status = '$status'";
}
if ($search) {
    $where[] = "(c.comment LIKE '%$search%' OR c.name LIKE '%$search%' OR c.email LIKE '%$search%')";// OR n.title_bn LIKE '%$search%'
}

$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT c.*, n.title_bn as news_title 
        FROM comments c 
        LEFT JOIN news n ON c.news_id = n.id 
        $whereClause 
        ORDER BY c.created_at DESC 
        LIMIT $offset, $limit";
$result = $conn->query($sql);

$totalSql = "SELECT COUNT(*) as total FROM comments c $whereClause";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">মন্তব্য ব্যবস্থাপনা</h2>
</div>

<!-- ফিল্টার -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="hidden" name="q" value="comments">
        <div>
            <input type="text" name="search" placeholder="সার্চ করুন..." 
                   value="<?php echo htmlspecialchars($search); ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <select name="status" class="w-full px-3 py-2 border rounded">
                <option value="">সব স্ট্যাটাস</option>
                <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>পেন্ডিং</option>
                <option value="approved" <?php echo $status == 'approved' ? 'selected' : ''; ?>>অনুমোদিত</option>
                <option value="spam" <?php echo $status == 'spam' ? 'selected' : ''; ?>>স্প্যাম</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                <i class="fas fa-search"></i> ফিল্টার
            </button>
        </div>
        <?php if ($search || $status): ?>
        <div>
            <a href="index.php?q=comments" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 block text-center">
                <i class="fas fa-times"></i> রিসেট
            </a>
        </div>
        <?php endif; ?>
    </form>
</div>

<!-- ব্যাচ অ্যাকশন -->
<div id="batch-actions" class="bg-gray-100 p-3 rounded-lg mb-4 hidden flex items-center gap-3">
    <span class="text-sm"><span id="selected-count">0</span> টি সিলেক্টেড</span>
    <select id="batch-action" class="border rounded px-3 py-1 text-sm">
        <option value="">অ্যাকশন নির্বাচন</option>
        <option value="approve_comments">অনুমোদন করুন</option>
        <option value="pending_comments">পেন্ডিং করুন</option>
        <option value="spam_comments">স্প্যাম করুন</option>
        <option value="delete_comments">মুছে ফেলুন</option>
    </select>
    <button id="apply-batch" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">
        প্রয়োগ করুন
    </button>
</div>

<!-- কমেন্ট লিস্ট -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left w-10">
                    <input type="checkbox" id="select-all" class="rounded">
                </th>
                <th class="px-4 py-3 text-left">আইডি</th>
                <th class="px-4 py-3 text-left">নিউজ</th>
                <th class="px-4 py-3 text-left">নাম</th>
                <th class="px-4 py-3 text-left">ইমেইল</th>
                <th class="px-4 py-3 text-left">মন্তব্য</th>
                <th class="px-4 py-3 text-left">স্ট্যাটাস</th>
                <th class="px-4 py-3 text-left">তারিখ</th>
                <th class="px-4 py-3 text-left">আইপি</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($comment = $result->fetch_assoc()): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">
                        <input type="checkbox" class="select-item rounded" value="<?php echo $comment['id']; ?>">
                    </td>
                    <td class="px-4 py-2"><?php echo $comment['id']; ?></td>
                    <td class="px-4 py-2">
                        <a href="../news/?feed=<?php echo $comment['news_id']; ?>" target="_blank" class="text-blue-600 hover:underline">
                            <?php echo htmlspecialchars(substr($comment['news_title'], 0, 30) . '...'); ?>
                        </a>
                    </td>
                    <td class="px-4 py-2"><?php echo htmlspecialchars($comment['name']); ?></td>
                    <td class="px-4 py-2"><?php echo htmlspecialchars($comment['email']); ?></td>
                    <td class="px-4 py-2">
                        <div class="max-w-xs truncate" title="<?php echo htmlspecialchars($comment['comment']); ?>">
                            <?php echo htmlspecialchars(substr($comment['comment'], 0, 50) . '...'); ?>
                        </div>
                    </td>
                    <td class="px-4 py-2">
                        <?php if ($comment['status'] == 'approved'): ?>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">অনুমোদিত</span>
                        <?php elseif ($comment['status'] == 'pending'): ?>
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">পেন্ডিং</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">স্প্যাম</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 text-sm"><?php echo date('d/m/Y', strtotime($comment['created_at'])); ?></td>
                    <td class="px-4 py-2 text-xs"><?php echo $comment['ip_address']; ?></td>
                    <td class="px-4 py-2">
                        <div class="flex gap-1">
                            <?php if ($comment['status'] != 'approved'): ?>
                            <a href="?q=comments&approve_id=<?php echo $comment['id']; ?>" class="text-green-600 hover:text-green-800" title="অনুমোদন">
                                <i class="fas fa-check"></i>
                            </a>
                            <?php endif; ?>
                            <?php if ($comment['status'] != 'spam'): ?>
                            <a href="?q=comments&spam_id=<?php echo $comment['id']; ?>" class="text-yellow-600 hover:text-yellow-800" title="স্প্যাম">
                                <i class="fas fa-exclamation-triangle"></i>
                            </a>
                            <?php endif; ?>
                            <a href="?q=comments&delete_id=<?php echo $comment['id']; ?>" 
                               class="text-red-600 hover:text-red-800 delete-confirm"
                               data-message="এই মন্তব্য মুছে ফেলবেন?">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                        কোনো মন্তব্য পাওয়া যায়নি
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- পেজিনেশন -->
<?php if ($totalPages > 1): ?>
<div class="flex justify-center mt-6">
    <div class="flex gap-2">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&status=<?php echo urlencode($status); ?>&search=<?php echo urlencode($search); ?>" 
           class="px-3 py-1 <?php echo $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
    </div>
</div>
<?php endif; ?>

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
        
        if (confirm('নির্বাচিত মন্তব্যে এই অ্যাকশন প্রয়োগ করবেন?')) {
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