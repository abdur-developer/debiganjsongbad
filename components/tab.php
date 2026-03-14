<!-- Popular News Tabs -->
<?php
// সর্বাধিক পঠিত
$popularSql = "SELECT n.*, c.name_bn as category_name 
            FROM news n 
            LEFT JOIN categories c ON n.category_id = c.id 
            WHERE n.status = 'published' 
            ORDER BY n.views DESC LIMIT 5";
$popularResult = $conn->query($popularSql);

?>
<div class="bg-white shadow-sm rounded overflow-hidden">
    <div class="flex border-b">
        <button class="popular-tab active flex-1 py-2 text-sm font-medium text-center" data-tab="most-read">সর্বাধিক পঠিত</button>
        <button class="popular-tab flex-1 py-2 text-sm font-medium text-center" data-tab="most-shared">সর্বাধিক শেয়ার</button>
        <button class="popular-tab flex-1 py-2 text-sm font-medium text-center" data-tab="editor-picks">সম্পাদক পছন্দ</button>
    </div>
    <div class="p-3">
        <!-- Most Read Tab -->
        <div class="tab-content active" id="tab-most-read">
            <ul class="space-y-2">
                <li class="border-b pb-2 flex gap-2"><span class="bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded">১</span><span class="text-sm">ডলারের দাম আবার বেড়ে ১২০ টাকা</span></li>
                <li class="border-b pb-2 flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">২</span><span class="text-sm">জ্বালানি তেলের মূল্যবৃদ্ধি কার্যকর</span></li>
                <li class="border-b pb-2 flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">৩</span><span class="text-sm">বিএনপির মহাসমাবেশ আজ, কঠোর নিরাপত্তা</span></li>
                <li class="border-b pb-2 flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">৪</span><span class="text-sm">পবিত্র রমজান শুরু বৃহস্পতিবার</span></li>
                <li class="flex gap-2"><span class="bg-gray-300 text-gray-700 text-xs w-5 h-5 flex items-center justify-center rounded">৫</span><span class="text-sm">সিরিজ জয়ের নায়ক মুশফিক</span></li>
            </ul>
        </div>
        <!-- Most Shared Tab (hidden initially) -->
        <div class="tab-content hidden" id="tab-most-shared">
            <ul class="space-y-2">
                <li class="border-b pb-2"><span class="text-sm">🔗 ১. স্মার্টফোনের নতুন মডেল লঞ্চ</span></li>
                <li class="border-b pb-2"><span class="text-sm">🔗 ২. যেসব খাবার ওষুধের মতো কাজ করে</span></li>
                <li class="border-b pb-2"><span class="text-sm">🔗 ৩. বিয়েবাড়ির মেনুতে যা থাকছে</span></li>
                <li class="border-b pb-2"><span class="text-sm">🔗 ৪. ভিসা প্রক্রিয়া সহজ হচ্ছে</span></li>
                <li><span class="text-sm">🔗 ৫. নতুন বছরে বেতন বৃদ্ধির সম্ভাবনা</span></li>
            </ul>
        </div>
        <!-- Editor Picks Tab -->
        <div class="tab-content hidden" id="tab-editor-picks">
            <ul class="space-y-2">
                <li class="border-b pb-2"><span class="text-sm">📌 স্মার্ট বাংলাদেশের স্বপ্ন ও বাস্তবতা</span></li>
                <li class="border-b pb-2"><span class="text-sm">📌 চিকিৎসায় নতুন মাত্রা, জিন থেরাপি</span></li>
                <li class="border-b pb-2"><span class="text-sm">📌 পদ্মা সেতুর প্রভাব অর্থনীতিতে</span></li>
                <li class="border-b pb-2"><span class="text-sm">📌 শিক্ষাক্ষেত্রে ডিজিটাল রূপান্তর</span></li>
                <li><span class="text-sm">📌 পরিবেশ রক্ষায় তরুণদের ভূমিকা</span></li>
            </ul>
        </div>
    </div>
</div>
<script>
// Tab switching for Popular News Tabs
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.popular-tab');
    const tabContents = document.querySelectorAll('.tab-content');
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons and contents
            tabButtons.forEach(b => b.classList.remove('active'));
            tabContents.forEach(tc => tc.classList.add('hidden'));
            tabContents.forEach(tc => tc.classList.remove('active'));
            // Add active to clicked button
            this.classList.add('active');
            // Show corresponding tab content
            const tabId = this.getAttribute('data-tab');
            const content = document.getElementById('tab-' + tabId);
            if (content) {
                content.classList.remove('hidden');
                content.classList.add('active');
            }
        });
    });
});
</script>