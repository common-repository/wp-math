<?php
function wp_math_form($atts, $content = null) {
  $height = count(explode(";",$content))*25;
  $content_session = "<m>".str_replace(array('<p>','</p>',';'),array('','',"</m><m>"),$content)."</m>";
  $content =  str_replace(array('<p>','</p>',';'),array('','',"\n"),$content);
  
  $_SESSION['wp_math_form'] = $content_session;
  
  if(isset($_POST["add_inputs"])){
    $content = $_POST["inputs"];
    }
  $content =  "<a name=\"form\"></a><form method=\"post\" action=\"#form\"><textarea name=\"inputs\" style=\"height: ".$height."px; width: 250px;\">$content</textarea><br /><input type=\"submit\" value=\"Count\" name=\"add_inputs\">";
  
  return $content;
  }
  
function wp_math_static($atts,$content=null){
  //return $atts;
  }

  
?>