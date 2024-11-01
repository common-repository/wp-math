<?php
//*********************** BEGIN REPLACE ARRAY *******************************
  $replace = array(
  '$abs(' => 'abs(',
  '$min(' => 'min(', 
  '$max(' => 'max(', 
  '$floor(' => 'floor(',
  '$Floor(' => 'floorx(', 
  '$round(' => 'round(',
  '$Round(' => 'roundx(',  
  '$ceil(' => 'ceil(',
  '$Ceil(' => 'ceilx(',
  '$acos(' => 'acos(',
  '$acosh(' => 'acosh(',
  '$asin(' => 'asin(',
  '$asinh(' => 'asinh(',
  '$atantwo(' => 'atan2(',
  '$atan(' => 'atan(',
  '$atanh(' => 'atanh(',
  '$base_convert(' => 'base_convert(',
  '$bindec(' => 'bindec(',
  
  '$cos(' => 'cos(',
  '$cosh(' => 'cosh(',
  '$decbin(' => 'decbin(',
  '$dechex(' => ' dechex(',
  '$decoct(' => 'decoct(',
  '$degtorad(' => 'deg2rad(',
  '$exp(' => 'exp(',
  '$expmone(' => 'expm1(',
  
  '$fmod(' => 'fmod(',                     
  '$getrandmax(' => 'getrandmax(',
  '$hexdec(' => 'hexdec(',
  '$hypot(' => 'hypot(',
  '$isfinite(' => 'is_finite(',
  '$isinfinite(' => 'is_infinite(',
  '$isnan(' => 'is_nan(',
  '$lcgvalue(' => 'lcg_value(',
  '$log(' => 'logax(',
  '$logonep(' => 'log1p(',
  '$ln(' => 'log(',
  
  '$mtgetrandmax(' => 'mt_getrandmax(',
  '$mtrand(' => 'mt_rand(',
  '$mtsrand(' => 'mt_srand(',
  '$octdec(' => 'octdec(',
  '$pi' => 'pi()',
  '$pow(' => 'pow(',
  '$radtodeg(' => 'rad2deg(',
  '$rand(' => 'rand(',
  '$Rand(' => 'randx(',
  '$sin(' => 'sin(',
  '$sinh(' => 'sinh(',
  '$sqrt(' => 'sqrt(',
  '$srand(' => 'srand(',
  '$tan(' => 'tan(',
  '$cot(' => 'cot(',
  '$tanh(' => 'tanh(',
  );

function wp_math_functions_replace($content){
  global $replace;
  
  $content = strtr($content, $replace); 
  return $content; 
  }

function wp_math_check_for($content){
  global $replace;
  
  $check_for = array_keys($replace);
  $check_for = implode(";",$check_for);
  $check_for = str_replace(array("$","("),array("",""),$check_for);
  $check_for = explode(";",$check_for);
  return in_array("$content",$check_for);
  }

//*********************** MATH FUNCTIONS *******************************

function floorx($content,$number){
  $content = floor($content/$number)*$number;
  return $content;
  }

function ceilx($content,$number){
  $content = ceil($content/$number)*$number;
  return $content;
  }

function roundx($content,$number){
  $content = round($content/$number)*$number;
  return $content;
  }  

function randx($size){
  $array = array("0","1","2","3","4","5","6","7","8","9");
  for($i=0;$i<$size;$i++){
    $content .= $array[rand(0,9)];
    }
  return $content;
  }

function cot($content){
  $content = 1/tan($content);
  return $content;
  }  

function logax($content,$base=10){
  if($base == 10){$content = log10($content);}
  else{$content = log10($content)/log10($base);}
  return $content;
  }   
                                 
//************************** POW FUNCTION REPLACER ****************************

function wp_math_implemented_functions($content){
  $content = wp_math_pow_replacer($content); 
  $content = wp_math_root_replacer($content); 
  return $content;
  }
  
function wp_math_pow_replacer($content){
  $content = preg_replace("/([\w()]+)(\^)([\w()\.\/]+)/",'pow(\1,\3)',$content);
  return $content;
  }




function wp_math_root_replacer($content){
  $content = preg_replace("/root\(([0-9\.]+)\)\((.*?)\)/",'pow(\2,1/\1)',$content);
  $content = str_replace('$pow(','pow(',$content);
  return $content;
  }


?>