<?php

class PlayList{

  public function Analysis ($url, $store=false) {
    $originUrl = $url;
    $dir = "./public/";
    if (!file_exists($dir)) {
        mkdir($dir);
    }
    //为什么要用两次explode是因为url后也许还有参数
    $firstName = explode("?", $originUrl);
    $secondName= $firstName[1];
    $ThirdName = explode("=", $secondName);
    $lastName  = $ThirdName[1];                                //最后保存内容的文件名
    $url       = str_replace("#/","", $originUrl);
    $urlContent= file_get_contents($url);
    file_put_contents($dir.$lastName.".txt", $urlContent);
    $str  = file_get_contents($dir.$lastName.".txt");

    //匹配歌单名称
    //<title>武侠音乐系列第二部之思情篇（截取版） - 网易云音乐</title>
    $patt = '/<title>.*</';
    preg_match($patt, $str, $match);
    $listName = str_replace("<title>","",$match[0]);
    $listName = trim(str_replace("- 网易云音乐<","",$listName));   //歌单名称

    //<a href="/user/home?id=18009730" class="s-fc7">雨醉风尘</a>
    $pattId = '/a href="\/user\/home\?id=[1-9]{1}[0-9]{1,11}/';
    preg_match($pattId, $str, $match);
    $userIdInfo = explode("=", $match[0]);
    $user_id    = $userIdInfo[2];                //用户id
    $pattName   = '/class="s-fc7">.*</';
    preg_match($pattName, $str, $match);
    $userNameInfo = explode(">", $match[0]);
    $user_name  = str_replace("<", "", $userNameInfo[1]);
    $preg = '/<ul class="f-hide">.*?<\/ul>/ism';
    preg_match_all($preg, $str, $match);
    $songList = $match[0][0];
    $preg = '/<li>.*?<\/li>/ism';
    preg_match_all($preg, $songList, $match);
    $songAll  = $match[0];
    $songNum  = count($songAll);
    $userSongs= array();
    for ($i=0; $i < $songNum; $i++) {
      $str = preg_replace('/<li>/','',$songAll[$i]);
      $songName = preg_replace('/<\/li>/','',$str);
      //将歌曲的超链接去掉
      $delLink  = preg_match('/>.*</', $songName, $match);
      $songName = str_replace("<", "", $match[0]);
      $songName = str_replace(">", "", $songName);
      $patt  = preg_match('/[1-9]{1}[0-9]{1,}/', $songAll[$i], $match);
      $songId= $match[0];
      $userSongs[$songId] = $songName;
    }
    //将用户信息附加到歌单歌曲列表最后
    $userSongs['userid']   = $user_id;            //用户id
    $userSongs['username'] = $user_name;          //用户名称
    $userSongs['playlistname'] = $listName;       //歌单名称
    $userSongs['playlistid']   = $lastName;       //歌单id
    if (!$store) {
        unlink($dir.$lastName.".txt");
    }
    return $userSongs;

  }

  function similarDisplay ($percent) {
      if ($percent<=floatval("25%")) {
          $disInfo = "danger";
      } elseif ($percent<=floatval("50%")) {
          $disInfo = "warning";
      } elseif ($percent<=floatval("75%")) {
          $disInfo = "info";
      } else{
          $disInfo = "success";
      }
      return $disInfo;
  }

}

// $songList = new PlayList();
// $songList1=$songList->Analysis("http://music.163.com/#/playlist?id=39200354");
// $songList1=$songList->similarDisplay("35%");
// echo "<pre>";
// print_r($songList1);
