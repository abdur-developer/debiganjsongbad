
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- HTML2Canvas -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap');
        
        
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
        
        .user-image {
            display: block;
            width: 100%;
            height: auto;
            min-width: 300px;
            max-width: 500px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .user-image:hover {
            transform: scale(1.02);
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
        
        input, textarea, select {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        input:focus, textarea:focus, select:focus {
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
        
        .file-input-wrapper input {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
            cursor: pointer;
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
        
        /* ফ্রেম সিলেক্টর */
        .frame-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 8px;
        }
        
        .frame-option {
            border: 3px solid #e0e0e0;
            border-radius: 12px;
            padding: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .frame-option:hover {
            border-color: #667eea;
            transform: scale(1.05);
        }
        
        .frame-option.active {
            border-color: #667eea;
            background: #f0e6ff;
        }
        
        .frame-option img {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 5px;
        }
        
        .frame-option span {
            font-size: 11px;
            color: #666;
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
        
        .spinner {
            margin-bottom: 20px;
        }
        
        .spinner-circle {
            width: 60px;
            height: 60px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
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
        /* টোস্ট স্টাইল */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
        }
        
        /* ইনফো বার */
        .info-bar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 24px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-item i {
            font-size: 20px;
        }
        
        .info-item span {
            font-size: 13px;
            opacity: 0.9;
        }
        
        /* ইমেজ প্রিভিউ */
        .image-preview {
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }
        
        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="info-bar">
    <div class="info-item">
        <i class="fas fa-info-circle"></i>
        <span>আপনার ছবি, টাইটেল ও তারিখ যোগ করে সুন্দর ফটো কার্ড তৈরি করুন</span>
    </div>
    <div class="info-item">
        <i class="fas fa-download"></i>
        <span>HD কোয়ালিটিতে ডাউনলোড করুন</span>
    </div>
</div>

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
                <div class="preview-wrapper" id="previewWrapper">
                    <!-- কার্ড কন্টেন্ট - এটাই ডাউনলোড হবে -->
                    <div id="cardContent" style="position: relative; width: 500px; background: white;">
                        <!-- ফিচার ইমেজ -->
                        <img id="userImage" class="user-image" style="width: 100%; display: block;" src="https://via.placeholder.com/500x400?text=ছবি+সিলেক্ট+করুন">
                        
                        <!-- ফ্রেম ওভারলে -->
                        <img id="frameOverlay" class="frame-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;" src="">
                        
                        <!-- টাইটেল ওভারলে -->
                        <div id="titleOverlay" style="position: absolute; bottom: 70px; left: 0; right: 0; text-align: center; padding: 15px; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white;">
                            <h2 id="cardTitle" style="font-size: 20px; font-weight: bold; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">আপনার টাইটেল এখানে</h2>
                        </div>
                        
                        <!-- তারিখ ওভারলে -->
                        <div id="dateOverlay" style="position: absolute; bottom: 20px; right: 20px; background: rgba(0,0,0,0.6); padding: 5px 12px; border-radius: 20px; color: white; font-size: 12px;">
                            <i class="far fa-calendar-alt"></i> <span id="cardDate"><?php echo date('d F Y'); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Controls -->
                <div class="preview-controls">
                    <button id="downloadBtn" class="btn btn-success" disabled>
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
                            <i class="fas fa-upload"></i> ছবি আপলোড করুন
                        </div>
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                    </div>
                    <div class="image-preview" id="imagePreview"></div>
                </div>
                
                <!-- টাইটেল -->
                <div class="control-group">
                    <label><i class="fas fa-heading"></i> শিরোনাম / টাইটেল</label>
                    <textarea id="titleInput" rows="2" placeholder="এখানে আপনার টাইটেল লিখুন..."></textarea>
                </div>
                
                <!-- তারিখ -->
                <div class="control-group">
                    <label><i class="fas fa-calendar-alt"></i> তারিখ</label>
                    <input type="date" id="dateInput" value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <!-- ফ্রেম সিলেক্টর -->
                <div class="control-group">
                    <label><i class="fas fa-border-all"></i> ফ্রেম নির্বাচন করুন</label>
                    <div class="frame-selector" id="frameSelector">
                        <div class="frame-option" data-frame="">
                            <img src="https://via.placeholder.com/100x60?text=No+Frame" alt="No Frame">
                            <span>কোন ফ্রেম নেই</span>
                        </div>
                        <div class="frame-option" data-frame="https://www.transparenttextures.com/patterns/cardboard.png">
                            <img src="https://www.transparenttextures.com/patterns/cardboard.png" alt="Frame 1">
                            <span>ক্লাসিক ফ্রেম</span>
                        </div>
                        <div class="frame-option" data-frame="https://www.transparenttextures.com/patterns/wood-pattern.png">
                            <img src="https://www.transparenttextures.com/patterns/wood-pattern.png" alt="Frame 2">
                            <span>উড ফ্রেম</span>
                        </div>
                        <div class="frame-option" data-frame="https://www.transparenttextures.com/patterns/gold.png">
                            <img src="https://www.transparenttextures.com/patterns/gold.png" alt="Frame 3">
                            <span>গোল্ড ফ্রেম</span>
                        </div>
                        <div class="frame-option" data-frame="https://www.transparenttextures.com/patterns/45-degree-fabric-dark.png">
                            <img src="https://www.transparenttextures.com/patterns/45-degree-fabric-dark.png" alt="Frame 4">
                            <span>ডার্ক ফ্রেম</span>
                        </div>
                        <div class="frame-option" data-frame="https://www.transparenttextures.com/patterns/diagmonds.png">
                            <img src="https://www.transparenttextures.com/patterns/diagmonds.png" alt="Frame 5">
                            <span>ডায়মন্ড ফ্রেম</span>
                        </div>
                    </div>
                </div>
                
                <div class="control-group">
                    <div class="file-input-wrapper">
                        <div class="file-input-btn" onclick="document.getElementById('customFrameInput').click()">
                            <i class="fas fa-plus-circle"></i> কাস্টম ফ্রেম আপলোড
                        </div>
                        <input type="file" id="customFrameInput" accept="image/*" style="display: none;">
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay hidden">
    <div class="loading-content">
        <div class="spinner">
            <div class="spinner-circle"></div>
        </div>
        <h3>ছবি তৈরি হচ্ছে...</h3>
        <p>অনুগ্রহ করে কিছুক্ষণ অপেক্ষা করুন</p>
        <div class="loading-progress">
            <div class="progress-bar"></div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="toast-container"></div>

<script>
$(document).ready(function() {
    // টোস্ট কনফিগারেশন
    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": "3000",
        "closeButton": true,
        "progressBar": true
    };
    
    // ডোম এলিমেন্টস
    const imageInput = document.getElementById('imageInput');
    const customFrameInput = document.getElementById('customFrameInput');
    const titleInput = document.getElementById('titleInput');
    const dateInput = document.getElementById('dateInput');
    const userImage = document.getElementById('userImage');
    const frameOverlay = document.getElementById('frameOverlay');
    const cardTitle = document.getElementById('cardTitle');
    const cardDate = document.getElementById('cardDate');
    const downloadBtn = document.getElementById('downloadBtn');
    const resetBtn = document.getElementById('resetBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const imagePreview = document.getElementById('imagePreview');
    
    let currentImageFile = null;
    let currentFrameSrc = '';
    let isImageLoaded = false;
    
    // ==================== ফাংশন ====================
    
    // প্রিভিউ আপডেট
    function updatePreview() {
        // টাইটেল আপডেট
        let title = titleInput.value.trim();
        if (title === '') {
            title = 'আপনার টাইটেল এখানে';
        }
        cardTitle.innerText = title;
        
        // তারিখ আপডেট
        if (dateInput.value) {
            const date = new Date(dateInput.value);
            const months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
            cardDate.innerText = `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }
        
        // ডাউনলোড বাটন এনাবল/ডিজেবল
        downloadBtn.disabled = !isImageLoaded;
    }
    
    // ইমেজ প্রিভিউ দেখান
    function showImagePreview(file) {
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                userImage.src = e.target.result;
                userImage.style.display = 'block';
                isImageLoaded = true;
                updatePreview();
                
                // প্রিভিউ থাম্বনেইল
                imagePreview.innerHTML = `<img src="${e.target.result}" style="max-width: 80px; max-height: 80px; border-radius: 10px;">`;
                
                toastr.success('ছবি আপলোড সফল হয়েছে!');
            };
            reader.readAsDataURL(file);
        }
    }
    
    // ফ্রেম সেট
    function setFrame(src) {
        currentFrameSrc = src;
        if (src) {
            frameOverlay.src = src;
            frameOverlay.style.display = 'block';
        } else {
            frameOverlay.style.display = 'none';
        }
        toastr.info('ফ্রেম পরিবর্তন করা হয়েছে');
    }
    
    // রিসেট
    function resetAll() {
        titleInput.value = '';
        dateInput.value = '<?php echo date('Y-m-d'); ?>';
        userImage.src = 'https://via.placeholder.com/500x400?text=ছবি+সিলেক্ট+করুন';
        userImage.style.display = 'block';
        frameOverlay.style.display = 'none';
        currentFrameSrc = '';
        isImageLoaded = false;
        currentImageFile = null;
        imagePreview.innerHTML = '';
        
        // ফ্রেম অ্যাক্টিভ ক্লাস রিমুভ
        $('.frame-option').removeClass('active');
        $('.frame-option[data-frame=""]').addClass('active');
        
        updatePreview();
        toastr.info('সব কিছু রিসেট করা হয়েছে');
    }
    
    // ডাউনলোড ফাংশন
    async function downloadCard() {
        if (!isImageLoaded) {
            toastr.warning('দয়া করে প্রথমে একটি ছবি আপলোড করুন!');
            return;
        }
        
        loadingOverlay.classList.remove('hidden');
        
        try {
            const cardElement = document.getElementById('cardContent');
            const originalWidth = cardElement.style.width;
            
            // হাই রেজুলেশনের জন্য সাইজ বাড়ানো
            cardElement.style.width = '1000px';
            
            // Canvas তৈরি
            const canvas = await html2canvas(cardElement, {
                scale: 2,
                backgroundColor: '#ffffff',
                useCORS: true,
                logging: false,
                allowTaint: false
            });
            
            // ডাউনলোড লিংক তৈরি
            const link = document.createElement('a');
            const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
            link.download = `photo-card-${timestamp}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            // সাইজ রিস্টোর
            cardElement.style.width = originalWidth;
            
            toastr.success('ছবি ডাউনলোড শুরু হয়েছে!');
            
        } catch (error) {
            console.error('Error:', error);
            toastr.error('ছবি তৈরি করতে সমস্যা হয়েছে!');
        } finally {
            setTimeout(() => {
                loadingOverlay.classList.add('hidden');
            }, 500);
        }
    }
    
    // ==================== ইভেন্ট লিসেনার ====================
    
    // ইমেজ আপলোড
    imageInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            if (!file.type.startsWith('image/')) {
                toastr.error('দয়া করে একটি বৈধ ছবি ফাইল নির্বাচন করুন!');
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                toastr.error('ছবির সাইজ ৫MB এর কম হতে হবে!');
                return;
            }
            currentImageFile = file;
            showImagePreview(file);
        }
    });
    
    // কাস্টম ফ্রেম আপলোড
    customFrameInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    setFrame(ev.target.result);
                    // কাস্টম ফ্রেম অ্যাক্টিভ দেখানোর জন্য
                    $('.frame-option').removeClass('active');
                };
                reader.readAsDataURL(file);
                toastr.success('কাস্টম ফ্রেম আপলোড হয়েছে!');
            } else {
                toastr.error('দয়া করে একটি ছবি ফাইল নির্বাচন করুন!');
            }
        }
    });
    
    // ফ্রেম সিলেক্টর
    $('.frame-option').click(function() {
        const frameSrc = $(this).data('frame');
        setFrame(frameSrc);
        $('.frame-option').removeClass('active');
        $(this).addClass('active');
    });
    
    // টাইটেল ইনপুট
    titleInput.addEventListener('input', updatePreview);
    
    // তারিখ ইনপুট
    dateInput.addEventListener('change', updatePreview);
    
    // ডাউনলোড বাটন
    downloadBtn.addEventListener('click', downloadCard);
    
    // রিসেট বাটন
    resetBtn.addEventListener('click', resetAll);
    
    // ড্র্যাগ এন্ড ড্রপ সাপোর্ট
    const previewWrapper = document.getElementById('previewWrapper');
    
    previewWrapper.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.opacity = '0.8';
    });
    
    previewWrapper.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.opacity = '1';
    });
    
    previewWrapper.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.opacity = '1';
        
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            imageInput.files = files;
            const event = new Event('change');
            imageInput.dispatchEvent(event);
        }
    });
    
    // ইনিশিয়াল প্রিভিউ
    updatePreview();
    
    // প্রথম ফ্রেম অ্যাক্টিভ
    $('.frame-option[data-frame=""]').addClass('active');
    
    toastr.info('স্বাগতম! আপনার ফটো কার্ড তৈরি করুন');
});
</script>