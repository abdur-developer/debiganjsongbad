<?php
// admin/includes/config.php
session_start();

// সাইট URL কনফিগারেশন
// define('SITE_URL', 'http://debiganjsongbad.com');
define('SITE_URL', 'http://localhost:8080/news/');
define('ADMIN_URL', SITE_URL . '/admin');
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads');

// ডাটাবেজ কনফিগারেশন
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'debiganj_news');

// টাইম জোন সেট
date_default_timezone_set('Asia/Dhaka');

// এরর রিপোর্টিং
error_reporting(E_ALL);
ini_set('display_errors', 1);

function e(?string $string): string {
    if ($string === null) {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}