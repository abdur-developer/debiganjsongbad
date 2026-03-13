<?php
// admin/includes/footer.php
// এই ফাইলটি অ্যাডমিন প্যানেলের প্রতিটি পৃষ্ঠার শেষে include করতে হবে
?>
                </div> <!-- .p-6 ক্লোজ -->
            </div> <!-- .flex-1 ক্লোজ -->
        </div> <!-- .flex ক্লোজ -->
    </div> <!-- .flex.h-screen ক্লোজ -->
    
    <!-- ফুটার স্ক্রিপ্ট -->
    <script src="assets/js/admin.js"></script>
    
    <!-- কাস্টম স্ক্রিপ্ট সেকশন (যদি কোনো পৃষ্ঠা আলাদা স্ক্রিপ্ট চায়) -->
    <?php if (isset($custom_scripts)): ?>
        <?php echo $custom_scripts; ?>
    <?php endif; ?>
    
    <!-- টোস্ট নোটিফিকেশন -->
    <div id="toast-container" class="fixed top-4 right-4 z-50"></div>
    
    <script>
    // সেশন মেসেজ দেখানো
    <?php if (isset($_SESSION['success'])): ?>
    showNotification('<?php echo $_SESSION['success']; ?>', 'success');
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
    showNotification('<?php echo $_SESSION['error']; ?>', 'error');
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['warning'])): ?>
    showNotification('<?php echo $_SESSION['warning']; ?>', 'warning');
    <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>
    
    // নোটিফিকেশন ফাংশন
    function showNotification(message, type = 'success') {
        const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
                        type === 'error' ? 'bg-red-100 border-red-400 text-red-700' :
                        'bg-yellow-100 border-yellow-400 text-yellow-700';
        
        const icon = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-circle' : 'exclamation-triangle';
        
        const notification = `
            <div class="${bgColor} border px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center animate-fade-in">
                <i class="fas fa-${icon} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        $('#toast-container').append(notification);
        
        setTimeout(() => {
            $('.animate-fade-in:first').fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // ডিলিট কনফার্মেশন
    $('.delete-confirm').click(function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const message = $(this).data('message') || 'আপনি কি নিশ্চিত? এই কাজটি পূর্বাবস্থায় ফেরানো যাবে না।';
        
        if (confirm(message)) {
            window.location.href = href;
        }
    });
    
    // লোডিং ইন্ডিকেটর
    $(document).ajaxStart(function() {
        $('#global-loader').removeClass('hidden');
    });
    
    $(document).ajaxStop(function() {
        $('#global-loader').addClass('hidden');
    });
    
    // কীবোর্ড শর্টকাট
    $(document).keydown(function(e) {
        // Ctrl + S - ফর্ম সেভ
        if (e.ctrlKey && e.keyCode == 83) {
            e.preventDefault();
            $('form[data-shortcut="save"]').submit();
        }
        
        // Esc - মোডাল বন্ধ
        if (e.keyCode == 27) {
            $('.modal, .modal-overlay').fadeOut();
        }
    });
    
    // টেবিল সর্টিং
    $('.sortable').click(function() {
        const column = $(this).data('column');
        const currentUrl = new URL(window.location.href);
        const currentSort = currentUrl.searchParams.get('sort');
        const currentOrder = currentUrl.searchParams.get('order');
        
        let newOrder = 'asc';
        if (currentSort === column && currentOrder === 'asc') {
            newOrder = 'desc';
        }
        
        currentUrl.searchParams.set('sort', column);
        currentUrl.searchParams.set('order', newOrder);
        window.location.href = currentUrl.toString();
    });
    
    // ড্রপডাউন টগল
    $('.dropdown-toggle').click(function(e) {
        e.stopPropagation();
        const dropdown = $(this).next('.dropdown-menu');
        $('.dropdown-menu').not(dropdown).hide();
        dropdown.toggle();
    });
    
    $(document).click(function() {
        $('.dropdown-menu').hide();
    });
    
    // ট্যাব সিস্টেম
    $('.tab-link').click(function() {
        const tabId = $(this).data('tab');
        
        $('.tab-link').removeClass('active border-red-600 text-red-600').addClass('text-gray-600');
        $(this).addClass('active border-red-600 text-red-600').removeClass('text-gray-600');
        
        $('.tab-pane').addClass('hidden');
        $('#' + tabId).removeClass('hidden');
    });
    
    // ডেটপিকার ইনিশিয়ালাইজ
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    
    // টাইমপিকার ইনিশিয়ালাইজ
    $('.timepicker').timepicker({
        showMeridian: false,
        defaultTime: 'current'
    });
    </script>
    
    <!-- গ্লোবাল লোডার -->
    <div id="global-loader" class="hidden fixed inset-0 bg-black bg-opacity-30 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-4 flex items-center">
            <div class="spinner mr-3"></div>
            <span>লোড হচ্ছে...</span>
        </div>
    </div>
    
    <!-- কাস্টম সিএসএস -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #dc2626;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .dropdown-menu {
            display: none;
            position: absolute;
            z-index: 50;
        }
        
        .sortable {
            cursor: pointer;
        }
        
        .sortable:hover {
            color: #dc2626;
        }
        
        /* প্রিন্ট স্টাইল */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
    <script>
        // মোবাইল সাইডবার টগল
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const closeSidebar = document.getElementById('close-sidebar');
            
            function openSidebar() {
                sidebar.classList.add('translate-x-0');
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                document.body.classList.add('sidebar-open');
            }
            
            function closeSidebarFunc() {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('sidebar-open');
            }
            
            if (menuToggle) {
                menuToggle.addEventListener('click', openSidebar);
            }
            
            if (closeSidebar) {
                closeSidebar.addEventListener('click', closeSidebarFunc);
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebarFunc);
            }
            
            // উইন্ডো রিসাইজ হলে মোবাইল সাইডবার বন্ধ
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebarFunc();
                }
            });
            
            // নোটিফিকেশন ফাংশন
            window.showNotification = function(message, type = 'success') {
                const sessionData = document.getElementById('session-data');
                if (sessionData) {
                    // সেশন ডাটা থেকে মেসেজ দেখানো হবে
                }
                
                const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
                                type === 'error' ? 'bg-red-100 border-red-400 text-red-700' :
                                'bg-yellow-100 border-yellow-400 text-yellow-700';
                
                const icon = type === 'success' ? 'check-circle' : 
                            type === 'error' ? 'exclamation-circle' : 'exclamation-triangle';
                
                const notification = document.createElement('div');
                notification.className = `${bgColor} border px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center animate-fade-in text-sm md:text-base`;
                notification.innerHTML = `<i class="fas fa-${icon} mr-2"></i><span>${message}</span>`;
                
                const container = document.getElementById('toast-container');
                if (!container) {
                    const newContainer = document.createElement('div');
                    newContainer.id = 'toast-container';
                    newContainer.className = 'fixed top-4 right-4 z-50 w-11/12 max-w-sm';
                    document.body.appendChild(newContainer);
                    newContainer.appendChild(notification);
                } else {
                    container.appendChild(notification);
                }
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.5s';
                    setTimeout(() => notification.remove(), 500);
                }, 3000);
            };
            
            // সেশন ডাটা দেখান
            const sessionData = document.getElementById('session-data');
            if (sessionData) {
                const success = sessionData.dataset.success;
                const error = sessionData.dataset.error;
                const warning = sessionData.dataset.warning;
                
                if (success) showNotification(success, 'success');
                if (error) showNotification(error, 'error');
                if (warning) showNotification(warning, 'warning');
            }
            
            // ডিলিট কনফার্মেশন
            document.querySelectorAll('.delete-confirm').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    const message = this.dataset.message || 'আপনি কি নিশ্চিত? এই কাজটি পূর্বাবস্থায় ফেরানো যাবে না।';
                    
                    if (confirm(message)) {
                        window.location.href = href;
                    }
                });
            });
        });

        // অ্যানিমেশন সিএসএস
        const style = document.createElement('style');
        style.textContent = `
            .animate-fade-in {
                animation: fadeIn 0.3s ease-in;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* মোবাইলের জন্য সাইডবার ট্রানজিশন */
            @media (max-width: 767px) {
                #sidebar {
                    transition: transform 0.3s ease-in-out;
                    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                }
            }
        `;
        document.head.appendChild(style);
        </script>
</body>
</html>