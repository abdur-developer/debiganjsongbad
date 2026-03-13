<?php
$auth->requirePermission('comments');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id) {
    $sql = "UPDATE comments SET status = 'approved' WHERE id = $id";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'মন্তব্য অনুমোদন করা হয়েছে';
    }
}

echo "<script>window.location.href = 'index.php?q=comments';</script>";
exit();