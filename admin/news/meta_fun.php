<?php 

// Clean text (remove HTML + extra space)
function cleanText($text){
    $text = strip_tags($text);
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/\s+/u', ' ', $text);
    return trim($text);
}

// Meta Title
function getMetaTitle($title_bn, $title_en){
    $title_bn = cleanText($title_bn);
    $title_en = cleanText($title_en);

    if(!empty($title_bn) && !empty($title_en)){
        return $title_bn . " | " . $title_en;
    } elseif(!empty($title_bn)){
        return $title_bn;
    } else {
        return $title_en;
    }
}

// Meta Description (max ~160 chars)
function getMetaDescription($content){
    $content = cleanText($content);

    // বাংলা safe substring
    if(mb_strlen($content, 'UTF-8') > 160){
        return mb_substr($content, 0, 157, 'UTF-8') . "...";
    }
    return $content;
}

// Meta Keywords
function getMetaKeywords($title_bn, $title_en, $content){
    $text = cleanText($title_bn . " " . $title_en . " " . $content);

    // Split words (বাংলা + ইংরেজি)
    preg_match_all('/[\p{L}\p{N}]+/u', $text, $matches);

    $words = $matches[0];

    // ছোট শব্দ বাদ দেওয়া
    $filtered = array_filter($words, function($word){
        return mb_strlen($word, 'UTF-8') > 3;
    });

    // frequency count
    $freq = array_count_values($filtered);

    // sort by frequency
    arsort($freq);

    // top 10 keywords
    $keywords = array_slice(array_keys($freq), 0, 10);

    return implode(", ", $keywords);
}

?>