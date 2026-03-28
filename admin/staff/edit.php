<?php
// admin/staff/edit.php
require_once '../includes/header.php';
require_once '../includes/functions.php';
$auth->requirePermission('users');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: index.php'); exit(); }

$sql = "SELECT * FROM staffs WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows == 0) { header('Location: index.php'); exit(); }
$staff = $result->fetch_assoc();

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
    
    $image = $staff['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload = uploadFile($_FILES['image'], 'staff', ['jpg', 'jpeg', 'png', 'webp']);
        if ($upload['success']) {
            if (!empty($staff['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $staff['image'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $staff['image']);
            }
            $image = $upload['path'];
        }
    }
    
    $sql = "UPDATE staffs SET 
            name_bn = '$name_bn', name_en = '$name_en', designation_bn = '$designation_bn',
            designation_en = '$designation_en', department = '$department', image = '$image',
            email = '$email', phone = '$phone', facebook = '$facebook', linkedin = '$linkedin',
            twitter = '$twitter', bio = '$bio', joining_date = '$joining_date',
            sort_order = $sort_order, status = '$status', updated_at = NOW()
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'স্টাফ আপডেট হয়েছে';
        header('Location: index.php');
        exit();
    } else {
        $error = 'ত্রুটি: ' . $conn->error;
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">স্টাফ সম্পাদনা</h2>
    <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded"><i class="fas fa-arrow-left"></i> ফিরে যান</a>
</div>

<?php if ($error): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div><label class="block font-semibold mb-2">নাম (বাংলা) *</label><input type="text" name="name_bn" value="<?php echo $staff['name_bn']; ?>" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">নাম (ইংরেজি)</label><input type="text" name="name_en" value="<?php echo $staff['name_en']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">পদবি (বাংলা) *</label><input type="text" name="designation_bn" value="<?php echo $staff['designation_bn']; ?>" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">পদবি (ইংরেজি)</label><input type="text" name="designation_en" value="<?php echo $staff['designation_en']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">বিভাগ</label><select name="department" class="w-full px-3 py-2 border rounded"><option value="Editorial" <?php echo $staff['department'] == 'Editorial' ? 'selected' : ''; ?>>সম্পাদকীয় বিভাগ</option><option value="News" <?php echo $staff['department'] == 'News' ? 'selected' : ''; ?>>সংবাদ বিভাগ</option><option value="Crime" <?php echo $staff['department'] == 'Crime' ? 'selected' : ''; ?>>ক্রাইম বিভাগ</option><option value="Sports" <?php echo $staff['department'] == 'Sports' ? 'selected' : ''; ?>>খেলাধুলা বিভাগ</option><option value="Photography" <?php echo $staff['department'] == 'Photography' ? 'selected' : ''; ?>>ফটোগ্রাফি বিভাগ</option><option value="Digital" <?php echo $staff['department'] == 'Digital' ? 'selected' : ''; ?>>ডিজিটাল বিভাগ</option><option value="Video" <?php echo $staff['department'] == 'Video' ? 'selected' : ''; ?>>ভিডিও বিভাগ</option><option value="Marketing" <?php echo $staff['department'] == 'Marketing' ? 'selected' : ''; ?>>মার্কেটিং বিভাগ</option></select></div>
        <div><label class="block font-semibold mb-2">সর্ডার অর্ডার</label><input type="number" name="sort_order" value="<?php echo $staff['sort_order']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">ইমেইল</label><input type="email" name="email" value="<?php echo $staff['email']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">ফোন</label><input type="text" name="phone" value="<?php echo $staff['phone']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">যোগদানের তারিখ</label><input type="date" name="joining_date" value="<?php echo $staff['joining_date']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">স্ট্যাটাস</label><select name="status" class="w-full px-3 py-2 border rounded"><option value="active" <?php echo $staff['status'] == 'active' ? 'selected' : ''; ?>>সক্রিয়</option><option value="inactive" <?php echo $staff['status'] == 'inactive' ? 'selected' : ''; ?>>নিষ্ক্রিয়</option></select></div>
        <div><label class="block font-semibold mb-2">প্রোফাইল ছবি</label><?php if(!empty($staff['image'])): ?><div class="mb-2"><img src="<?php echo $staff['image']; ?>" class="h-16 w-16 object-cover rounded"></div><?php endif; ?><input type="file" name="image" accept="image/*" class="w-full"></div>
        <div><label class="block font-semibold mb-2">ফেসবুক</label><input type="url" name="facebook" value="<?php echo $staff['facebook']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">লিংকডইন</label><input type="url" name="linkedin" value="<?php echo $staff['linkedin']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block font-semibold mb-2">টুইটার</label><input type="url" name="twitter" value="<?php echo $staff['twitter']; ?>" class="w-full px-3 py-2 border rounded"></div>
        <div class="md:col-span-2"><label class="block font-semibold mb-2">বায়ো</label><textarea name="bio" rows="3" class="w-full px-3 py-2 border rounded"><?php echo $staff['bio']; ?></textarea></div>
    </div>
    <div class="mt-6 flex justify-end gap-2"><a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded">বাতিল</a><button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">আপডেট করুন</button></div>
</form>

<?php require_once '../includes/footer.php'; ?>