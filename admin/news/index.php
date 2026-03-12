<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$category = isset($_GET['category']) ? intval($_GET['category']) : 0;
$status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';

$where = [];
if ($search) {
    $where[] = "(title_bn LIKE '%$search%' OR content LIKE '%$search%')";
}
if ($category > 0) {
    $where[] = "category_id = $category";
}
if ($status) {
    $where[] = "status = '$status'";
}

$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT n.*, c.name_bn as category_name, u.full_name as author_name 
        FROM news n 
        LEFT JOIN categories c ON n.category_id = c.id 
        LEFT JOIN users u ON n.author_id = u.id 
        $whereClause 
        ORDER BY n.created_at DESC 
        LIMIT $offset, $limit";
$result = $conn->query($sql);

$totalSql = "SELECT COUNT(*) as total FROM news n $whereClause";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">সংবাদ ব্যবস্থাপনা</h2>
    <a href="?q=news&create" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> নতুন সংবাদ
    </a>
</div>

<!-- ফিল্টার -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" name="search" placeholder="সার্চ করুন..." 
                   value="<?php echo htmlspecialchars($search); ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <select name="category" class="w-full px-3 py-2 border rounded">
                <option value="0">সব ক্যাটাগরি</option>
                <?php
                $catSql = "SELECT * FROM categories WHERE status = 'active' ORDER BY name_bn";
                $catResult = $conn->query($catSql);
                while ($cat = $catResult->fetch_assoc()):
                ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo $category == $cat['id'] ? 'selected' : ''; ?>>
                    <?php echo $cat['name_bn']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <select name="status" class="w-full px-3 py-2 border rounded">
                <option value="">সব স্ট্যাটাস</option>
                <option value="published" <?php echo $status == 'published' ? 'selected' : ''; ?>>প্রকাশিত</option>
                <option value="draft" <?php echo $status == 'draft' ? 'selected' : ''; ?>>খসড়া</option>
                <option value="archived" <?php echo $status == 'archived' ? 'selected' : ''; ?>>আর্কাইভ</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                <i class="fas fa-search"></i> ফিল্টার
            </button>
        </div>
    </form>
</div>

<!-- নিউজ লিস্ট -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">ছবি</th>
                <th class="px-4 py-3 text-left">শিরোনাম</th>
                <th class="px-4 py-3 text-left">ক্যাটাগরি</th>
                <th class="px-4 py-3 text-left">লেখক</th>
                <th class="px-4 py-3 text-left">তারিখ</th>
                <th class="px-4 py-3 text-left">স্ট্যাটাস</th>
                <th class="px-4 py-3 text-left">ভিউ</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($news = $result->fetch_assoc()): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">
                        <img src="<?php echo $news['featured_image'] ?: 'https://via.placeholder.com/50'; ?>" 
                             class="w-12 h-12 object-cover rounded" alt="">
                    </td>
                    <td class="px-4 py-2 font-semibold"><?php echo $news['title_bn']; ?></td>
                    <td class="px-4 py-2"><?php echo $news['category_name']; ?></td>
                    <td class="px-4 py-2"><?php echo $news['author_name']; ?></td>
                    <td class="px-4 py-2 text-sm"><?php echo date('d/m/Y', strtotime($news['created_at'])); ?></td>
                    <td class="px-4 py-2">
                        <?php if ($news['status'] == 'published'): ?>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">প্রকাশিত</span>
                        <?php elseif ($news['status'] == 'draft'): ?>
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">খসড়া</span>
                        <?php else: ?>
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">আর্কাইভ</span>
                        <?php endif; ?>
                        
                        <?php if ($news['is_breaking']): ?>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs ml-1">ব্রেকিং</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2"><?php echo number_format($news['views']); ?></td>
                    <td class="px-4 py-2">
                        <a href="?q=news&edit_id=<?php echo $news['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?q=news&delete_id=<?php echo $news['id']; ?>" 
                           class="text-red-600 hover:text-red-800"
                           onclick="return confirm('নিশ্চিতভাবে মুছতে চান?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                        কোনো সংবাদ পাওয়া যায়নি
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
        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo $category; ?>&status=<?php echo $status; ?>" 
           class="px-3 py-1 <?php echo $i == $page ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
    </div>
</div>
<?php endif; ?>