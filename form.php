<?php

  error_reporting(E_ALL & ~E_NOTICE);
  require_once('./playlist.php');
  require_once('./libs/Smarty.class.php');
  $smarty = new Smarty();
  $smarty->left_delimiter = "{";            //左定界符
  $smarty->right_delimiter= "}";            //右定界符
  $smarty->template_dir   = "tpl";          //html模板地址
  $smarty->compile_dir    = "template_c";   //编译生成的文件
  $smarty->cache_dir      = "cache";        //缓存
  $smarty->caching        = true;           //开启缓存
  $smarty->cache_lifetime = 120;            //缓存时间

  /*
  if(!isset($_POST['url1']) || empty($_POST['url1'])){
    header("Location: test.html?ecode=ue1");
    exit;
  }

  if(!isset($_POST['url2']) || empty($_POST['url2'])){
    header("Location: test.html?ecode=ue2");
    exit;
  }

  $url1 = $_POST['url1'];
  $url2 = $_POST['url2'];
  $patt = '/http:\/\/music\.163\.com\/#\/playlist\?id=[1-9]{1,}[0-9]{1,}/';
  preg_match($patt, $url1, $match);
  if (count($match[0])<1) {
      header("Location: test.html?ecode=ur1");
      exit;
  } else {
      $url1 = $match[0];
      setcookie('url1', $url1, time()+3600);
  }
  preg_match($patt, $url2, $match);
  if (count($match[0])<1) {
      header("Location: test.html?ecode=ur2");
      exit;
  } else {
      $url2 = $match[0];
      setcookie('url2', $url2, time()+3600);
  }
  */
  //url判断结束
  // $url1 = "http://music.163.com/#/playlist?id=18366105";
  // $url2 = "http://music.163.com/#/playlist?id=123784616";
  $url1 = isset($_POST['url1'])?$_POST['url1']:"http://music.163.com/#/playlist?id=8009";
  $url2 = isset($_POST['url2'])?$_POST['url2']:"http://music.163.com/#/playlist?id=3248614";
  $songList = new PlayList();
  $listUrl1 = $songList->Analysis($url1);
  $listUrl2 = $songList->Analysis($url2);
  $url1Compare = $listUrl1;
  $url2Compare = $listUrl2;
  $url1Num  = count($listUrl1)-4;
  $url2Num  = count($listUrl2)-4;
  $url1Per  = $url1Num >= $url2Num ? "100%" : intval(($url1Num/$url2Num)*100)."%";
  $url2Per  = $url2Num >= $url1Num ? "100%" : intval(($url2Num/$url1Num)*100)."%";
  if ($url1Compare['userid'] = $url2Compare['userid']){
      for ($i=0; $i < 4; $i++) {
           array_pop($url1Compare);
           array_pop($url2Compare);
      }
      $intersect= array_intersect_assoc($url1Compare, $url2Compare);
  } else{
      $intersect= array_intersect_assoc($listUrl1, $listUrl2);   //共同喜欢的音乐
  }

  $similar  = (count($intersect)*2)/($url1Num+$url2Num);
  $similarPer = $similar*100;
  $simiPro  = round($similarPer)."%";      //进度条css用
  $simiDis  = round($similarPer,2)."%";    //进度条显示用
  $url1DisplayInfo = $songList->similarDisplay($url1Per);
  $url2DisplayInfo = $songList->similarDisplay($url2Per);
  $unionDisplayInfo= $songList->similarDisplay($simiDis);

  $smarty->assign('listUrl1',$listUrl1);
  $smarty->assign('listUrl2',$listUrl2);
  $smarty->assign('url1Num',$url1Num);
  $smarty->assign('url2Num',$url2Num);
  $smarty->assign('url1Per',$url1Per);
  $smarty->assign('url2Per',$url2Per);
  $smarty->assign('intersectNum',count($intersect));
  $smarty->assign('url1DisplayInfo',$url1DisplayInfo);
  $smarty->assign('url2DisplayInfo',$url2DisplayInfo);
  $smarty->assign('unionDisplayInfo',$unionDisplayInfo);
  $smarty->assign('simiPro',$simiPro);
  $smarty->assign('simiDis',$simiDis);
  $smarty->assign('simiDis',$simiDis);
  $smarty->assign('intersect',$intersect);
  $smarty->display('test.html');

 ?>
