<?php
$auth->requirePermission('users');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_bn = $conn->real_escape_string($_POST['name_bn']);
    $name_en = $conn->real_escape_string($_POST['name_en']);
    $designation_bn = $conn->real_escape_string($_POST['designation_bn']);
    $designation_en = $conn->real_escape_string($_POST['designation_en']);
    $department = $conn->real_escape_string($_POST['department']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $facebook = $conn->real_escape_string($_POST['facebook']);
    $linkedin = $conn->real_escape_string($_POST['linkedin']);
    $twitter = $conn->real_escape_string($_POST['twitter']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $joining_date = $conn->real_escape_string($_POST['joining_date']);
    $sort_order = intval($_POST['sort_order']);
    $status = $conn->real_escape_string($_POST['status']);
    
    if (empty($name_bn) || empty($designation_bn)) {
        $error = 'নাম এবং পদবি প্রয়োজন';
    } else {
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload = $functions->uploadFile($_FILES['image'], 'staff', ['jpg', 'jpeg', 'png', 'webp']);
            if ($upload['success']) {
                $image = $upload['path'];
            }
        }
        
        $sql = "INSERT INTO staffs (name_bn, name_en, designation_bn, designation_en, department, image, email, phone, facebook, linkedin, twitter, bio, joining_date, sort_order, status, created_at) 
                VALUES ('$name_bn', '$name_en', '$designation_bn', '$designation_en', '$department', '$image', '$email', '$phone', '$facebook', '$linkedin', '$twitter', '$bio', '$joining_date', $sort_order, '$status', NOW())";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = 'স্টাফ যোগ করা হয়েছে';
            header('Location: index.php');
            exit();
        } else {
            $error = 'ত্রুটি: ' . $conn->error;
        }
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">নতুন স্টাফ যোগ করুন</h2>
    <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        <i class="fas fa-arrow-left"></i> ফিরে যান
    </a>
</div>

<?php if ($error): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block font-semibold mb-2">নাম (বাংলা) *</label>
            <input type="text" name="name_bn" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
        </div>
        <div>
            <label class="block font-semibold mb-2">নাম (ইংরেজি)</label>
            <input type="text" name="name_en" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">পদবি (বাংলা) *</label>
            <input type="text" name="designation_bn" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">পদবি (ইংরেজি)</label>
            <input type="text" name="designation_en" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">বিভাগ</label>
            <select name="department" class="w-full px-3 py-2 border rounded">
                <option value="Editorial">সম্পাদকীয় বিভাগ</option>
                <option value="News">সংবাদ বিভাগ</option>
                <option value="Crime">ক্রাইম বিভাগ</option>
                <option value="Sports">খেলাধুলা বিভাগ</option>
                <option value="Photography">ফটোগ্রাফি বিভাগ</option>
                <option value="Digital">ডিজিটাল বিভাগ</option>
                <option value="Video">ভিডিও বিভাগ</option>
                <option value="Marketing">মার্কেটিং বিভাগ</option>
            </select>
        </div>
        <div>
            <label class="block font-semibold mb-2">সর্ডার অর্ডার</label>
            <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">ইমেইল</label>
            <input type="email" name="email" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">ফোন</label>
            <input type="text" name="phone" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">যোগদানের তারিখ</label>
            <input type="date" name="joining_date" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">স্ট্যাটাস</label>
            <select name="status" class="w-full px-3 py-2 border rounded">
                <option value="active">সক্রিয়</option>
                <option value="inactive">নিষ্ক্রিয়</option>
            </select>
        </div>
        <div>
            <label class="block font-semibold mb-2">প্রোফাইল ছবি</label>
            <input type="file" name="image" accept="image/*" class="w-full">
        </div>
        <div>
            <label class="block font-semibold mb-2">ফেসবুক লিংক</label>
            <input type="url" name="facebook" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">লিংকডইন লিংক</label>
            <input type="url" name="linkedin" class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block font-semibold mb-2">টুইটার লিংক</label>
            <input type="url" name="twitter" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="md:col-span-2">
            <label class="block font-semibold mb-2">বায়ো/পরিচয়</label>
            <textarea name="bio" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
        </div>
    </div>
    <div class="mt-6 flex justify-end gap-2">
        <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded">বাতিল</a>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">সংরক্ষণ করুন</button>
    </div>
</form>