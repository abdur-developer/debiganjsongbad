<?php
$newsId = isset($_GET['card_id']) ? intval($_GET['card_id']) : 0;
$newsData = null;

if ($newsId > 0) {
    $sql = "SELECT n.*, c.name_bn as category_name, u.full_name as author_name 
            FROM news n 
            LEFT JOIN categories c ON n.category_id = c.id 
            LEFT JOIN users u ON n.author_id = u.id 
            WHERE n.id = $newsId AND n.status = 'published'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $newsData = $result->fetch_assoc();
    }
}

// ফ্রেম পাথ
$framePath = 'news/frame.jpeg';
$frameExists = file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $framePath);
?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- HTML2Canvas -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
    
    /* মেইন গ্রিড */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    @media (max-width: 968px) {
        .main-grid {
            grid-template-columns: 1fr;
        }
        body {
            padding: 12px;
        }
    }
    
    /* কার্ড স্টাইল */
    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 16px 24px;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .hidden {
        display: none !important;
    }
    .section-header i {
        font-size: 24px;
    }
    
    .section-header h2 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }
    
    /* প্রিভিউ কন্টেইনার */
    .preview-container {
        padding: 30px;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .preview-wrapper {
        position: relative;
        display: inline-block;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        border-radius: 16px;
        overflow: hidden;
        background: white;
    }
    
    #cardContent {
        position: relative;
        width: 500px;
        height: 500px;
        background: white;
    }
    
    .user-image {
        display: block;
        width: 100%;
        height: auto;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .frame-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        pointer-events: none;
    }
    
    /* প্রিভিউ কন্ট্রোল */
    .preview-controls {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    
    .btn-success:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
    }
    
    .btn-outline {
        background: white;
        border: 2px solid #667eea;
        color: #667eea;
    }
    
    .btn-outline:hover {
        background: #667eea;
        color: white;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* কন্ট্রোল গ্রিড */
    .controls-grid {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .control-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .control-group label {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .control-group label i {
        color: #667eea;
        width: 20px;
    }
    
    input, textarea {
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
        font-family: inherit;
    }
    
    input:focus, textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    textarea {
        resize: vertical;
        min-height: 80px;
    }
    
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    
    .file-input-btn {
        background: #f0f0f0;
        padding: 12px 20px;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px dashed #ccc;
    }
    
    .file-input-btn:hover {
        background: #e0e0e0;
        border-color: #667eea;
    }
    
    /* লোডিং ওভারলে */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .loading-content {
        background: white;
        padding: 40px;
        border-radius: 24px;
        text-align: center;
        max-width: 350px;
    }
    
    .spinner-circle {
        width: 60px;
        height: 60px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .loading-progress {
        margin-top: 20px;
        height: 4px;
        background: #e0e0e0;
        border-radius: 2px;
        overflow: hidden;
    }
    
    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        width: 0%;
        transition: width 0.3s;
        animation: progress 2s ease infinite;
    }
    
    @keyframes progress {
        0% { width: 0%; }
        50% { width: 70%; }
        100% { width: 100%; }
    }
</style>

<!-- Main Content -->
<main class="main-grid">
    <!-- Left Column: Preview & Controls -->
    <div class="left-column">
        <!-- Preview Section -->
        <section class="card preview-section">
            <div class="section-header">
                <i class="fas fa-eye"></i>
                <h2>লাইভ প্রিভিউ</h2>
            </div>
            
            <div class="preview-container">
                <div class="preview-wrapper">
                    <!-- কার্ড কন্টেন্ট - এটাই ডাউনলোড হবে -->
                    <div id="cardContent">
                        <!-- ফ্রেম ওভারলে (একটি মাত্র ফ্রেম) -->
                        <img id="frameOverlay" class="frame-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;" src="<?php echo $framePath; ?>">
                        
                        <!-- ফিচার ইমেজ -->
                        <img id="userImage" class="user-image" style="width: 100%; display: block;" src="">
                        
                        <!-- টাইটেল ওভারলে -->
                        <div id="titleOverlay" style="position: absolute; bottom: 70px; left: 0; right: 0; text-align: center; padding: 15px;">
                            <h2 id="cardTitle" style="font-size: 20px; font-weight: bold; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); line-height: 1.3;"></h2>
                        </div>
                        
                        <!-- তারিখ ওভারলে -->
                        <div id="dateOverlay" style="position: absolute; bottom: 20px; right: 20px; background: rgba(0,0,0,0.7); padding: 6px 14px; border-radius: 25px; color: white; font-size: 12px;">
                            <i class="far fa-calendar-alt"></i> <span id="cardDate"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Controls -->
                <div class="preview-controls">
                    <button id="downloadBtn" class="btn btn-success">
                        <i class="fas fa-download"></i> HD ডাউনলোড
                    </button>
                    
                    <button id="resetBtn" class="btn btn-outline">
                        <i class="fas fa-redo"></i> রিসেট
                    </button>
                </div>
            </div>
        </section>
    </div>
    
    <div class="right-column">
        <!-- Editing Controls -->
        <section class="card controls-section">
            <div class="section-header">
                <i class="fas fa-sliders-h"></i>
                <h2>ফটো কার্ড এডিট করুন</h2>
            </div>
            
            <div class="controls-grid">
                <!-- ফিচার ইমেজ আপলোড -->
                <div class="control-group">
                    <label><i class="fas fa-image"></i> ফিচার ছবি</label>
                    <div class="file-input-wrapper">
                        <div class="file-input-btn" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-upload"></i> ছবি পরিবর্তন করুন
                        </div>
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                    </div>
                    <div id="imagePreview" style="margin-top: 10px;"></div>
                </div>
                
                <!-- টাইটেল -->
                <div class="control-group">
                    <label><i class="fas fa-heading"></i> শিরোনাম / টাইটেল</label>
                    <textarea id="titleInput" rows="3" placeholder="এখানে আপনার টাইটেল লিখুন..."><?php echo htmlspecialchars($newsData['title_bn'] ?? ''); ?></textarea>
                </div>
                
                <!-- তারিখ -->
                <div class="control-group">
                    <label><i class="fas fa-calendar-alt"></i> তারিখ</label>
                    <input type="date" id="dateInput" value="<?php echo $newsData ? date('Y-m-d', strtotime($newsData['created_at'])) : date('Y-m-d'); ?>">
                </div>
                
            </div>
        </section>
    </div>
</main>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay hidden">
    <div class="loading-content">
        <div class="spinner-circle"></div>
        <h3>ছবি তৈরি হচ্ছে...</h3>
        <p>অনুগ্রহ করে কিছুক্ষণ অপেক্ষা করুন</p>
        <div class="loading-progress">
            <div class="progress-bar"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        toastr.options = {
            positionClass: "toast-top-right",
            timeOut: "3000",
            closeButton: true,
            progressBar: true
        };

        const newsData = <?php echo json_encode($newsData ?? null); ?>;
        const newsId = <?php echo $newsId ?? 0; ?>;

        const imageInput = document.getElementById('imageInput');
        const titleInput = document.getElementById('titleInput');
        const dateInput = document.getElementById('dateInput');
        const userImage = document.getElementById('userImage');
        const cardTitle = document.getElementById('cardTitle');
        const cardDate = document.getElementById('cardDate');
        const downloadBtn = document.getElementById('downloadBtn');
        const resetBtn = document.getElementById('resetBtn');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const imagePreview = document.getElementById('imagePreview');
        const manualNewsId = document.getElementById('manualNewsId');
        const goToNews = document.getElementById('goToNews');

        let isImageLoaded = false;

        // ================= IMAGE LOAD =================
        function loadNewsImage() {
            if (newsData && newsData.featured_image) {

                let imgUrl = newsData.featured_image;

                if (!imgUrl.startsWith('http') && !imgUrl.startsWith('/')) {
                    imgUrl = '/' + imgUrl;
                }

                userImage.crossOrigin = "anonymous";

                let triedFallback = false; // 🔥 prevent loop

                userImage.onload = function () {
                    isImageLoaded = true;
                    updatePreview();
                };

                userImage.onerror = function () {

                    if (triedFallback) return; // 🔥 stop infinite loop
                    triedFallback = true;

                    isImageLoaded = true;

                    // fallback image (CORS safe)
                    userImage.removeAttribute("crossOrigin");
                    userImage.src = 'https://via.placeholder.com/500x400?text=No+Image';

                    toastr.warning('ফিচার ছবি পাওয়া যায়নি');
                };

                userImage.src = imgUrl;

            } else {
                fallbackImage();
            }
        }

        function fallbackImage() {
            userImage.src = 'https://debiganjsongbad.com/assets/img/logo.png';
            isImageLoaded = true;
            updatePreview();
        }

        // ================= PREVIEW =================
        function updatePreview() {

            let title = titleInput.value.trim();
            if (!title) title = 'আপনার টাইটেল এখানে';

            cardTitle.innerText = title;

            if (dateInput.value) {
                const date = new Date(dateInput.value);
                const months = ['জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];

                cardDate.innerText =
                    date.getDate() + ' ' +
                    months[date.getMonth()] + ' ' +
                    date.getFullYear();
            }
        }

        // ================= IMAGE PREVIEW =================
        function showImagePreview(file) {

            const reader = new FileReader();

            reader.onload = function(e) {
                userImage.src = e.target.result;
                isImageLoaded = true;
                updatePreview();

                imagePreview.innerHTML =
                    `<img src="${e.target.result}" style="max-width:80px;border-radius:10px;">`;

                toastr.success('ছবি পরিবর্তন হয়েছে!');
            };

            reader.readAsDataURL(file);
        }

        // ================= RESET =================
        function resetToNews() {

            if (newsData) {
                titleInput.value = newsData.title_bn || '';
                dateInput.value = newsData.created_at
                    ? newsData.created_at.split(' ')[0]
                    : '<?php echo date('Y-m-d'); ?>';

                loadNewsImage();
                imagePreview.innerHTML = '';

                toastr.success('রিসেট সম্পন্ন');
            } else {
                titleInput.value = '';
                dateInput.value = '<?php echo date('Y-m-d'); ?>';

                fallbackImage();
                imagePreview.innerHTML = '';

                toastr.info('সব রিসেট হয়েছে');
            }

            updatePreview();
        }

        // ================= DOWNLOAD =================
        async function downloadCard() {

            if (!isImageLoaded) {
                toastr.warning('প্রথমে ছবি দিন');
                return;
            }

            loadingOverlay.classList.remove('hidden');

            try {
                const card = document.getElementById('cardContent');

                const originalWidth = card.style.width;
                card.style.width = "1000px";

                const canvas = await html2canvas(card, {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: "#fff"
                });

                const link = document.createElement('a');

                const time = new Date().toISOString().replace(/[:.]/g,'-');

                link.download = `news-card-${newsId || 'custom'}-${time}.png`;
                link.href = canvas.toDataURL("image/png");
                link.click();

                card.style.width = originalWidth;

                toastr.success('ডাউনলোড শুরু হয়েছে');

            } catch (e) {
                console.error(e);
                toastr.error('ডাউনলোড ব্যর্থ');
            } finally {
                setTimeout(() => {
                    loadingOverlay.classList.add('hidden');
                }, 500);
            }
        }

        // ================= EVENTS =================

        imageInput.addEventListener('change', function(e) {

            const file = e.target.files[0];

            if (!file) return;

            if (!file.type.startsWith('image/')) {
                toastr.error('ইমেজ ফাইল দিন');
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                toastr.error('৫MB এর কম হতে হবে');
                return;
            }

            showImagePreview(file);
        });

        titleInput.addEventListener('input', updatePreview);
        dateInput.addEventListener('change', updatePreview);

        downloadBtn.addEventListener('click', downloadCard);
        resetBtn.addEventListener('click', resetToNews);

        if (goToNews) {
            goToNews.addEventListener('click', function() {
                const id = manualNewsId.value.trim();
                if (id && !isNaN(id)) {
                    window.location.href = `?q=news&card_id=${id}`;
                } else {
                    toastr.error('সঠিক আইডি দিন');
                }
            });
        }

        // ================= INIT =================
        loadNewsImage();
        updatePreview();

    });
</script>