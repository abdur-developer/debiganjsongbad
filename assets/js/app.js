// main.js - Complete JavaScript for Bangla News Portal

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    console.log('দেবীগঞ্জ সংবাদ - জাভাস্ক্রিপ্ট লোড হয়েছে');
    
    // ==================== LAZY LOADING IMAGES ====================
    const lazyImages = document.querySelectorAll('img.lazy');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
        });
    }
    
    // ==================== LIVE DATE & TIME ====================
    function updateDateTime() {
        const dateElement = document.getElementById('live-datetime');
        if (dateElement) {
            const now = new Date();
            const banglaDays = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
            const months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
            
            const day = banglaDays[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            
            dateElement.innerText = `${day}, ${date} ${month} ${year}`;
        }
    }
    updateDateTime();
    setInterval(updateDateTime, 60000); // Update every minute
    
    // ==================== DARK MODE TOGGLE ====================
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.getElementById('body');
    
    // Check for saved preference
    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark-mode');
        if (darkModeToggle) {
            darkModeToggle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>';
        }
    }
    
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
                darkModeToggle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>';
            } else {
                localStorage.setItem('darkMode', 'disabled');
                darkModeToggle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>';
            }
        });
    }
    
    // ==================== HERO SLIDER ====================
    const heroSlider = document.getElementById('hero-slider');
    if (heroSlider) {
        const slides = document.querySelectorAll('.slider-slide');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.querySelector('.slider-prev');
        const nextBtn = document.querySelector('.slider-next');
        let currentSlide = 0;
        let slideInterval;
        
        function showSlide(index) {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            currentSlide = index;
        }
        
        function nextSlide() {
            showSlide(currentSlide + 1);
        }
        
        function prevSlide() {
            showSlide(currentSlide - 1);
        }
        
        // Auto slide
        function startAutoSlide() {
            slideInterval = setInterval(nextSlide, 5000);
        }
        
        function stopAutoSlide() {
            clearInterval(slideInterval);
        }
        
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                stopAutoSlide();
                startAutoSlide();
            });
            
            nextBtn.addEventListener('click', () => {
                nextSlide();
                stopAutoSlide();
                startAutoSlide();
            });
            
            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    showSlide(index);
                    stopAutoSlide();
                    startAutoSlide();
                });
            });
            
            // Pause on hover
            heroSlider.addEventListener('mouseenter', stopAutoSlide);
            heroSlider.addEventListener('mouseleave', startAutoSlide);
            
            // Start auto slide
            startAutoSlide();
        }
    }
    
    // ==================== POPULAR NEWS TABS ====================
    const popularTabs = document.querySelectorAll('.popular-tab');
    if (popularTabs.length > 0) {
        popularTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                popularTabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Get tab id
                const tabId = this.dataset.tab;
                
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Show selected tab content
                const selectedTab = document.getElementById(`tab-${tabId}`);
                if (selectedTab) {
                    selectedTab.classList.remove('hidden');
                }
            });
        });
    }
    
    // ==================== LIVE SEARCH SUGGESTIONS ====================
    const searchInput = document.getElementById('search-input');
    const searchSuggestions = document.getElementById('search-suggestions');
    
    if (searchInput && searchSuggestions) {
        const suggestionsList = [
            'বন্দর জট',
            'প্রধানমন্ত্রী',
            'বাজেট',
            'ক্রিকেট',
            'ভারত',
            'যুক্তরাষ্ট্র',
            'মূল্যস্ফীতি',
            'শীত',
            'রমজান',
            'ঈদ'
        ];
        
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            if (query.length < 2) {
                searchSuggestions.classList.add('hidden');
                return;
            }
            
            const filtered = suggestionsList.filter(item => 
                item.toLowerCase().includes(query)
            );
            
            if (filtered.length > 0) {
                let html = '';
                filtered.forEach(item => {
                    html += `<div class="p-2 hover:bg-gray-100 cursor-pointer border-b">${item}</div>`;
                });
                searchSuggestions.innerHTML = html;
                searchSuggestions.classList.remove('hidden');
                
                // Add click handlers to suggestions
                document.querySelectorAll('#search-suggestions div').forEach(suggestion => {
                    suggestion.addEventListener('click', function() {
                        searchInput.value = this.innerText;
                        searchSuggestions.classList.add('hidden');
                        window.location.href = `search.html?q=${encodeURIComponent(this.innerText)}`;
                    });
                });
            } else {
                searchSuggestions.classList.add('hidden');
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                searchSuggestions.classList.add('hidden');
            }
        });
        
        // Search button click
        const searchBtn = document.getElementById('search-btn');
        if (searchBtn) {
            searchBtn.addEventListener('click', function() {
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = `search.html?q=${encodeURIComponent(query)}`;
                }
            });
        }
        
        // Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    window.location.href = `search.html?q=${encodeURIComponent(query)}`;
                }
            }
        });
    }
    
    // ==================== INFINITE SCROLL (for index page) ====================
    // Simple infinite scroll for latest news section
    const latestNewsGrid = document.querySelector('.grid.grid-cols-2.md\\:grid-cols-3.gap-3');
    if (latestNewsGrid && window.location.pathname.includes('index.html')) {
        let page = 1;
        let loading = false;
        
        window.addEventListener('scroll', function() {
            if (loading) return;
            
            const scrollPosition = window.innerHeight + window.scrollY;
            const threshold = document.body.offsetHeight - 1000;
            
            if (scrollPosition >= threshold) {
                loading = true;
                page++;
                
                // Simulate loading more news
                setTimeout(() => {
                    const newHTML = `
                        <article class="news-card bg-white shadow-sm rounded overflow-hidden">
                            <img class="w-full h-28 object-cover lazy" data-src="https://picsum.photos/300/180?text=More+${page}" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='180'%3E%3Crect width='300' height='180' fill='%23f1f5f9'/%3E%3C/svg%3E" alt="news">
                            <div class="p-2">
                                <h4 class="text-sm font-semibold">আরও সংবাদ - পৃষ্ঠা ${page}</h4>
                                <div class="flex items-center justify-between mt-1 text-xs text-gray-500">
                                    <span>২ মিনিট আগে</span>
                                    <span class="bg-gray-100 px-1 rounded">সর্বশেষ</span>
                                </div>
                            </div>
                        </article>
                    `;
                    latestNewsGrid.insertAdjacentHTML('beforeend', newHTML);
                    
                    // Reinitialize lazy load for new images
                    const newLazyImages = document.querySelectorAll('img.lazy:not([data-loaded])');
                    if ('IntersectionObserver' in window) {
                        newLazyImages.forEach(img => {
                            img.dataset.loaded = 'true';
                            const observer = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        entry.target.src = entry.target.dataset.src;
                                        observer.unobserve(entry.target);
                                    }
                                });
                            });
                            observer.observe(img);
                        });
                    }
                    
                    loading = false;
                }, 1000);
            }
        });
    }
    
    // ==================== COMMENT FORM (news.html) ====================
    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = this.querySelector('input[placeholder="আপনার নাম"]').value.trim();
            const email = this.querySelector('input[placeholder="ইমেইল"]').value.trim();
            const comment = this.querySelector('textarea').value.trim();
            
            if (!name || !email || !comment) {
                alert('দয়া করে সব ঘর পূরণ করুন');
                return;
            }
            
            if (!email.includes('@') || !email.includes('.')) {
                alert('দয়া করে সঠিক ইমেইল দিন');
                return;
            }
            
            alert('আপনার মন্তব্য পাঠানো হয়েছে। মডারেশনের পর প্রকাশিত হবে।');
            this.reset();
        });
    }
    
    // ==================== SHARE BUTTONS ====================
    const shareBtns = document.querySelectorAll('.share-btn');
    if (shareBtns.length > 0) {
        shareBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const url = window.location.href;
                const title = document.title;
                
                if (this.innerText.includes('ফেসবুক')) {
                    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
                } else if (this.innerText.includes('টুইটার')) {
                    window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank', 'width=600,height=400');
                } else if (this.innerText.includes('হোয়াটসঅ্যাপ')) {
                    window.open(`https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`, '_blank');
                }
            });
        });
    }
    
    // ==================== NEWSLETTER SUBSCRIPTION ====================
    const newsletterBtns = document.querySelectorAll('footer .bg-red-600');
    newsletterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input && input.type === 'email') {
                const email = input.value.trim();
                if (email && email.includes('@') && email.includes('.')) {
                    alert('নিউজলেটার সাবস্ক্রিপশন সফল হয়েছে!');
                    input.value = '';
                } else {
                    alert('দয়া করে সঠিক ইমেইল দিন');
                }
            }
        });
    });
    
    // ==================== BACK TO TOP BUTTON (optional) ====================
    // Create back to top button
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '↑';
    backToTop.className = 'fixed bottom-20 right-4 bg-gray-800 text-white w-10 h-10 rounded-full shadow-lg hidden hover:bg-gray-700 transition z-40';
    backToTop.setAttribute('aria-label', 'Back to top');
    document.body.appendChild(backToTop);
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTop.classList.remove('hidden');
        } else {
            backToTop.classList.add('hidden');
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // ==================== BREAKING NEWS TICKER UPDATE ====================
    // Update breaking news periodically (simulate live updates)
    const breakingTicker = document.getElementById('breaking-ticker');
    if (breakingTicker) {
        const breakingNewsList = [
            '🔴 প্রধানমন্ত্রী আজ বিকেলে সংবাদ সম্মেলন করবেন',
            '❄️ শীতে কাঁপছে দেশ, তাপমাত্রা ৮ ডিগ্রি',
            '🏏 টি-টোয়েন্টি সিরিজ জয় বাংলাদেশের',
            '💰 মূল্যস্ফীতি কমতে শুরু করেছে',
            '🌍 জাতিসংঘে বাংলাদেশের জয়জয়কার',
            '🚗 এলিভেটেড এক্সপ্রেসওয়ে চালু'
        ];
        
        setInterval(() => {
            const randomIndex = Math.floor(Math.random() * breakingNewsList.length);
            const newsItem = breakingNewsList[randomIndex];
            
            // Append to ticker
            const currentContent = breakingTicker.innerText;
            breakingTicker.innerText = `${newsItem} | ${currentContent}`;
            
            // Trim if too long
            if (breakingTicker.innerText.length > 200) {
                breakingTicker.innerText = breakingTicker.innerText.slice(0, 200) + '...';
            }
        }, 30000); // Update every 30 seconds
    }
    
    // ==================== PAGINATION ACTIVE STATE ====================
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            paginationLinks.forEach(l => l.classList.remove('bg-red-600', 'text-white'));
            this.classList.add('bg-red-600', 'text-white');
        });
    });
    
    // ==================== MOBILE MENU TOGGLE (optional) ====================
    // For very small screens, could add hamburger menu, but we already have scrollable nav
    
    console.log('দেবীগঞ্জ সংবাদ - সব ফিচার লোড হয়েছে');
});