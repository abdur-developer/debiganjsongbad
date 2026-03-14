<?php 
    require_once "../root.php";

    if(isset($_GET['feed']) ){
        $news_id = $_GET['feed'];
        $news_sql = "SELECT 
        news.*, 
        categories.name_bn as category_name, 
        users.full_name , users.role, users.bio, users.avatar
        FROM news 
        JOIN categories ON news.category_id = categories.id 
        JOIN users ON news.author_id = users.id 
        WHERE news.id = '$news_id'
        ";
        $news_query = $conn->query($news_sql);
        if($news_query->num_rows > 0){
            $news = $news_query->fetch_assoc();
            $logo = "../assets/img/logo.png";
            $tags = json_decode($news['tags'], true);
            $roleNames = [
                'super_admin' => 'সুপার অ্যাডমিন',
                'admin' => 'অ্যাডমিন',
                'editor' => 'এডিটর',
                'reporter' => 'রিপোর্টার',
                'moderator' => 'মডারেটর'
            ];
            $role = $roleNames[$news['role']] ?? $news['role'];
            $conn->query("UPDATE news SET views = views + 1 WHERE id = '$news_id'");
            require_once "view.php";
        } else {
            //see all
        }
    }
?>