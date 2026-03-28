
<?php
    $address = $conn->query("SELECT value FROM settings WHERE key_name = 'address'")->fetch_assoc()['value'];
    $phone = $conn->query("SELECT value FROM settings WHERE key_name = 'phone'")->fetch_assoc()['value'];
    $email = $conn->query("SELECT value FROM settings WHERE key_name = 'contact_email'")->fetch_assoc()['value'];
?>
<!-- FOOTER -->
<footer class="bg-gray-800 text-white pt-6 pb-4 text-sm">
    <div class="container mx-auto px-2 sm:px-4">
        <!-- Footer Links -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div>
                <h5 class="font-semibold mb-2 text-lg border-b border-gray-600 pb-1">দেবীগঞ্জ সংবাদ</h5>
                <ul class="space-y-1 text-gray-300">
                    <li><a href="https://debiganjsongbad.com/legal/about_us.html" class="hover:text-white">আমাদের সম্পর্কে</a></li>
                    <li><a href="https://debiganjsongbad.com/legal/contact_us.html" class="hover:text-white">যোগাযোগ</a></li>
                    <li><a href="https://debiganjsongbad.com/legal/privacy_policy.html" class="hover:text-white">প্রাইভেসি পলিসি</a></li>
                    <li><a href="https://debiganjsongbad.com/legal/terms_n_conditions.html" class="hover:text-white">টার্মস অফ ইউজ</a></li>
                    <li><a href="https://debiganjsongbad.com/legal/disclaimer.html" class="hover:text-white">ডিসক্লেইমার</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold mb-2 text-lg border-b border-gray-600 pb-1">সংবাদ</h5>
                <ul class="space-y-1 text-gray-300">
                    <li><a href="https://debiganjsongbad.com/news/" class="hover:text-white">সর্বশেষ সংবাদ</a></li>
                    <li><a href="https://debiganjsongbad.com/news/?cat=international" class="hover:text-white">আন্তর্জাতিক</a></li>
                    <li><a href="https://debiganjsongbad.com/news/?cat=national" class="hover:text-white">জাতীয়</a></li>
                    <li><a href="https://debiganjsongbad.com/news/?cat=sports" class="hover:text-white">খেলাধুলা</a></li>
                    <li><a href="https://debiganjsongbad.com/news/?cat=entertainment" class="hover:text-white">বিনোদন</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold mb-2 text-lg border-b border-gray-600 pb-1">সেবা সমূহ</h5>
                <ul class="space-y-1 text-gray-300">
                    <li><a href="mailto:<?= $email ?>" class="hover:text-white">নিউজ দিন</a></li>
                    <!-- <li><a href="#" class="hover:text-white">নিউজলেটার</a></li>
                    <li><a href="#" class="hover:text-white">আর্কাইভ</a></li>
                    <li><a href="#" class="hover:text-white">আরএসএস ফিড</a></li> -->
                    <li><a href="#" class="hover:text-white">মোবাইল অ্যাপ</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold mb-2 text-lg border-b border-gray-600 pb-1">নিউজলেটার</h5>
                <!-- <p class="text-gray-300 text-xs mb-2">দৈনিক সংবাদ পেতে সাবস্ক্রাইব করুন</p>
                <div class="flex">
                    <input type="email" placeholder="ইমেইল" class="p-2 text-black text-xs rounded-l w-full">
                    <button class="bg-red-600 px-3 rounded-r text-xs hover:bg-red-700 transition">সাবস্ক্রাইব</button>
                </div> -->
                <ul class="space-y-1 text-gray-300">
                    <li><a href="#" class="hover:text-white"><?=$address?></a></li>
                    <li><a href="tel:<?= $phone ?>" class="hover:text-white"><?=bn_num($phone)?></a></li>
                    <li><a href="mailto:<?= $email ?>" class="hover:text-white"><?=$email?></a></li>
                </ul>
                <div class="flex gap-3 mt-4">
                    <a href="<?=$facebook_url?>" target="_blank" class="text-gray-300 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.99h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.99C18.343 21.128 22 16.991 22 12z"/></svg></a>
                    <!-- <a href="#" target="_blank" class="text-gray-300 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg></a> -->
                    <a href="<?=$youtube_url?>" target="_blank" class="text-gray-300 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                </div>

            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-700 pt-4 text-center text-gray-400 text-xs">
            <p>© <?= bn_num(date('Y')) ?> দেবীগঞ্জ সংবাদ। সর্বসত্ত্ব সংরক্ষিত। <a href="https://debiganjsongbad.com/abdurrahman.php" class="text-blue-400 hover:text-white" target="_blank" rel="noopener noreferrer">ডিজাইন ও ডেভেলপমেন্ট: আব্দুর রহমান</a></p>
        </div>
    </div>
</footer>