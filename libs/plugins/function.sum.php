<?php

function smarty_function_sum($params){

     $arr = func_get_args();
     echo array_sum($arr[0]);

}

 ?>
