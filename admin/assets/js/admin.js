// admin/assets/js/admin.js

$(document).ready(function() {
    // ==================== টুলটিপ ====================
    $('[data-toggle="tooltip"]').tooltip();
    
    // ==================== কনফার্ম ডিলিট ====================
    $('.delete-confirm').click(function(e) {
        e.preventDefault();
        if (confirm('আপনি কি নিশ্চিত? এই কাজটি পূর্বাবস্থায় ফেরানো যাবে না।')) {
            window.location.href = $(this).attr('href');
        }
    });
    
    // ==================== সিলেক্ট2 ইনিশিয়ালাইজ ====================
    $('.select2').select2({
        width: '100%',
        placeholder: 'সিলেক্ট করুন',
        allowClear: true
    });
    
    // ==================== ডেটপিকার ====================
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'bn'
    });
    
    // ==================== টাইমপিকার ====================
    $('.timepicker').timepicker({
        showMeridian: false,
        defaultTime: 'current',
        minuteStep: 5
    });
    
    // ==================== ইমেজ প্রিভিউ ====================
    $('.image-input').change(function() {
        const input = this;
        const preview = $(this).data('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $(preview).attr('src', e.target.result).show();
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    });
    
    // ==================== একাধিক ইমেজ প্রিভিউ ====================
    $('.multiple-image-input').change(function() {
        const files = this.files;
        const previewContainer = $(this).data('preview-container');
        
        $(previewContainer).empty();
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    $(previewContainer).append(`
                        <div class="relative inline-block m-2 group">
                            <img src="${e.target.result}" class="h-20 w-20 object-cover rounded-lg border-2 border-gray-300">
                            <button type="button" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 text-xs hover:bg-red-700 remove-preview">×</button>
                        </div>
                    `);
                }
                
                reader.readAsDataURL(file);
            }
        }
    });
    
    // ==================== প্রিভিউ ইমেজ রিমুভ ====================
    $(document).on('click', '.remove-preview', function() {
        $(this).closest('div').remove();
    });
    
    // ==================== অটো সেভ (খসড়া) ====================
    let autoSaveTimer;
    $('.auto-save').on('input', function() {
        clearTimeout(autoSaveTimer);
        $('#auto-save-indicator').text('সেভ হচ্ছে...').removeClass('hidden');
        
        autoSaveTimer = setTimeout(function() {
            const formData = $('form').serialize();
            
            $.ajax({
                url: 'ajax/auto-save.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#auto-save-indicator').html('<i class="fas fa-check-circle text-green-600"></i> খসড়া সেভ হয়েছে').fadeOut(3000);
                    } else {
                        $('#auto-save-indicator').html('<i class="fas fa-exclamation-circle text-red-600"></i> সেভ ব্যর্থ').fadeOut(3000);
                    }
                },
                error: function() {
                    $('#auto-save-indicator').html('<i class="fas fa-exclamation-circle text-red-600"></i> সংযোগ সমস্যা').fadeOut(3000);
                }
            });
        }, 3000);
    });
    
    // ==================== ট্যাগ ইনপুট ====================
    if ($('.tag-input').length) {
        $('.tag-input').tagsInput({
            'width': '100%',
            'height': 'auto',
            'defaultText': 'ট্যাগ যোগ করুন',
            'removeWithBackspace': true,
            'delimiter': [',', ';'],
            'placeholderColor': '#666666'
        });
    }
    
    // ==================== চার্ট ইনিশিয়ালাইজ ====================
    if ($('#news-chart').length) {
        const ctx = document.getElementById('news-chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['সোম', 'মঙ্গল', 'বুধ', 'বৃহস্পতি', 'শুক্র', 'শনি', 'রবি'],
                datasets: [{
                    label: 'সংবাদ প্রকাশ',
                    data: [12, 19, 15, 17, 14, 13, 15],
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    }
    
    // ==================== ক্যাটাগরি চার্ট ====================
    if ($('#category-chart').length) {
        const ctx = document.getElementById('category-chart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['জাতীয়', 'আন্তর্জাতিক', 'খেলাধুলা', 'বিনোদন', 'অন্যান্য'],
                datasets: [{
                    data: [45, 25, 15, 10, 5],
                    backgroundColor: [
                        '#dc2626',
                        '#2563eb',
                        '#16a34a',
                        '#9333ea',
                        '#6b7280'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    // ==================== নোটিফিকেশন ফাংশন ====================
    window.showNotification = function(message, type = 'success') {
        const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
                        type === 'error' ? 'bg-red-100 border-red-400 text-red-700' :
                        'bg-blue-100 border-blue-400 text-blue-700';
        
        const icon = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-circle' : 'info-circle';
        
        const notification = `
            <div class="fixed top-4 right-4 z-50 notification animate-fade-in">
                <div class="${bgColor} border px-4 py-3 rounded-lg shadow-lg flex items-center">
                    <i class="fas fa-${icon} mr-2"></i>
                    <span>${message}</span>
                </div>
            </div>
        `;
        
        $('body').append(notification);
        
        setTimeout(function() {
            $('.notification').fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    };
    
    // ==================== কীবোর্ড শর্টকাট ====================
    $(document).keydown(function(e) {
        // Ctrl + S - সেভ
        if (e.ctrlKey && e.keyCode == 83) {
            e.preventDefault();
            $('form[data-shortcut="save"]').submit();
        }
        
        // Ctrl + N - নতুন
        if (e.ctrlKey && e.keyCode == 78) {
            e.preventDefault();
            window.location.href = 'create.php';
        }
        
        // Ctrl + D - ডিলিট
        if (e.ctrlKey && e.keyCode == 68) {
            e.preventDefault();
            $('.delete-btn:first').click();
        }
        
        // Esc - মোডাল বন্ধ
        if (e.keyCode == 27) {
            $('.modal').fadeOut();
            $('.modal-overlay').fadeOut();
        }
        
        // / - সার্চ ফোকাস
        if (e.keyCode == 191 && !e.ctrlKey && !e.altKey) {
            e.preventDefault();
            $('#search-input').focus();
        }
    });
    
    // ==================== ইনফিনিট স্ক্রল ====================
    if ($('#infinite-scroll').length) {
        let page = 1;
        let loading = false;
        let hasMore = true;
        
        $(window).scroll(function() {
            if (!hasMore || loading) return;
            
            if ($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
                loading = true;
                page++;
                
                $('#loading-spinner').removeClass('hidden');
                
                $.ajax({
                    url: 'ajax/load-more.php',
                    method: 'GET',
                    data: { page: page },
                    dataType: 'json',
                    success: function(response) {
                        if (response.html) {
                            $('#infinite-scroll').append(response.html);
                        }
                        
                        if (!response.hasMore) {
                            hasMore = false;
                            $('#no-more-data').removeClass('hidden');
                        }
                        
                        loading = false;
                        $('#loading-spinner').addClass('hidden');
                    },
                    error: function() {
                        loading = false;
                        $('#loading-spinner').addClass('hidden');
                        showNotification('ডাটা লোড করতে সমস্যা হয়েছে', 'error');
                    }
                });
            }
        });
    }
    
    // ==================== ব্যাচ অ্যাকশন ====================
    $('#select-all').click(function() {
        $('.select-item').prop('checked', $(this).prop('checked'));
        updateBatchButton();
    });
    
    $('.select-item').click(function() {
        updateSelectAll();
        updateBatchButton();
    });
    
    function updateSelectAll() {
        const allChecked = $('.select-item:checked').length === $('.select-item').length;
        $('#select-all').prop('checked', allChecked);
    }
    
    function updateBatchButton() {
        const checkedCount = $('.select-item:checked').length;
        $('#selected-count').text(checkedCount);
        
        if (checkedCount > 0) {
            $('#batch-actions').removeClass('hidden');
        } else {
            $('#batch-actions').addClass('hidden');
        }
    }
    
    $('#apply-batch').click(function() {
        const action = $('#batch-action').val();
        const ids = [];
        
        $('.select-item:checked').each(function() {
            ids.push($(this).val());
        });
        
        if (!action) {
            showNotification('একটি অ্যাকশন সিলেক্ট করুন', 'error');
            return;
        }
        
        if (ids.length === 0) {
            showNotification('কোন আইটেম সিলেক্ট করা হয়নি', 'error');
            return;
        }
        
        if (confirm(`নির্বাচিত ${ids.length} টি আইটেমে "${action}" প্রয়োগ করবেন?`)) {
            $.ajax({
                url: 'ajax/batch-action.php',
                method: 'POST',
                data: {
                    action: action,
                    ids: ids
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showNotification(response.message, 'error');
                    }
                },
                error: function() {
                    showNotification('সার্ভার সমস্যা', 'error');
                }
            });
        }
    });
    
    // ==================== ড্র্যাগ ড্রপ ফাইল আপলোড ====================
    const dropZone = $('#drop-zone');
    
    if (dropZone.length) {
        // প্রিভেন্ট ডিফল্ট
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.on(eventName, preventDefaults);
            $(document).on(eventName, preventDefaults);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // হাইলাইট
        dropZone.on('dragenter dragover', function() {
            $(this).addClass('border-red-500 bg-red-50');
        });
        
        dropZone.on('dragleave drop', function() {
            $(this).removeClass('border-red-500 bg-red-50');
        });
        
        // ড্রপ হ্যান্ডলার
        dropZone.on('drop', function(e) {
            const files = e.originalEvent.dataTransfer.files;
            $('#file-input').prop('files', files);
            
            // ইভেন্ট ট্রিগার
            $('#file-input').trigger('change');
            
            showNotification(`${files.length} টি ফাইল আপলোডের জন্য নির্বাচিত হয়েছে`, 'success');
        });
    }
    
    // ==================== ওয়াটারমার্ক যোগ ====================
    $('#add-watermark').click(function() {
        const imageId = $('#image-id').val();
        const position = $('#watermark-position').val();
        
        if (!imageId) {
            showNotification('কোন ইমেজ সিলেক্ট করা হয়নি', 'error');
            return;
        }
        
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> প্রসেসিং...');
        
        $.ajax({
            url: 'ajax/add-watermark.php',
            method: 'POST',
            data: {
                image_id: imageId,
                position: position
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification('ওয়াটারমার্ক যোগ হয়েছে', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification(response.message, 'error');
                    $('#add-watermark').prop('disabled', false).html('<i class="fas fa-water"></i> ওয়াটারমার্ক যোগ করুন');
                }
            },
            error: function() {
                showNotification('সার্ভার সমস্যা', 'error');
                $('#add-watermark').prop('disabled', false).html('<i class="fas fa-water"></i> ওয়াটারমার্ক যোগ করুন');
            }
        });
    });
    
    // ==================== ইমেজ ক্রপ ====================
    let cropper;
    
    $('#image-to-crop').on('change', function() {
        const input = this;
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $('#crop-image').attr('src', e.target.result);
                $('#crop-modal').removeClass('hidden');
                
                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(document.getElementById('crop-image'), {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    autoCropArea: 1
                });
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    });
    
    $('#crop-save').click(function() {
        if (!cropper) return;
        
        const canvas = cropper.getCroppedCanvas({
            width: 1200,
            height: 675
        });
        
        canvas.toBlob(function(blob) {
            const formData = new FormData();
            formData.append('cropped_image', blob);
            
            $.ajax({
                url: 'ajax/upload-cropped.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    showNotification('ছবি ক্রপ করা হয়েছে', 'success');
                    $('#crop-modal').addClass('hidden');
                    location.reload();
                }
            });
        });
    });
    
    $('#crop-cancel').click(function() {
        if (cropper) {
            cropper.destroy();
        }
        $('#crop-modal').addClass('hidden');
    });
    
    // ==================== এক্সপোর্ট ডাটা ====================
    $('#export-data').click(function() {
        const type = $('#export-type').val();
        const from = $('#export-from').val();
        const to = $('#export-to').val();
        
        window.location.href = `export.php?type=${type}&from=${from}&to=${to}`;
    });
    
    // ==================== ইম্পোর্ট ডাটা ====================
    $('#import-form').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $('#import-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ইম্পোর্ট হচ্ছে...');
        
        $.ajax({
            url: 'ajax/import.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    showNotification(response.message, 'error');
                    $('#import-btn').prop('disabled', false).html('<i class="fas fa-upload"></i> ইম্পোর্ট');
                }
            },
            error: function() {
                showNotification('ইম্পোর্ট ব্যর্থ হয়েছে', 'error');
                $('#import-btn').prop('disabled', false).html('<i class="fas fa-upload"></i> ইম্পোর্ট');
            }
        });
    });
    
    // ==================== ব্যাকআপ তৈরি ====================
    $('#create-backup').click(function() {
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ব্যাকআপ হচ্ছে...');
        
        $.ajax({
            url: 'ajax/create-backup.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification('ব্যাকআপ তৈরি হয়েছে', 'success');
                    $('#backup-list').append(`
                        <tr>
                            <td class="px-4 py-2">${response.filename}</td>
                            <td class="px-4 py-2">${response.size}</td>
                            <td class="px-4 py-2">${response.date}</td>
                            <td class="px-4 py-2">
                                <a href="${response.download}" class="text-blue-600 hover:text-blue-800 mr-2">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button class="text-red-600 hover:text-red-800 restore-backup" data-file="${response.filename}">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                } else {
                    showNotification(response.message, 'error');
                }
                $('#create-backup').prop('disabled', false).html('<i class="fas fa-database"></i> ব্যাকআপ তৈরি');
            },
            error: function() {
                showNotification('ব্যাকআপ ব্যর্থ হয়েছে', 'error');
                $('#create-backup').prop('disabled', false).html('<i class="fas fa-database"></i> ব্যাকআপ তৈরি');
            }
        });
    });
    
    // ==================== ব্যাকআপ রিস্টোর ====================
    $(document).on('click', '.restore-backup', function() {
        const file = $(this).data('file');
        
        if (confirm('ব্যাকআপ রিস্টোর করলে বর্তমান ডাটা ওভাররাইট হবে। চালিয়ে যেতে চান?')) {
            $.ajax({
                url: 'ajax/restore-backup.php',
                method: 'POST',
                data: { file: file },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showNotification('ব্যাকআপ রিস্টোর করা হয়েছে', 'success');
                    } else {
                        showNotification(response.message, 'error');
                    }
                }
            });
        }
    });
    
    // ==================== ক্যাশ ক্লিয়ার ====================
    $('#clear-cache').click(function() {
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ক্লিয়ার হচ্ছে...');
        
        $.ajax({
            url: 'ajax/clear-cache.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification('ক্যাশ ক্লিয়ার হয়েছে', 'success');
                } else {
                    showNotification(response.message, 'error');
                }
                $('#clear-cache').prop('disabled', false).html('<i class="fas fa-trash"></i> ক্যাশ ক্লিয়ার');
            },
            error: function() {
                showNotification('ক্যাশ ক্লিয়ার ব্যর্থ', 'error');
                $('#clear-cache').prop('disabled', false).html('<i class="fas fa-trash"></i> ক্যাশ ক্লিয়ার');
            }
        });
    });
    
    // ==================== সিস্টেম চেক ====================
    $('#system-check').click(function() {
        $.ajax({
            url: 'ajax/system-check.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<div class="space-y-2">';
                
                $.each(response, function(key, value) {
                    const icon = value.status === 'ok' ? 'check-circle text-green-600' : 'exclamation-circle text-red-600';
                    html += `
                        <div class="flex items-center">
                            <i class="fas fa-${icon} mr-2"></i>
                            <span class="font-semibold w-32">${key}:</span>
                            <span>${value.message}</span>
                        </div>
                    `;
                });
                
                html += '</div>';
                
                $('#system-check-modal .modal-body').html(html);
                $('#system-check-modal').removeClass('hidden');
            }
        });
    });
    
    // ==================== মোডাল হ্যান্ডলিং ====================
    $('.modal-close, .modal-overlay').click(function() {
        $('.modal').addClass('hidden');
        $('.modal-overlay').addClass('hidden');
    });
    
    // ==================== লাইভ সার্চ ====================
    let searchTimer;
    $('#live-search').on('input', function() {
        clearTimeout(searchTimer);
        const query = $(this).val();
        
        if (query.length < 2) {
            $('#search-results').addClass('hidden');
            return;
        }
        
        searchTimer = setTimeout(function() {
            $.ajax({
                url: 'ajax/live-search.php',
                method: 'GET',
                data: { q: query },
                dataType: 'json',
                success: function(response) {
                    if (response.results.length > 0) {
                        let html = '';
                        $.each(response.results, function(i, item) {
                            html += `
                                <a href="${item.url}" class="block p-2 hover:bg-gray-100 border-b">
                                    <div class="font-semibold">${item.title}</div>
                                    <div class="text-xs text-gray-500">${item.category} | ${item.date}</div>
                                </a>
                            `;
                        });
                        $('#search-results').html(html).removeClass('hidden');
                    } else {
                        $('#search-results').html('<div class="p-2 text-gray-500">কিছু পাওয়া যায়নি</div>').removeClass('hidden');
                    }
                }
            });
        }, 500);
    });
    
    // ==================== অটো-রিফ্রেশ ====================
    let refreshInterval;
    
    $('#auto-refresh').change(function() {
        if ($(this).is(':checked')) {
            const interval = $('#refresh-interval').val() * 1000;
            refreshInterval = setInterval(function() {
                location.reload();
            }, interval);
        } else {
            clearInterval(refreshInterval);
        }
    });
    
    // ==================== ডাটা প্রিভিউ ====================
    $('.preview-btn').click(function() {
        const url = $(this).data('url');
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#preview-content').html(JSON.stringify(data, null, 2));
                $('#preview-modal').removeClass('hidden');
            }
        });
    });
    
    // ==================== সি এস ভি এক্সপোর্ট ====================
    $('#export-csv').click(function() {
        const table = $('#data-table');
        const rows = [];
        
        // হেডার
        const headers = [];
        table.find('thead th').each(function() {
            headers.push($(this).text());
        });
        rows.push(headers.join(','));
        
        // ডাটা
        table.find('tbody tr').each(function() {
            const row = [];
            $(this).find('td').each(function() {
                let text = $(this).text().replace(/,/g, ' ');
                row.push(text);
            });
            rows.push(row.join(','));
        });
        
        const csv = rows.join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        
        a.href = url;
        a.download = 'export.csv';
        a.click();
        
        window.URL.revokeObjectURL(url);
    });
    
    // ==================== প্রিন্ট ====================
    $('#print-btn').click(function() {
        window.print();
    });
    
    // ==================== ফুলস্ক্রিন ====================
    $('#fullscreen-btn').click(function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            $(this).html('<i class="fas fa-compress"></i>');
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
                $(this).html('<i class="fas fa-expand"></i>');
            }
        }
    });
    
    // ==================== লোডিং ইন্ডিকেটর ====================
    $(document).ajaxStart(function() {
        $('#global-loader').removeClass('hidden');
    });
    
    $(document).ajaxStop(function() {
        $('#global-loader').addClass('hidden');
    });
    
    // ==================== অ্যানিমেশন ====================
    $('.fade-in').each(function(i) {
        $(this).delay(100 * i).animate({ opacity: 1 }, 500);
    });
    
    // ==================== ফর্ম ভ্যালিডেশন ====================
    $('form[data-validate="true"]').submit(function(e) {
        let isValid = true;
        const errors = [];
        
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                const label = $(this).closest('.form-group').find('label').text();
                errors.push(`${label} প্রয়োজন`);
                $(this).addClass('border-red-500');
            } else {
                $(this).removeClass('border-red-500');
            }
        });
        
        $(this).find('[type="email"]').each(function() {
            const email = $(this).val();
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                isValid = false;
                errors.push('সঠিক ইমেইল দিন');
                $(this).addClass('border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotification(errors.join('<br>'), 'error');
        }
    });
});

// ==================== কাস্টম ফাংশন ====================

// বাংলা সংখ্যা কনভার্ট
function toBanglaNumber(number) {
    const banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return number.toString().replace(/\d/g, x => banglaDigits[x]);
}

// ইংলিশ সংখ্যা কনভার্ট
function toEnglishNumber(banglaNumber) {
    const englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    return banglaNumber.toString().replace(/[০-৯]/g, x => englishDigits[x.charCodeAt(0) - 2534]);
}

// ডেট ফরম্যাট
function formatDate(date, format = 'bn') {
    const d = new Date(date);
    
    if (format === 'bn') {
        const days = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
        const months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        
        return `${days[d.getDay()]}, ${toBanglaNumber(d.getDate())} ${months[d.getMonth()]} ${toBanglaNumber(d.getFullYear())}`;
    } else {
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }
}

// টাইম এগো
function timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    
    const intervals = {
        বছর: 31536000,
        মাস: 2592000,
        সপ্তাহ: 604800,
        দিন: 86400,
        ঘন্টা: 3600,
        মিনিট: 60,
        সেকেন্ড: 1
    };
    
    for (const [unit, value] of Object.entries(intervals)) {
        const count = Math.floor(seconds / value);
        
        if (count > 0) {
            return `${toBanglaNumber(count)} ${unit} আগে`;
        }
    }
    
    return 'এইমাত্র';
}

// র‍্যান্ডম কালার জেনারেট
function randomColor() {
    const colors = ['#dc2626', '#2563eb', '#16a34a', '#9333ea', '#ea580c', '#0891b2'];
    return colors[Math.floor(Math.random() * colors.length)];
}

// কপি টু ক্লিপবোর্ড
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showNotification('কপি করা হয়েছে', 'success');
    }, function() {
        showNotification('কপি ব্যর্থ হয়েছে', 'error');
    });
}

// ডাউনলোড ফাইল
function downloadFile(url, filename) {
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
}

// চার্ট রিসাইজ
function resizeCharts() {
    if (window.newsChart) window.newsChart.resize();
    if (window.categoryChart) window.categoryChart.resize();
}

// উইন্ডো রিসাইজ ইভেন্ট
$(window).on('resize', function() {
    resizeCharts();
});

// আনলোড ইভেন্ট
$(window).on('beforeunload', function() {
    // ক্লিনআপ
    if (cropper) {
        cropper.destroy();
    }
});