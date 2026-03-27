<?php
// config.php
session_start();

// ডাটাবেজ কনফিগারেশন
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'debiganj_news');

// ওয়েবসাইট কনফিগারেশন
define('SITE_URL', 'http://localhost/news-site/');
define('SITE_NAME', 'News Portal');

// অ্যাড কনফিগারেশন
define('AD_REFRESH_INTERVAL', 3600); // 1 ঘন্টা (সেশন রিফ্রেশ)
define('ENABLE_AD_LIMIT', true); // লিমিট চালু/বন্ধ

// ডাটাবেজ কানেকশন
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("set names utf8");
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ফাংশন ফাইল ইনক্লুড
require_once 'ad_functions.php';
?>