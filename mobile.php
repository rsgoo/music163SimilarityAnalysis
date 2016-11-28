<?php

  require_once('./playlist.php');

  $url1 = isset($_REQUEST['url1'])?$_REQUEST['url1']:"http://music.163.com/#/playlist?id=18366105";
  $url2 = isset($_REQUEST['url2'])?$_REQUEST['url2']:"http://music.163.com/#/playlist?id=8009";
  $songList = new PlayList();
  $listUrl1 = $songList->Analysis($url1);
  $listUrl2 = $songList->Analysis($url2);
  $url1Compare = $listUrl1;
  $url2Compare = $listUrl2;
  $url1Num  = count($listUrl1)-4;
  $url2Num  = count($listUrl2)-4;
  $url1Per  = $url1Num >= $url2Num ? "100%" : round(($url1Num/$url2Num)*100,2)."%";
  $url2Per  = $url2Num >= $url1Num ? "100%" : round(($url2Num/$url1Num)*100,2)."%";
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
  if ($listUrl1['playlistname'] == "网易云音乐<") {
      $listUrl1['playlistname'] = "该歌单不存在";
      $listUrl1['username']     = "";
  }
  if ($listUrl2['playlistname'] == "网易云音乐<") {
      $listUrl2['playlistname'] = "该歌单不存在";
      $listUrl2['username']     = "";
  }
  $intersectNum = count($intersect);

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title>网易云音乐歌单音乐相似度分析</title>
 	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
 	<link rel="stylesheet" href="./libs/css/main.css">
 	<link rel="shortcut icon" href="./libs/img/dongdong11019.ico" />
 	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
 	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
   <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>
   <script src="./libs/js/additional-methods.js"></script>
   <script type="text/javascript">
 	  // $.validator.setDefaults({
 	  //   submitHandler: function() {
 	  //     alert("提交事件!");
 	  //   }
 	  // });
 	  $().ready(function() {
 	    $("#commentForm").validate();
 	  });
 		$().ready(function() {
 			$("#signupForm").validate({  // 在键盘按下并释放及提交后验证提交表单
 			});
 		});
   </script>
 </head>
 <body>
   <div class="container">
     <div class="div1 ">
       <form id="signupForm" class="form-horizontal marginTop20" action="mobile.php" method="post" role="form" >
       <div class="form-group">
         <label for="firstname" class="col-sm-2 control-label pull-left">歌单一URL:</label>
         <div class="col-sm-6">
           <input required type="music163url" name="url1" class="form-control black" id="firstname" value="http://music.163.com/#/playlist?id=?">
         </div>
       </div>
       <div class="form-group">
         <label for="lastname" class="col-sm-2 control-label">歌单二URL:</label>
         <div class="col-sm-6">
           <input required type="music163url" name="url2" class="form-control black" id="lastname" value="http://music.163.com/#/playlist?id=?">
         </div>
       </div>
       <div class="form-group">
         <div class="col-sm-2 col-sm-offset-2">
           <button type="submit" class="btn btn-primary btn-block">分 析</button>
         </div>
       </div>
       </form>
     </div>
     <h4 class="">分析结果</h4>
     <div class="div2 marginTop20">
       <div>
           <a href="http://music.163.com/#/playlist?id=<?php echo $listUrl1['playlistid']; ?>" target="_blank">
              <button class="btn">歌单一名称：<?php echo $listUrl1['playlistname'];?></button>
           </a>
           <a href="http://music.163.com/#/user/home?id=<?php echo $listUrl1['userid']; ?>" target="_blank">
             <button class="btn">Via：<?php echo $listUrl1['username'];?></button>
           </a>
 					<a href="http://music.163.com/#/playlist?id=<?php echo $listUrl1['playlistid']; ?>" target="_blank">
             <button class="btn">包含歌曲：<?php echo $url1Num;?>首</button>
           </a>
       </div>
       <div class="progress height25">
         <div class="progress-bar progress-bar-<?php echo $url1DisplayInfo; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
         style='width: <?php echo $url1Per;?>'>
           <span class="pull-left  height25">(<?php echo $url1Per;?>)</span>
         </div>
       </div>
     </div>
     <div class="div2 marginTop20">
       <div>
           <a href="http://music.163.com/#/playlist?id=<?php echo $listUrl2['playlistid'];?>" target="_blank">
              <button class="btn">歌单二名称：<?php echo $listUrl2['playlistname'];?></button>
           </a>
           <a href="http://music.163.com/#/user/home?id=<?php echo $listUrl2['userid'];?>" target="_blank">
             <button class="btn">Via：<?php echo $listUrl2['username'];?></button>
           </a>
 					<a href="http://music.163.com/#/playlist?id=<?php echo $listUrl2['playlistid'];?>" target="_blank">
             <button class="btn">包含歌曲：<?php echo $url2Num;?>首</button>
           </a>
       </div>
       <div class="progress height25">
         <div class="progress-bar progress-bar-<?php echo $url2DisplayInfo;?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
         style='width: <?php echo $url2Per;?>'>
           <span class="pull-left  height25">(<?php echo $url2Per;?>)</span>
         </div>
       </div>
     </div>
     <div class="div2 marginTop20">
       <div>
         <button class="btn">
           共同收藏歌曲数量：<?php echo  $intersectNum;?>首
         </button>
         <button class="btn">
           相似度<?php echo $simiDis;?>
         </button>
       </div>
       <div class="progress height25">
         <div class="progress-bar progress-bar-<?php echo $unionDisplayInfo;?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
         style='width: <?php echo $simiPro;?>'>
           <span class="pull-left  height25" style="color:black;"><?php echo $simiDis;?></span>
         </div>
       </div>
     </div>
     <div class="div3 col-sm-4" style="text-indent:-5px;">
       <h4>共同音乐列表<small style="color:#d9534f">&nbsp;(注：如无法播放可能是因为版权不允许)</small></h4>
       <?php
         foreach ($intersect as $key=>$value) {
           echo "<div>";
               echo "<p class='text-primary'><a href='http://music.163.com/#/song?id={$key}'><span class='glyphicon glyphicon-music'></span>{$value}</a></p>";
           echo '</div>';
         }
        ?>
     </div>
 </body>
 </html>
