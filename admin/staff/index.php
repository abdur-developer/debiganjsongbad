<?php
// admin/staff/index.php - স্টাফ ম্যানেজমেন্ট প্যানেল
require_once '../includes/header.php';
$auth->requirePermission('users');

$sql = "SELECT * FROM staffs ORDER BY sort_order ASC, id ASC";
$result = $conn->query($sql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">স্টাফ ব্যবস্থাপনা</h2>
    <a href="create.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> নতুন স্টাফ যোগ করুন
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">আইডি</th>
                <th class="px-4 py-3 text-left">ছবি</th>
                <th class="px-4 py-3 text-left">নাম</th>
                <th class="px-4 py-3 text-left">পদবি</th>
                <th class="px-4 py-3 text-left">বিভাগ</th>
                <th class="px-4 py-3 text-left">ইমেইল</th>
                <th class="px-4 py-3 text-left">ফোন</th>
                <th class="px-4 py-3 text-left">সর্ডার</th>
                <th class="px-4 py-3 text-left">স্ট্যাটাস</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($staff = $result->fetch_assoc()): ?>
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2"><?php echo $staff['id']; ?></td>
                <td class="px-4 py-2">
                    <?php if (!empty($staff['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $staff['image'])): ?>
                    <img src="<?php echo $staff['image']; ?>" class="w-10 h-10 object-cover rounded-full" alt="">
                    <?php else: ?>
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-2 font-semibold"><?php echo $staff['name_bn']; ?></td>
                <td class="px-4 py-2"><?php echo $staff['designation_bn']; ?></td>
                <td class="px-4 py-2"><?php echo $staff['department']; ?></td>
                <td class="px-4 py-2 text-sm"><?php echo $staff['email']; ?></td>
                <td class="px-4 py-2"><?php echo $staff['phone']; ?></td>
                <td class="px-4 py-2"><?php echo $staff['sort_order']; ?></td>
                <td class="px-4 py-2">
                    <?php if ($staff['status'] == 'active'): ?>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">সক্রিয়</span>
                    <?php else: ?>
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">নিষ্ক্রিয়</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-2">
                    <a href="edit.php?id=<?php echo $staff['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete.php?id=<?php echo $staff['id']; ?>" class="text-red-600 hover:text-red-800 delete-confirm">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>