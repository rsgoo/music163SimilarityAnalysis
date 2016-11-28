<?php

function smarty_block_word($params, $content){
    $type = $params['type'];
    if ($type == 'ucfirst') {
       $str = ucfirst($content);
    } else {
       $str = ucwords($content);
    }
    return $str;
}


 ?>
