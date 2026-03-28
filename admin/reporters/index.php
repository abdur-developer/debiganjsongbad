<?php
$auth->requirePermission('users');

$sql = "SELECT * FROM reporters ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">রিপোর্টার ব্যবস্থাপনা</h2>
    <a href="?q=reporters&create" class="bg-green-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> নতুন রিপোর্টার
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <!-- <th class="px-4 py-3 text-left">আইডি</th> -->
                <th class="px-4 py-3 text-left">ছবি</th>
                <th class="px-4 py-3 text-left">নাম</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">পদবি</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">ইমেইল</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()): ?>
            <tr class="border-t hover:bg-gray-50">
                <!-- <td class="px-4 py-2"><php echo $user['id']; ?></td> -->
                <td class="px-4 py-2">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <?php if ($user['avatar']): ?>
                            <img src="<?php echo $user['avatar']; ?>" class="w-8 h-8 rounded-full object-cover" alt="">
                        <?php else: ?>
                            <i class="fas fa-user text-gray-500"></i>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="px-4 py-2 font-semibold"><?php echo $user['full_name']; ?></td>
                <td class="px-4 py-2 hidden md:table-cell"><?php echo $user['designation']; ?></td>
                <td class="px-4 py-2 hidden md:table-cell"><?php echo $user['email']; ?></td>
                <td class="px-4 py-2">
                    <a href="?q=reporters&edit_id=<?php echo $user['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <!-- <a href="?q=reporters&delete_id=<php echo $user['id']; ?>" 
                       class="text-red-600 hover:text-red-800"
                       onclick="return confirm('নিশ্চিতভাবে মুছতে চান?')">
                        <i class="fas fa-trash"></i>
                    </a> -->
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>