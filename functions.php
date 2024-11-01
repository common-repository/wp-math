<?php
function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}



//***************************** CHECK FOR VALUE IN ARRAY *********************
//if value exist return true, else return false
function array_value_exist($value,$array){
  $find = false;
  if(in_array("$value", $array)){$find = true;}

  if($find){return true;}
  else{return false;}
  }

//*************************** ACTIVATION **************************************
function wp_math_activate() {
  add_option('wp_math_size', 18);        //font size
  add_option('wp_math_mail', 1);         //convert mail to png
  add_option('wp_math_only_mail', 0);    //convert only mail to png
  add_option('wp_math_round', 3);        //number decimal place
  add_option('wp_math_static', 1);       //enable/disable static
  }

//*************************** DEACTIVATION ************************************  
function wp_math_deactivate() {
	delete_option('wp_math_size');
	delete_option('wp_math_mail');
	delete_option('wp_math_only_mail');
	delete_option('wp_math_round');
	delete_option('wp_math_static');
	}


//**************************** convert e-mails to image *********************** 
function wp_math_mail($content){
  $size = get_option('wp_math_size');
  $content = preg_replace("/([a-zA-Z0-9\.-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z0-9]{1,3})/", '<m>\1</m>' , $content);
  $content = mathfilter("$content",$size, WP_PLUGIN_URL."/wp-math/img/",false);
  return $content;  
  }

//************************** REPLACE STRING ***********************************
function wp_math_replace($content,$reverse=false){
  $replace = array('&lt;m&gt;' => '<m>', '&lt;/m&gt;' => '</m>',
  '&lt;x&gt;' => '<x>', '&lt;/x&gt;' => '</x>', '–' => '-', 
  '&#8211;' => '-', '&lt;' => '<', '&gt;' => '>');
  if($reverse){
    $keys = array_keys($replace);
    $replace_reversed = "";
    for($i=0;$i<count($keys);$i++){
      $key = $keys[$i];
      $value = $replace["$key"];
      $replace_reversed["$value"] = "$key";
      }
    $replace = $replace_reversed;
    }                   

  $content = strtr($content, $replace);
  return $content; 
  }

//***************************** ADD/remov <m></m> ****************************
function wp_math_replace_tag($string,$find=";",$replace_with="<m>",$add=true){
  if($add){$string = str_replace($find,$replace_with,$string);}
  else{$string = str_replace($replace_with,$find,$string);}
  return $string;
  } 
  
function wp_math_remove($string,$find){
  return str_replace($find,"",$string);
  }
  
function wp_math_features($content){
  preg_match_all("|<m>(.*?)</m>|", $content, $regs, PREG_SET_ORDER);
  foreach($regs as $math){
    $t = $math[0];
    $t = str_replace(";","</m><m>",$t);
    $t = preg_replace("|(<m>p:)(.*?)(</m>)|",' \2 ',$t);
    $content = str_replace($math[0],$t,$content); 
    }
  $content = str_replace("<m>n</m>","<br />",$content);
  return $content;
  }
  
  
//******************** ADD INPUTS FROM FORM **********************************
function wp_math_inputs($content){
  if(isset($_POST["add_inputs"])){
    preg_match_all("|[a-zA-Z_]+=[0-9\.]+|", $_POST["inputs"], $regs, PREG_SET_ORDER);
     for($i=0;$i<count($regs);$i++){
      $inputs[$i] = $regs[$i][0];
      }
    $inputs = "Input Values:<br /><m>".implode("</m> <m>",$inputs)."</m>";
    $content = str_replace("[/form]","[/form] <br />$inputs<br /><br />",$content);
    }
  else{
    preg_match_all("|\[form\](.*?)\[\/form\]|", $content, $form, PREG_SET_ORDER);
    
    $form = "Default Values:<br /><m>".str_replace(";","</m> <m>",$form[0][1])."</m>";
  
    $content = str_replace("[/form]","[/form] <br />$form <br /><br />",$content);
    }
  return $content;
  }

?>