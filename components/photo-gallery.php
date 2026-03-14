<?php
// গ্যালারি
$gallerySql = "SELECT image FROM gallery WHERE status = 'active' ORDER BY created_at DESC LIMIT 6";
$galleryResult = $conn->query($gallerySql);
?>
<!-- Photo Gallery Section -->
<section class="mb-6">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-bold text-lg border-l-4 border-red-600 pl-2"><a href="gallery.html">ছবি গ্যালারি</a></h3>
        <a href="gallery.html" class="text-sm text-blue-600 hover:underline">সব ছবি</a>
    </div>
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
        <?php while ($galleryRow = $galleryResult->fetch_assoc()): ?>
            <a href="gallery.html" class="gallery-thumb">
                <img class="w-full h-16 object-cover rounded lazy" data-src="<?= $galleryRow['image'] ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='100'%3E%3Crect width='150' height='100' fill='%23ddd'/%3E%3C/svg%3E" alt="gallery">
            </a>
        <?php endwhile; ?>
    </div>
</section>