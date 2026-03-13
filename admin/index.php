<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

$stats = $functions->getDashboardStats();
?>
<?php
    if(isset($_GET['q'])){
        $q = $_GET['q'];
        if($q == 'profile') {
            require_once 'profile/index.php';

        }else if($q == 'settings') {
            require_once 'settings/index.php';

        }else if($q == 'roles') {
            if(isset($_GET['create'])) {
                require_once 'roles/create.php';
            }else if(isset($_GET['edit_id'])) {
                require_once 'roles/edit.php';
            }else if(isset($_GET['delete_id'])) {
                require_once 'roles/delete.php';
            }else{
                require_once 'roles/index.php';
            }
        }else if($q == 'categories') {
            if(isset($_GET['create'])) {
                require_once 'categories/create.php';
            }else if(isset($_GET['edit_id'])) {
                require_once 'categories/edit.php';
            }else if(isset($_GET['delete_id'])) {
                require_once 'categories/delete.php';
            }else{
                require_once 'categories/index.php';
            }
        }else if($q == 'gallery') {
            if(isset($_GET['upload'])) {
                require_once 'gallery/upload.php';
            }else if(isset($_GET['edit_id'])) {
                require_once 'gallery/edit.php';
            }else if(isset($_GET['delete_id'])) {
                require_once 'gallery/delete.php';
            }else{
                require_once 'gallery/index.php';
            }
        }else if($q == 'comments') {
            if(isset($_GET['approve_id'])) {
                require_once 'comments/approve.php';
            }else if(isset($_GET['spam_id'])) {
                require_once 'comments/spam.php';
            }else if(isset($_GET['delete_id'])) {
                require_once 'comments/delete.php';
            }else{
                require_once 'comments/index.php';
            }
        }else if($q == 'users') {
            if(isset($_GET['create'])) {
                require_once 'users/create.php';
            }else if(isset($_GET['edit_id'])) {
                require_once 'users/edit.php';
            }else if(isset($_GET['delete_id'])) {
                require_once 'users/delete.php';
            }else{
                require_once 'users/index.php';
            }
        }else if($q == 'news') {
            if(isset($_GET['create'])) {
                require_once 'news/create.php';
            }else if(isset($_GET['edit_id'])) {
                require_once 'news/edit.php';
            }else if(isset($_GET['delete_id'])) {
                require_once 'news/delete.php';
            }else{
                require_once 'news/index.php';
            }
            
        }else if($q == 'ads') {
            if(isset($_GET['create'])) {
                require_once 'ads/create.php';
            }else if(isset($_GET['edit_id'])) {
                require_once 'ads/edit.php';
            }else if(isset($_GET['delete_id'])) {
                require_once 'ads/delete.php';
            }else{
                require_once 'ads/index.php';
            }
        }else if($q == 'logs') {
            require_once 'logs/index.php';

        }else if($q == 'backup') {
            if(isset($_GET['delete_file'])) {
                require_once 'backup/delete.php';
            }else{
                require_once 'backup/index.php';
            }
        } else {
            require_once 'dashboard.php';
        }
    }else {
        require_once 'dashboard.php';
    }
?>

<?php require_once 'includes/footer.php'; ?>