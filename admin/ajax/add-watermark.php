<?php
// admin/ajax/add-watermark.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$imageId = isset($_POST['image_id']) ? intval($_POST['image_id']) : 0;
$position = $_POST['position'] ?? 'bottom-right';

if (!$imageId) {
    echo json_encode(['success' => false, 'message' => 'Image ID required']);
    exit();
}

// ইমেজ তথ্য পাওয়া
$sql = "SELECT * FROM gallery WHERE id = $imageId";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Image not found']);
    exit();
}

$image = $result->fetch_assoc();
$imagePath = $_SERVER['DOCUMENT_ROOT'] . $image['image'];

if (!file_exists($imagePath)) {
    echo json_encode(['success' => false, 'message' => 'Image file not found']);
    exit();
}

// ওয়াটারমার্ক টেক্সট
$watermarkText = 'দেবীগঞ্জ সংবাদ';
$fontSize = 30;
$fontFile = $_SERVER['DOCUMENT_ROOT'] . '/assets/fonts/HindSiliguri-Bold.ttf';

// ইমেজ ইনফো
list($width, $height, $type) = getimagesize($imagePath);

// ইমেজ টাইপ অনুযায়ী তৈরি
switch ($type) {
    case IMAGETYPE_JPEG:
        $im = imagecreatefromjpeg($imagePath);
        break;
    case IMAGETYPE_PNG:
        $im = imagecreatefrompng($imagePath);
        break;
    case IMAGETYPE_GIF:
        $im = imagecreatefromgif($imagePath);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Unsupported image type']);
        exit();
}

// কালার তৈরি
$black = imagecolorallocatealpha($im, 0, 0, 0, 50);
$white = imagecolorallocatealpha($im, 255, 255, 255, 30);
$red = imagecolorallocatealpha($im, 220, 38, 38, 40);

// টেক্সট সাইজ ক্যালকুলেট
$textBox = imagettfbbox($fontSize, 0, $fontFile, $watermarkText);
$textWidth = $textBox[2] - $textBox[0];
$textHeight = $textBox[1] - $textBox[7];

// পজিশন নির্ধারণ
$padding = 20;
switch ($position) {
    case 'top-left':
        $x = $padding;
        $y = $padding + $textHeight;
        break;
    case 'top-right':
        $x = $width - $textWidth - $padding;
        $y = $padding + $textHeight;
        break;
    case 'bottom-left':
        $x = $padding;
        $y = $height - $padding;
        break;
    case 'bottom-right':
        $x = $width - $textWidth - $padding;
        $y = $height - $padding;
        break;
    case 'center':
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        break;
    default:
        $x = $width - $textWidth - $padding;
        $y = $height - $padding;
}

// ব্যাকগ্রাউন্ড বক্স
imagefilledrectangle($im, $x - 10, $y - $textHeight - 10, $x + $textWidth + 10, $y + 10, $black);

// টেক্সট লেখা
imagettftext($im, $fontSize, 0, $x, $y, $white, $fontFile, $watermarkText);

// ইমেজ সেভ
switch ($type) {
    case IMAGETYPE_JPEG:
        imagejpeg($im, $imagePath, 90);
        break;
    case IMAGETYPE_PNG:
        imagepng($im, $imagePath, 9);
        break;
    case IMAGETYPE_GIF:
        imagegif($im, $imagePath);
        break;
}

imagedestroy($im);

// লগ তৈরি
$userId = $_SESSION['user_id'];
$ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR']);
$logSql = "INSERT INTO activity_log (user_id, action, details, ip_address) 
           VALUES ($userId, 'add_watermark', 'Added watermark to image ID: $imageId', '$ip')";
$conn->query($logSql);

echo json_encode([
    'success' => true,
    'message' => 'ওয়াটারমার্ক যোগ হয়েছে',
    'image' => $image['image']
]);