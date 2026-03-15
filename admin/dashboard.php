<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total News -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-500 rounded-full text-white mr-4">
                <i class="fas fa-newspaper text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">মোট সংবাদ</p>
                <p class="text-2xl font-bold"><?= number_format($stats['total_news']); ?></p>
            </div>
        </div>
    </div>
    
    <!-- Today's News -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-500 rounded-full text-white mr-4">
                <i class="fas fa-calendar-day text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">আজকের সংবাদ</p>
                <p class="text-2xl font-bold"><?= number_format($stats['today_news']); ?></p>
            </div>
        </div>
    </div>
    
    <!-- Pending Comments -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-500 rounded-full text-white mr-4">
                <i class="fas fa-comments text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">পেন্ডিং মন্তব্য</p>
                <p class="text-2xl font-bold"><?= number_format($stats['pending_comments']); ?></p>
            </div>
        </div>
    </div>
    
    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-500 rounded-full text-white mr-4">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">মোট ব্যবহারকারী</p>
                <p class="text-2xl font-bold"><?= number_format($stats['total_users']); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Latest News -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">সর্বশেষ সংবাদ</h3>
        <div class="space-y-3">
            <?php
            $sql = "SELECT n.*, u.full_name as author_name, c.name_bn as category_name 
                    FROM news n 
                    LEFT JOIN users u ON n.author_id = u.id 
                    LEFT JOIN categories c ON n.category_id = c.id 
                    WHERE n.status = 'published' 
                    ORDER BY n.created_at DESC LIMIT 5";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0):
                while ($news = $result->fetch_assoc()):
            ?>
            <div class="flex items-center border-b pb-2">
                <img src="<?php echo $news['featured_image'] ?: 'https://via.placeholder.com/50'; ?>" 
                     class="w-12 h-12 object-cover rounded mr-3" alt="">
                <div class="flex-1">
                    <p class="font-semibold"><?php echo $news['title_bn']; ?></p>
                    <p class="text-xs text-gray-500">
                        <?php echo $news['author_name']; ?> | 
                        <?php echo date('d M Y', strtotime($news['created_at'])); ?>
                    </p>
                </div>
                <span class="text-xs bg-gray-200 px-2 py-1 rounded"><?php echo $news['views']; ?> ভিউ</span>
            </div>
            <?php 
                endwhile;
            endif;
            ?>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">সাম্প্রতিক কার্যক্রম</h3>
        <div class="space-y-3">
            <?php
            $sql = "SELECT l.*, u.username, u.full_name 
                    FROM activity_log l 
                    LEFT JOIN users u ON l.user_id = u.id 
                    ORDER BY l.created_at DESC LIMIT 7";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0):
                while ($log = $result->fetch_assoc()):
            ?>
            <div class="text-sm border-l-2 border-gray-300 pl-3 py-1">
                <p class="font-semibold"><?php echo $log['full_name'] ?: 'Unknown'; ?></p>
                <p class="text-gray-600"><?php echo $log['action']; ?> - <?php echo $log['details']; ?></p>
                <p class="text-xs text-gray-400"><?php echo date('d M Y h:i A', strtotime($log['created_at'])); ?></p>
            </div>
            <?php 
                endwhile;
            endif;
            ?>
        </div>
    </div>
</div>