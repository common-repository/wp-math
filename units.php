<?php
function wp_math_units($content){
  $deg = pi()/180;
  $units = array(
    " Pa" => "*1",
    " kPa" => "*1000",
    " MPa" => "*1000000",
    " GPa" => "*1000000000",
    " deg" => "*$deg",
    " rad" => "*1",
    " km" => "*1000",
    " m" => "*1",
    " dm" => "*0.1",
    " cm" => "*0.01",
    " mm" => "*0.001",
    " s" => "*1",
    " min" => "*60",
    " hr" => "*3600");
    
  $content = strtr($content,$units);
  return $content;
  }



?>