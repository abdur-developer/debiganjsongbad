<?php
    require_once 'admin/includes/config.php';
    require_once 'admin/includes/db.php';
    function timeAgo($datetime){
        $time = strtotime($datetime);
        $current = time();
        $diff = $current - $time;

        if($diff < 60){
            return $diff . " সেকেন্ড আগে";
        }

        $diff = floor($diff / 60);
        if($diff < 60){
            return $diff . " মিনিট আগে";
        }

        $diff = floor($diff / 60);
        if($diff < 24){
            return $diff . " ঘণ্টা আগে";
        }

        $diff = floor($diff / 24);
        if($diff < 7){
            return $diff . " দিন আগে";
        }

        $diff = floor($diff / 7);
        if($diff < 4){
            return $diff . " সপ্তাহ আগে";
        }

        $diff = floor($diff / 4);
        if($diff < 12){
            return $diff . " মাস আগে";
        }

        $diff = floor($diff / 12);
        return $diff . " বছর আগে";
    }
?>