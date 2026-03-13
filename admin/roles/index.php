<?php
$auth->requirePermission('users');

$sql = "SELECT * FROM roles_permissions ORDER BY id";
$result = $conn->query($sql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">রোল ব্যবস্থাপনা</h2>
    <a href="?q=roles&create" class="bg-green-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> নতুন রোল
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">আইডি</th>
                <th class="px-4 py-3 text-left">রোল</th>
                <th class="px-4 py-3 text-left">পারমিশন</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($role = $result->fetch_assoc()): 
                    $permissions = json_decode($role['permissions'], true);
                ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2"><?php echo $role['id']; ?></td>
                    <td class="px-4 py-2 font-semibold"><?php echo ucfirst($role['role']); ?></td>
                    <td class="px-4 py-2">
                        <div class="flex flex-wrap gap-1">
                            <?php foreach ($permissions as $key => $value): ?>
                                <?php if ($value != 'none'): ?>
                                <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs">
                                    <?php echo $key; ?>: <?php echo $value; ?>
                                </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </td>
                    <td class="px-4 py-2">
                        <a href="?q=roles&edit_id=<?php echo $role['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if (!in_array($role['role'], ['super_admin', 'admin'])): ?>
                        <a href="?q=roles&delete_id=<?php echo $role['id']; ?>" 
                           class="text-red-600 hover:text-red-800 delete-confirm"
                           data-message="এই রোল মুছে ফেলবেন?">
                            <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                        কোনো রোল পাওয়া যায়নি
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>