<?php 
    require_once "../root.php";

    if(isset($_GET['news'])){
        $news_id = $_GET['news'];
        $news_sql = "SELECT news.*, categories.name_bn as category_name FROM news JOIN categories ON news.category_id = categories.id WHERE news.id = '$news_id'";
        $news_query = $conn->query($news_sql);
        if($news_query->num_rows > 0){
            $news = $news_query->fetch_assoc();
            $logo = "../assets/img/logo.png";
            require_once "view.php";
        } else {
            //see all
        }
    }
?>