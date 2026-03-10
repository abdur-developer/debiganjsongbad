<?php
// admin/gallery/upload.php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$auth->requirePermission('gallery');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title_bn = $conn->real_escape_string($_POST['title_bn']);
    $title_en = $conn->real_escape_string($_POST['title_en']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);
    $status = $conn->real_escape_string($_POST['status']);
    
    if (empty($title_bn)) {
        $error = 'ছবির শিরোনাম (বাংলা) প্রয়োজন';
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        $error = 'ছবি আপলোড প্রয়োজন';
    } else {
        $upload = $functions->uploadFile($_FILES['image'], 'gallery', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        
        if ($upload['success']) {
            $image_path = $upload['path'];
            $uploaded_by = $_SESSION['user_id'];
            
            $sql = "INSERT INTO gallery (title_bn, title_en, description, category, image, uploaded_by, status, created_at) 
                    VALUES ('$title_bn', '$title_en', '$description', '$category', '$image_path', $uploaded_by, '$status', NOW())";
            
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'ছবি আপলোড হয়েছে';
                header('Location: index.php');
                exit();
            } else {
                $error = 'ডাটাবেজ ত্রুটি: ' . $conn->error;
            }
        } else {
            $error = $upload['error'];
        }
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">নতুন ছবি আপলোড</h2>
    <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        <i class="fas fa-arrow-left"></i> ফিরে যান
    </a>
</div>

<?php if ($error): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-2">শিরোনাম (বাংলা) *</label>
                <input type="text" name="title_bn" value="<?php echo htmlspecialchars($_POST['title_bn'] ?? ''); ?>" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">শিরোনাম (ইংরেজি)</label>
                <input type="text" name="title_en" value="<?php echo htmlspecialchars($_POST['title_en'] ?? ''); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">ক্যাটাগরি</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($_POST['category'] ?? ''); ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-red-500"
                       placeholder="যেমন: রাজনীতি, খেলা, বিনোদন">
            </div>
            
            <div>
                <label class="block font-semibold mb-2">স্ট্যাটাস</label>
                <select name="status" class="w-full px-3 py-2 border rounded">
                    <option value="active">সক্রিয়</option>
                    <option value="inactive">নিষ্ক্রিয়</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">ছবি নির্বাচন *</label>
                <div id="drop-zone" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-red-500 transition cursor-pointer">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-600">ছবি এখানে Drag & Drop করুন অথবা ক্লিক করে নির্বাচন করুন</p>
                    <p class="text-xs text-gray-500 mt-2">সাপোর্টেড: JPG, PNG, GIF, WEBP (সর্বোচ্চ 5MB)</p>
                    <input type="file" name="image" id="file-input" accept="image/*" class="hidden" required>
                </div>
                
                <div id="image-preview" class="mt-4 hidden">
                    <img id="preview" src="" class="max-h-64 mx-auto rounded-lg shadow" alt="preview">
                </div>
            </div>
            
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">বিবরণ</label>
                <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end gap-2">
            <button type="reset" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                রিসেট
            </button>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                আপলোড করুন
            </button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    // Drag & Drop
    const dropZone = $('#drop-zone');
    const fileInput = $('#file-input');
    
    dropZone.on('click', function() {
        fileInput.click();
    });
    
    dropZone.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('border-red-500 bg-red-50');
    });
    
    dropZone.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('border-red-500 bg-red-50');
    });
    
    dropZone.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('border-red-500 bg-red-50');
        
        const files = e.originalEvent.dataTransfer.files;
        fileInput.prop('files', files);
        showPreview(files[0]);
    });
    
    fileInput.on('change', function() {
        if (this.files && this.files[0]) {
            showPreview(this.files[0]);
        }
    });
    
    function showPreview(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#image-preview').removeClass('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>