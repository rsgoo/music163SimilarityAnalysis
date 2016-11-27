<?php

  require_once('./playlist.php');
  $songList = new PlayList();
  $listUrl1 = $songList->Analysis("http://music.163.com/#/playlist?id=18366105");
  $listUrl2 = $songList->Analysis("http://music.163.com/#/playlist?id=475155508");
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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bootstrap 实例 - 基本表单</title>
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="div1 ">
      <form class="form-horizontal marginTop20" action="form.php" method="post" role="form" >
      <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label pull-left">歌单一URL:</label>
        <div class="col-sm-4">
          <input type="text" name="url1" class="form-control" id="firstname" placeholder="请输入第一个歌单链接地址">
        </div>
      </div>
      <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">歌单二URL:</label>
        <div class="col-sm-4">
          <input type="text" name="url2" class="form-control" id="lastname" placeholder="请输入第二个歌单链接地址">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-1 col-sm-offset-2">
          <button type="submit" class="btn btn-primary btn-block">分 析</button>
        </div>
      </div>
      </form>
    </div>
    <h4 class="col-sm-offset-1">分析结果</h4>
    <div class="div2 marginTop20 col-sm-offset-1">
      <div>
          <a href="http://music.163.com/#/playlist?id=<?php echo $listUrl1['playlistid']; ?>" target="_blank">
             <button class="btn">歌单一名称：<?php echo $listUrl1['playlistname']; ?></button>
          </a>
          <a href="http://music.163.com/#/user/home?id=<?php echo $listUrl1['userid']; ?>" target="_blank">
            <button class="btn">Created By：<?php echo $listUrl1['username']; ?></button>
          </a>
      </div>
      <div class="progress height25">
        <div class="progress-bar progress-bar-<?php echo $url1DisplayInfo; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
        style='width: <?php echo "$url1Per"; ?>'>
          <span class="pull-left  height25">歌曲总数：<?php echo $url1Num."首&nbsp; (".$url1Per.")"; ?></span>
        </div>
      </div>
    </div>
    <div class="div2 marginTop20 col-sm-offset-1">
      <div>
          <a href="http://music.163.com/#/playlist?id=<?php echo $listUrl2['playlistid']; ?>" target="_blank">
             <button class="btn">歌单二名称：<?php echo $listUrl2['playlistname']; ?></button>
          </a>
          <a href="http://music.163.com/#/user/home?id=<?php echo $listUrl2['userid']; ?>" target="_blank">
            <button class="btn">Created By：<?php echo $listUrl2['username']; ?></button>
          </a>
      </div>
      <div class="progress height25">
        <div class="progress-bar progress-bar-<?php $url1DisplayInfo; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
        style='width: <?php echo "$url2Per"; ?>'>
          <span class="pull-left  height25">歌曲总数：<?php echo $url2Num."首&nbsp; (".$url2Per.")"; ?></span>
        </div>
      </div>
    </div>
    <div class="div2 marginTop20 col-sm-offset-1">
      <div>
        <button class="btn">
          <?php echo "共同收藏歌曲数量：".count($intersect)."首"; ?>
        </button>
        <button class="btn">
          <?php echo "相似度：".$simiDis ?>
        </button>
      </div>
      <div class="progress height25">
        <div class="progress-bar progress-bar-<?php echo $unionDisplayInfo; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
        style='width: <?php echo "$simiPro"; ?>'>
          <span class="pull-left  height25" style="color:black;"><?php echo $simiDis; ?></span>
        </div>
      </div>
    </div>
    <div class="div3 col-sm-4  col-sm-offset-1">
      <h4>共同音乐列表<small style="color:#d9534f">&nbsp;(注：如无法播放可能是因为版权不允许)</small></h4>
      <?php

        foreach ($intersect as $key => $value) {
          echo "<div>";
            echo "<span>";
              echo "<embed src='http://music.163.com/style/swf/widget.swf?sid={$key}&type=2&auto=0&width=320&height=66' width='340' height='86'  allowNetworking='all'></embed>";
            echo "<span>";
          echo "</div>";
        }

       ?>
      <!-- <div class="">
        <span><embed src="http://music.163.com/style/swf/widget.swf?sid=34775161&type=2&auto=0&width=320&height=66" width="340" height="86"  allowNetworking="all"></embed></span>
      </div> -->
    </div>
</body>
</html>
