<?php
$auth->requirePermission('comments');

$id = isset($_GET['spam_id']) ? intval($_GET['spam_id']) : 0;

if ($id) {
    $sql = "UPDATE comments SET status = 'spam' WHERE id = $id";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'মন্তব্য স্প্যাম করা হয়েছে';
    }
}

echo "<script>window.location.href = 'index.php?q=comments';</script>";
exit();