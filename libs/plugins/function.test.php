<?php

  function smarty_function_test($params){
    $width  = $params['width'];
    $height = $params['height'];
    return $width*$height;
  }

 ?>
