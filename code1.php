<?php

    $originUrl = "http://music.163.com/#/playlist?id=123784616";
    $firstName = explode("?", $originUrl);
    $secondName= $firstName[1];
    $ThirdName = explode("=", $secondName);
    $lastName  = $ThirdName[1];                                //最后保存内容的文件名
    $url       = str_replace("#/","", $originUrl);
    $urlContent= file_get_contents($url);
    file_put_contents($lastName.".txt", $urlContent);
    $str = file_get_contents($lastName.".txt");

    $preg = '/<ul class="f-hide">.*?<\/ul>/ism';
    preg_match_all($preg, $str, $match);
    $songList = $match[0][0];
    $preg = '/<li>.*?<\/li>/ism';
    preg_match_all($preg, $songList, $match);
    $songAll = $match[0];
    $songNum = count($songAll);
    for ($i=0; $i < $songNum; $i++) {
        $str = preg_replace('/<li>/','',$songAll[$i]);
        $songName = preg_replace('/<\/li>/','',$str);
        // <a href="/song?id=201885">
        $patt  = preg_match('/[1-9]{1}[0-9]{1,}/', $songAll[$i], $match);
        $songId= $match[0];
        echo $songId."---".$songName."<br/>";
    }

 ?>
