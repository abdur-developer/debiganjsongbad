<!-- Share Buttons -->
<div class="print-hide flex justify-center items-center gap-2 py-2" id="share-buttons">
    <span class="text-sm font-bold text-gray-700">
        <?= $news['share_count'] ?> Share
    </span>
    <img data-type="facebook" src="https://cdn-icons-png.flaticon.com/512/145/145802.png" class="rounded-full w-10 h-10">
    <img data-type="messenger" src="https://cdn-icons-png.flaticon.com/512/3670/3670042.png" class="rounded-full w-10 h-10">
    <img data-type="whatsapp" src="https://cdn-icons-png.flaticon.com/512/3670/3670051.png" class="rounded-full w-10 h-10">
    <img data-type="copy" src="https://cdn-icons-png.flaticon.com/512/1828/1828249.png" class="p-2 w-10 h-10">
    <img data-type="print" src="https://cdn-icons-png.flaticon.com/512/12702/12702158.png" class="p-1 w-10 h-10">
</div>
<script>
    const shareButtons = document.querySelectorAll('#share-buttons img');
    const shareCountElement = document.querySelector('#share-buttons span');

    shareButtons.forEach(button => {
        const type = button.getAttribute('data-type');
        button.addEventListener('click', () => {
            // Send an AJAX request to update the share count
            fetch('../api/update_share.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ news_id: <?= $news['id'] ?> })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the share count in the UI
                    let currentCount = parseInt(shareCountElement.textContent) || 0;
                    const newCount = currentCount + 1;
                    shareCountElement.textContent = `${newCount} Share${newCount !== 1 ? 's' : ''}`;
                    // Disable the image button by preventing pointer events and dimming it
                    button.style.pointerEvents = 'none';
                    button.style.opacity = '0.6';
                    if(type === 'copy') {
                        // Copy the current page URL to the clipboard
                        navigator.clipboard.writeText(window.location.href)
                            .then(() => {
                                alert('URL copied to clipboard!');
                            })
                            .catch(err => {
                                console.error('Failed to copy: ', err);
                            });
                    } else {
                        redirectToShare(type);
                    }
                } else {
                    console.error('Failed to update share count');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
    function redirectToShare(type) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        let shareUrl = '';

        switch (type) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'messenger':
                shareUrl = `fb-messenger://share/?link=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                break;
            case 'print':
                window.print();
                return; // No need to open a new window for print
            default:
                return;
        }

        window.open(shareUrl, '_blank');
    }
</script>
