<?php 
    require_once "../root.php";
    $logo = "../assets/img/logo.png";
    $isRoot = false;
    if(isset($_GET['feed']) ){
        $news_id = $_GET['feed'];
        $news_sql = "SELECT news.*, 
            categories.name_bn as category_name, 
            users.full_name , users.username, users.role, users.bio, users.avatar
            FROM news 
            JOIN categories ON news.category_id = categories.id 
            JOIN users ON news.author_id = users.id 
            WHERE news.id = '$news_id'
        ";
        $news_query = $conn->query($news_sql);
        if($news_query->num_rows > 0){
            $news = $news_query->fetch_assoc();
            $tags = json_decode($news['tags'], true);
            
            $role = $roleNames[$news['role']] ?? $news['role'];
            $conn->query("UPDATE news SET views = views + 1 WHERE id = '$news_id'");
            require_once "view.php";
        } else {
            echo "<script>window.location.href = './';</script>";
        }
    }elseif(isset($_GET['cat'])){
        $cat_slug = $_GET['cat'];
        require_once "category.php";
        
    }elseif(isset($_GET['tag'])){
        $search_key = $_GET['tag'] ?? "";
        require_once "search.php";

    }elseif(isset($_GET['search'])){
        $search_key = $_GET['search'] ?? "";
        require_once "search.php";
    }else{
        echo "empty";
    }
?>