<script>
    console.log("Ads Script Loaded");
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script>
    function getCookie(name) {
        let cookies = document.cookie.split("; ");
        for (let c of cookies) {
            let [key, value] = c.split("=");
            if (key === name) return parseInt(value);
        }
        return 0;
    }

    // অ্যাডে ক্লিক ট্র্যাক করা
    document.addEventListener('click', function(e) {
        // অ্যাডের প্যারেন্ট এলিমেন্ট খুঁজুন
        let target = e.target;
        let adWrapper = null;
        
        while(target && target !== document.body) {
            if(target.classList && target.classList.contains('ad-wrapper')) {
                adWrapper = target;
                break;
            }
            target = target.parentElement;
        }
        
        // যদি অ্যাডে ক্লিক হয়ে থাকে
        if(adWrapper) {
            let adId = adWrapper.getAttribute('data-ad-id');
            
            if(adId) {
                // AJAX দিয়ে ট্র্যাক করুন
                // let xhr = new XMLHttpRequest();
                // xhr.open('POST', 'api/track_click.php', true);
                // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                // xhr.send('ad_id=' + adId);
                let count = getCookie("adClicks_"+adId) || 0;
                count++;
                
                let date = new Date();
                date.setTime(date.getTime() + (2 * 60 * 60 * 1000)); // 2 hours
                document.cookie = "adClicks_"+adId + "=" + count + "; expires=" + date.toUTCString() + "; path=/";
            }
        }
    });
</script>