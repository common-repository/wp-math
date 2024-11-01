<?php


function wp_math($content){
  if(!get_option('wp_math_only_mail')){
    //echo $content;
    //die();
    $content = wp_math_inputs($content);    //functions.php * ads inputs from [form][/form]
   
    $content = wp_math_replace($content);   //functions.php * replace TinyMCE symbols with normal
    $content = wp_math_features($content);  //functions.php * features like ;n ;p: 
    $content = wp_math_gat_graphs($content);//graphs.php * replace [graph][/graph]
     //echo htmlspecialchars($content);
     //die();
    $content = wp_math_find_count_replace($content);  //core_functions.php * find all <m></m>  count them and replace with counted
    $content = str_replace(array("<x>","</x>"), array("<m>","</m>"), $content); // add static formulas to convert
    
    //*************************** USING PHPMATHPUBLISHER ***********************  
    $content = mathfilter("$content",get_option('wp_math_size'), WP_PLUGIN_URL."/wp-math/img/"); //replace all <m></m> with *.png
    }
  
  if(get_option('wp_math_mail')){$content = wp_math_mail($content);}
      
  return $content;
  }




?>