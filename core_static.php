<?php

function wp_math_save($content){
  
  if(strpos($content, 'static*all')){
    //$content = "find".$content;
    $content = wp_math_replace($content);
    $content = wp_math_find_count_replace($content);
    $content = str_replace(array("<m>","</m>"), array("&lt;x&gt;","&lt;/x&gt;"), $content);
    $content = str_replace("[static*all]", "", $content);
    $content = wp_math_replace($content,true);
    }
  else{
      preg_match_all("|\[static\](.*?)\[\/static\]|", $content, $static, PREG_SET_ORDER);
      for($i=0;$i<count($static);$i++){
        $content_count .= $static[$i][0];
        }
        
      $content_count = str_replace(array("[static]","[/static]",";"), array("[static]<m>","</m>[/static]","</m><m>"), $content_count);
      $content_count = wp_math_find_count_replace($content_count);
      $content_count = str_replace(array("<m>","</m>"),array("<x>","</x>"),$content_count);
      
      preg_match_all("|\[static\](.*?)\[\/static\]|", $content_count, $static_counted, PREG_SET_ORDER);
      for($i=0;$i<count($static_counted);$i++){
        $content = str_replace($static[$i][0],$static_counted[$i][0],$content);
        }
        
      
      preg_match_all("|\[static\](.*?)\[\/static\]|", $content, $static_final, PREG_SET_ORDER);
      for($i=0;$i<count($static_final);$i++){
        $t = $static_final[$i][1];
        $t = str_replace(array("</x><x>","<x>","</x>"), array(";","","") ,$t);
        
        
        $t_add = "";
        $t = explode(";",$t);
        for($j=0;$j<count($t);$j++){
          $t_final = explode("=",$t[$j]);
          if(count($t_final)==2){$t_add[$j] = " <m>".$t[$j]."</m> ";}
          else{$t_add[$j] = " <x>".$t[$j]."</x> <m>".$t_final[0]."=".$t_final[count($t_final)-1]."</m> ";}
          }
        
        $t = implode("",$t_add);    //toto tam len vlozit
        $content = str_replace("[static]".$static_final[$i][1]."[/static]",$t,$content);
        
        
        }
        
      
      
      
      $content = str_replace(array("<m>","</m>","<x>","</x>"), array("&lt;m&gt;","&lt;/m&gt;","&lt;x&gt;","&lt;/x&gt;"), $content);

      
      }                                            
  
  
  return $content;
  }   
?>