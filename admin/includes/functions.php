<?php
// admin/includes/functions.php
require_once 'db.php';

class Functions {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // স্লাগ জেনারেট
    public function createSlug($string) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }
    
    // ফাইল আপলোড
    public function uploadFile($file, $folder = 'news', $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp']) {
        $targetDir = UPLOAD_PATH . $folder . '/';
        
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($file['name']);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // ফাইল টাইপ চেক
        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'error' => 'Invalid file type'];
        }
        
        // ফাইল সাইজ চেক (5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return ['success' => false, 'error' => 'File too large'];
        }
        
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return [
                'success' => true,
                'filename' => $fileName,
                'path' => '/uploads/' . $folder . '/' . $fileName,
                'url' => UPLOAD_URL . '/' . $folder . '/' . $fileName
            ];
        }
        
        return ['success' => false, 'error' => 'Upload failed'];
    }
    
    // নিউজের ভিউ সংখ্যা আপডেট
    public function updateNewsViews($newsId) {
        $newsId = intval($newsId);
        $sql = "UPDATE news SET views = views + 1 WHERE id = $newsId";
        return $this->db->query($sql);
    }
    
    // জনপ্রিয় নিউজ
    public function getPopularNews($limit = 10) {
        $sql = "SELECT n.*, c.name_bn as category_name 
                FROM news n 
                LEFT JOIN categories c ON n.category_id = c.id 
                WHERE n.status = 'published' 
                ORDER BY n.views DESC 
                LIMIT $limit";
        
        $result = $this->db->query($sql);
        $news = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $news[] = $row;
            }
        }
        
        return $news;
    }
    
    // ট্রেন্ডিং ট্যাগ
    public function getTrendingTags($limit = 20) {
        $sql = "SELECT tags, COUNT(*) as count 
                FROM news 
                WHERE tags IS NOT NULL 
                GROUP BY tags 
                ORDER BY count DESC 
                LIMIT $limit";
        
        $result = $this->db->query($sql);
        $tags = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $tagList = json_decode($row['tags'], true);
                if (is_array($tagList)) {
                    foreach ($tagList as $tag) {
                        $tags[] = $tag;
                    }
                }
            }
        }
        
        return array_slice(array_unique($tags), 0, $limit);
    }
    
    // সেটিংস পাওয়া
    public function getSetting($key, $default = '') {
        $key = $this->db->escape($key);
        $sql = "SELECT value FROM settings WHERE key_name = '$key'";
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['value'];
        }
        
        return $default;
    }
    
    // সেটিংস আপডেট
    public function updateSetting($key, $value) {
        $key = $this->db->escape($key);
        $value = $this->db->escape($value);
        
        $sql = "UPDATE settings SET value = '$value' WHERE key_name = '$key'";
        return $this->db->query($sql);
    }
    
    // ক্যাটাগরি লিস্ট
    public function getCategories($parentId = 0, $status = 'active') {
        $sql = "SELECT * FROM categories WHERE parent_id = $parentId";
        
        if ($status) {
            $sql .= " AND status = '$status'";
        }
        
        $sql .= " ORDER BY sort_order ASC, name_bn ASC";
        
        $result = $this->db->query($sql);
        $categories = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['children'] = $this->getCategories($row['id'], $status);
                $categories[] = $row;
            }
        }
        
        return $categories;
    }
    
    // ড্যাশবোর্ড পরিসংখ্যান
    public function getDashboardStats() {
        $stats = [];
        
        // মোট নিউজ
        $result = $this->db->query("SELECT COUNT(*) as total FROM news");
        $stats['total_news'] = $result->fetch_assoc()['total'];
        
        // আজকের নিউজ
        $result = $this->db->query("SELECT COUNT(*) as total FROM news WHERE DATE(created_at) = CURDATE()");
        $stats['today_news'] = $result->fetch_assoc()['total'];
        
        // পেন্ডিং কমেন্ট
        $result = $this->db->query("SELECT COUNT(*) as total FROM comments WHERE status = 'pending'");
        $stats['pending_comments'] = $result->fetch_assoc()['total'];
        
        // মোট ইউজার
        $result = $this->db->query("SELECT COUNT(*) as total FROM users");
        $stats['total_users'] = $result->fetch_assoc()['total'];
        
        // মোট ক্যাটাগরি
        $result = $this->db->query("SELECT COUNT(*) as total FROM categories WHERE status = 'active'");
        $stats['total_categories'] = $result->fetch_assoc()['total'];
        
        // আজকের ভিজিটর (আনুমানিক)
        $stats['today_visitors'] = rand(500, 2000);
        
        return $stats;
    }
}

$functions = new Functions();