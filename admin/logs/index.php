<?php
$auth->requirePermission('settings');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 50;
$offset = ($page - 1) * $limit;

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$action = isset($_GET['action']) ? $conn->real_escape_string($_GET['action']) : '';

$where = [];
if ($user_id > 0) {
    $where[] = "user_id = $user_id";
}
if ($action) {
    $where[] = "action LIKE '%$action%'";
}

$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT l.*, u.username, u.full_name 
        FROM activity_log l 
        LEFT JOIN users u ON l.user_id = u.id 
        $whereClause 
        ORDER BY l.created_at DESC 
        LIMIT $offset, $limit";
$result = $conn->query($sql);

$totalSql = "SELECT COUNT(*) as total FROM activity_log l $whereClause";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);

// ইউজার লিস্ট
$userSql = "SELECT id, username, full_name FROM users ORDER BY full_name";
$userResult = $conn->query($userSql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">অ্যাক্টিভিটি লগ</h2>
</div>

<!-- ফিল্টার -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <select name="user_id" class="w-full px-3 py-2 border rounded">
                <option value="0">সব ব্যবহারকারী</option>
                <?php while ($user = $userResult->fetch_assoc()): ?>
                <option value="<?php echo $user['id']; ?>" <?php echo $user_id == $user['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($user['full_name'] ?: $user['username']); ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        <input type="hidden" name="q" value="logs">
        <div>
            <input type="text" name="action" placeholder="অ্যাকশন সার্চ..." 
                   value="<?php echo htmlspecialchars($action); ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                <i class="fas fa-search"></i> ফিল্টার
            </button>
        </div>
        <?php if ($user_id || $action): ?>
        <div>
            <a href="index.php?q=logs" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 block text-center">
                <i class="fas fa-times"></i> রিসেট
            </a>
        </div>
        <?php endif; ?>
    </form>
</div>

<!-- লগ টেবিল -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">সময়</th>
                <th class="px-4 py-3 text-left">ব্যবহারকারী</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
                <th class="px-4 py-3 text-left">বিবরণ</th>
                <th class="px-4 py-3 text-left">আইপি ঠিকানা</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($log = $result->fetch_assoc()): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm whitespace-nowrap">
                        <?php echo date('d/m/Y h:i A', strtotime($log['created_at'])); ?>
                    </td>
                    <td class="px-4 py-2">
                        <?php if ($log['user_id']): ?>
                            <span class="font-semibold"><?php echo htmlspecialchars($log['full_name'] ?: $log['username']); ?></span>
                        <?php else: ?>
                            <span class="text-gray-400">সিস্টেম</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                            <?php echo $log['action']; ?>
                        </span>
                    </td>
                    <td class="px-4 py-2"><?php echo htmlspecialchars($log['details']); ?></td>
                    <td class="px-4 py-2 text-xs font-mono"><?php echo $log['ip_address']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                        কোনো লগ পাওয়া যায়নি
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
        <a href="?page=<?php echo $i; ?>&user_id=<?php echo $user_id; ?>&action=<?php echo urlencode($action); ?>" 
           class="px-3 py-1 <?php echo $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
    </div>
</div>
<?php endif; ?>