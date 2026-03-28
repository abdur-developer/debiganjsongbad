<?php
// require_once '../admin/includes/config.php';
// require_once '../admin/includes/db.php';

if(isset($_POST['ad_id'])) {
    $ad_id = $_POST['ad_id'];

    $clicks = isset($_COOKIE['adClicks_'.$ad_id]) ? $_COOKIE['adClicks_'.$ad_id] : 0;
    $clicks++;
    setcookie("adClicks_".$ad_id, $clicks, time() + (2 * 60 * 60), "/");
    echo 'ok';

    // ক্লিক আপডেট
    // $sql = "UPDATE ads SET current_clicks = current_clicks + 1 WHERE id = '$ad_id'";
    // $result = $conn->query($sql);
    // if ($result) echo 'ok';
    // else echo 'error';
} else {
    echo 'error';
}
?>