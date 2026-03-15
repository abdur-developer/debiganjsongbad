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
    
    function bn_num($value) {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        return str_replace($en, $bn, $value);
    }
    function bn_date($date) {
        $en = ['0','1','2','3','4','5','6','7','8','9','January','February','March','April','May','June','July','August','September','October','November','December','am','pm','AM','PM'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','পূর্বাহ্ণ','অপরাহ্ণ','পূর্বাহ্ণ','অপরাহ্ণ'];
        $formatted = date('j F Y, g:i A', strtotime($date));
        return str_replace($en, $bn, $formatted);
    }
    $roleNames = [
        'super_admin' => 'সুপার অ্যাডমিন',
        'admin' => 'অ্যাডমিন',
        'editor' => 'এডিটর',
        'reporter' => 'রিপোর্টার',
        'moderator' => 'মডারেটর'
    ];
?>