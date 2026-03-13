<?php
$auth->requirePermission('users');

$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg md:text-2xl font-bold">ব্যবহারকারী ব্যবস্থাপনা</h2>
    <a href="?q=users&create" class="bg-green-600 text-xs md:text-sm text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> নতুন ব্যবহারকারী
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">আইডি</th>
                <th class="px-4 py-3 text-left">ছবি</th>
                <th class="px-4 py-3 text-left">নাম</th>
                <th class="px-4 py-3 text-left">ইউজারনেম</th>
                <th class="px-4 py-3 text-left">ইমেইল</th>
                <th class="px-4 py-3 text-left">রোল</th>
                <th class="px-4 py-3 text-left">স্ট্যাটাস</th>
                <th class="px-4 py-3 text-left">লাস্ট লগিন</th>
                <th class="px-4 py-3 text-left">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()): ?>
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2"><?php echo $user['id']; ?></td>
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
                <td class="px-4 py-2"><?php echo $user['username']; ?></td>
                <td class="px-4 py-2"><?php echo $user['email']; ?></td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded text-xs 
                        <?php
                        switch($user['role']) {
                            case 'super_admin':
                                echo 'bg-purple-100 text-purple-800';
                                break;
                            case 'admin':
                                echo 'bg-red-100 text-red-800';
                                break;
                            case 'editor':
                                echo 'bg-blue-100 text-blue-800';
                                break;
                            case 'reporter':
                                echo 'bg-green-100 text-green-800';
                                break;
                            default:
                                echo 'bg-gray-100 text-gray-800';
                        }
                        ?>">
                        <?php 
                        $roles = [
                            'super_admin' => 'সুপার অ্যাডমিন',
                            'admin' => 'অ্যাডমিন',
                            'editor' => 'এডিটর',
                            'reporter' => 'রিপোর্টার',
                            'moderator' => 'মডারেটর'
                        ];
                        echo $roles[$user['role']] ?? $user['role'];
                        ?>
                    </span>
                </td>
                <td class="px-4 py-2">
                    <?php if ($user['status'] == 'active'): ?>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">সক্রিয়</span>
                    <?php elseif ($user['status'] == 'inactive'): ?>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">নিষ্ক্রিয়</span>
                    <?php else: ?>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">নিষিদ্ধ</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-2 text-sm">
                    <?php echo $user['last_login'] ? date('d/m/Y h:i A', strtotime($user['last_login'])) : '-'; ?>
                </td>
                <td class="px-4 py-2">
                    <a href="?q=users&edit_id=<?php echo $user['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                    <a href="?q=users&delete_id=<?php echo $user['id']; ?>" 
                       class="text-red-600 hover:text-red-800"
                       onclick="return confirm('নিশ্চিতভাবে মুছতে চান?')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>