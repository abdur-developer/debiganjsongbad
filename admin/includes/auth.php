<?php
// admin/includes/auth.php
require_once 'db.php';

class Auth {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function login($username, $password) {
        $username = $this->db->escape($username);
        
        $sql = "SELECT * FROM users WHERE (username = '$username' OR email = '$username') AND status = 'active'";
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                
                // লাস্ট লগিন আপডেট
                $updateSql = "UPDATE users SET last_login = NOW() WHERE id = " . $user['id'];
                $this->db->query($updateSql);
                
                // লগ তৈরি
                $this->logActivity($user['id'], 'login', 'User logged in');
                
                return true;
            }
        }
        
        return false;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $this->logActivity($_SESSION['user_id'], 'logout', 'User logged out');
        }
        
        session_destroy();
        return true;
    }
    
    public function getUser($userId = null) {
        if ($userId === null) {
            $userId = $_SESSION['user_id'] ?? 0;
        }
        
        $sql = "SELECT * FROM users WHERE id = " . intval($userId);
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    public function hasPermission($permission) {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        $role = $_SESSION['role'];
        
        $sql = "SELECT permissions FROM roles_permissions WHERE role = '$role'";
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $permissions = json_decode($row['permissions'], true);
            
            // সুপার অ্যাডমিনের সব পারমিশন
            if ($role == 'super_admin') {
                return true;
            }
            
            // পারমিশন চেক
            foreach ($permissions as $key => $value) {
                if ($key == $permission) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit();
        }
    }
    
    public function requirePermission($permission) {
        $this->requireLogin();
        
        if (!$this->hasPermission($permission)) {
            echo '<script>window.location.href = "./?error=permission_denied";</script>';
            exit();
        }
    }
    
    private function logActivity($userId, $action, $details = '') {
        $userId = intval($userId);
        $action = $this->db->escape($action);
        $details = $this->db->escape($details);
        $ip = $this->db->escape($_SERVER['REMOTE_ADDR']);
        
        $sql = "INSERT INTO activity_log (user_id, action, details, ip_address) 
                VALUES ($userId, '$action', '$details', '$ip')";
        $this->db->query($sql);
    }
    
    public function getUsers($role = null, $status = null) {
        $sql = "SELECT * FROM users WHERE 1=1";
        
        if ($role) {
            $sql .= " AND role = '" . $this->db->escape($role) . "'";
        }
        
        if ($status) {
            $sql .= " AND status = '" . $this->db->escape($status) . "'";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $result = $this->db->query($sql);
        $users = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        
        return $users;
    }
}

$auth = new Auth();