<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'debiganj_news';

define('SITE_URL', 'http://localhost:8080/my_news/');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed");
}
?>