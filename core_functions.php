<?php
//*********************FIND AND REPLACE *************************************
function wp_math_find_count_replace($content) {


	preg_match_all("|<m>(.*?)</m>|", $content, $regs, PREG_SET_ORDER);
	
	foreach($regs as $math){
				
		$code = $math[0];
		$code = str_replace(array("<m>", "</m>"), array("",""), $code);
		
    if(strpos($code,"graph:") === FALSE){
    
    preg_match_all("/matrix{[0-9]+}{[0-9]+}{(.*?)}/", $code, $matrix_rebuild, PREG_SET_ORDER);
    foreach($matrix_rebuild as $matrix_new){
      //echo "<br>";
      //echo $matrix_new[0];
      preg_match_all("/{(.*?)}/", $matrix_new[0], $t_values, PREG_SET_ORDER);
      $i_stop = $t_values[0][1];
      $j_stop = $t_values[1][1];
      $values = $t_values[2][1];
      $values = "{".str_replace(" ", "} {", $values)."}";
      $values = "delim{[}{matrix{".$i_stop."}{".$j_stop."}{".$values."}}{]}";
      $code = str_replace($matrix_new[0], $values, $code);

      //print_r($matrix_new); 
      }
    
    
    
    $string = str_replace(array ('<m>', '</m>', '{', '}'), array('', '', '(', ')'), $math [0]);
		
		$double_equal = strpos( $string, "==");
		$count_equal = substr_count( $string, '=');
		$string_exploded = explode( "=", $string);
		
		if($string_exploded[count($string_exploded)-1] == ""){
      $add_result = true;
      }
    else{
      $add_result = false;
      }
    
    
		
		//print_r($string_exploded);
		//echo "<br>";
		
		$add_variable = false;
		$show_variable = false;
		//echo $string;
		if($double_equal === false){ //niesu tam dve rovnasa pri sebe
			if($count_equal == 1){ //je tam len jedno rovna sa
				if(strpos($string_exploded[0], '+') === false && strpos($string_exploded[0], '-') === false && strpos($string_exploded[0], '*') === false && strpos($string_exploded[0], '/') === false && strpos($string_exploded[0], '(') === false){ //je tam len premenna a=10;
				  //echo "a=10";
					$add_variable = true;
					$show_variable = true;
					$string_exploded [1] = "(" . $string_exploded [1] . ")";
				  } 
        else { //je tam vypocet         a+b=
					$string_exploded [0] = "(" . $string_exploded [0] . ")";
				  //echo "a+b=";
		//echo "just variable";
				  }
			
			 } 
      elseif ($count_equal == 2) { //su tam dve rovnasa     a=d+s=
				$string_exploded [1] = "(" . $string_exploded [1] . ")";
				$add_variable = true;
			  }
		  } 
    else { //su tam dve rovnasa prisebe
			if ($count_equal == 2) {
				if (strpos ( $string, '+' ) === false && strpos ( $string, '-' ) === false && strpos ( $string, '*' ) === false && strpos ( $string, '/' ) === false && strpos ( $string, '(' ) === false) { //je tam len premenna a==
					$double_equal = true;
					$add_variable = true;
				  } 
        else { //je tam vypocet a+b==
					$inputs = $string_exploded [0];
					$string_exploded [0] = "(" . $string_exploded [0] . ")";
				  }
			 } 
      elseif ($count_equal == 3) { //je tam  a=b+c==
				$inputs = $string_exploded [1];
				$string_exploded [1] = "(" . $string_exploded [1] . ")";
				$add_variable = true;
			  }
	   }
		
		$string = implode ( "=", $string_exploded );
		$string = str_replace ( "==", "=", $string );
		
		//echo $string;
		//echo "<br>";

		
		$string = preg_replace("/matrix\(([\d]+)\)\(([\d]+)\)\((.*?)\)/", 'matrix{\1}{\2}{\3}', $string);
		$string = preg_replace("/([a-zA-z]+)\((.*?)\)/", '\1{\2}', $string);
		
		
		
    preg_match_all("/matrix{[0-9]+}{[0-9]+}{(.*?)}/", $string, $regs, PREG_SET_ORDER);
    $k = 0;
    foreach($regs as $t){
      preg_match_all("/{(.*?)}/", $t[0], $t_values, PREG_SET_ORDER);
      $i_stop = $t_values[0][1];
      $j_stop = $t_values[1][1];
      $values = $t_values[2][1];
      $values = explode(" ", $values);
      $z = 0;
      for($i=0;$i<$i_stop;$i++){
        for($j=0;$j<$j_stop;$j++){
          //echo $values[$z]."<br>";
          $matrix_values = $values[$z++];
          $matrix_values = preg_replace("/([a-zA-Z_]+)/",'$\1',$matrix_values);
          $matrix_values = "\$matrix_values = $matrix_values;";
          eval($matrix_values);
          //echo $matrix_values."<br>";
          $matrix[$i][$j] = $matrix_values;
          }
        }               
      //print_r($matrix);
      $matrix_asdfghjklqwertzuiop[$k] = $matrix;
      $string = str_replace($t[0], "matrix_asdfghjklqwertzuiop[$k]",$string);
      $k++;
      }    
      	
		//print_r($matrix_asdfghjklqwertzuiop[0]);
		//echo $string."<br>";
		
		$lenght = strlen ( $string );
		
		$uroven = 0;
		$uroven_max = 0;
		$zatvorka = 0;
		$j = 0;
		
		$begin = 0;
		$end = 0;
		
		
		 //echo $lenght;
		 //echo "<br>";
		//zisti strukturu a ocisluje zatvorky
		$string_structure = "";
		for($i = 0; $i < $lenght; $i ++) {
			if ($string [$i] == "(") {
				$string_structure [$j ++] = array ('position' => $i, 'uroven' => $uroven ++, 'zatvorka' => $zatvorka ++ );
				$begin ++;
			  } 
      elseif ($string [$i] == ")") {
        //echo "end";
				$uroven --;
				if ($uroven_max < $uroven) {
					$uroven_max = $uroven;
				  }
				$end ++;
			 }
		  }
		
		//echo "$begin .... $end <br>";
		//skontroluje či sedia počty zátvoriek
		if ($begin < $end) {
			die ( "chyba zaciatok zatvoriek" );
		  } 
    elseif ($begin > $end) {
			die ( "chyba koniec zatvoriek" );
		  }    
		
		//zoradí zatvorky podla úrovne. od najvyssej po najnizsiu
		$string_structure_order = "";
    $z = 0;
		for($i = $uroven_max; $i >= 0; $i --) {
			for($j = 0; $j < count ( $string_structure ); $j ++) {
				if ($string_structure [$j] ["uroven"] == $i) {
					$string_structure_order [$z ++] = $string_structure [$j];
				  }
			  }
		  }
		//print_r($string_structure_order);
		//echo "<br>";
		//oddeli jednotlive zatvorky a od najvnutornejsich ich spocita
		$string_partial = "";
		
		for($i = 0; $i < count ( $string_structure_order ); $i ++) {
			$position = $string_structure_order [$i] ["position"];
			
			$next = 0;
			//echo "for(\$j = $position; \$j < $lenght; \$j ++)<br>";
			for($j = $position; $j < $lenght; $j ++) {
				//echo $string;
        $string_partial [$i] .= $string [$j];
				if ($string [$j] == "(" || $string [$j] == "{") {
					$next ++;
				  }
				elseif($string [$j] == ")" || $string [$j] == "}") {
					$next --;
				  }
				
				if($next == 0){
					for($k = 0; $k < count ( $string_partial ) - 1; $k ++) {
					 $string_partial [$i] = str_replace ( $string_partial [$k], "vysledok[$k]", $string_partial [$i] );
					 }
					
					
					//echo ($string_partial [$i]);
					//echo "<br>\$s_array : ";
					$s_array = make_math_array ( $string_partial [$i] );  //
					
          //print_r($s_array);
					//echo "<br>--------------------------------<br>";
					$n_medzi = 0;
					$medzi_vysledok = "";
					for($f = 0; $f < count ( $s_array ); $f ++) {
						//echo '$s_array [$f]'.$s_array [$f]."<br>";
						if ($s_array [$f] == "*") {
							$vzorec = "\$medzi_vysledok[$n_medzi] = wp_math_multiply(" . $s_array [$f - 1] . "," . $s_array [$f + 1] . ");";
							//echo "<br>";
              eval ( $vzorec );
							$s_array [$f - 1] = "\$medzi_vysledok[$n_medzi]";
							$s_array [$f + 1] = "\$medzi_vysledok[$n_medzi]";
							
              //echo "--> \$medzi_vysledok[$n_medzi] = ".$medzi_vysledok[$n_medzi]."<br>";
              //$n_medzi++; 
						  } 
            elseif ($s_array [$f] == "/") {
							$vzorec = "\$medzi_vysledok[$n_medzi] = wp_math_divide(" . $s_array [$f - 1] . "," . $s_array [$f + 1] . ");";
							//echo "<br>";
              eval ( $vzorec );
							$s_array [$f - 1] = "\$medzi_vysledok[$n_medzi]";
							$s_array [$f + 1] = "\$medzi_vysledok[$n_medzi]";
							//echo "--> \$medzi_vysledok[$n_medzi] = ".$medzi_vysledok[$n_medzi]."<br>";
							//$n_medzi++; 
						  }
						elseif($s_array [$f] == "+" || $s_array [$f] == "-"){
              $n_medzi++; 
              }
					  }
					$scitanie = 0;
					for($f = 0; $f < count ( $s_array ); $f ++){
						if ($s_array [$f] == "+"){
						  if($scitanie ===0){
  							$vzorec = "\$medzi_vysledok_static = wp_math_add(" . $s_array [$f - 1] . "," . $s_array [$f + 1] . ");";
  							//echo "<br>";
                eval ( $vzorec );
  							$s_array [$f - 1] = "\$medzi_vysledok_static";
  							$s_array [$f + 1] = "\$medzi_vysledok_static";
  							//echo "--> \$medzi_vysledok_static = ".$medzi_vysledok_static."<br>";
  							//$n_medzi++; 
                $scitanie++; 
  						  }
  						else{
                $vzorec = "\$medzi_vysledok_static = wp_math_add(" . $medzi_vysledok_static . "," . $s_array [$f + 1] . ");";
  							//echo "<br>";
                eval ( $vzorec );
  							$s_array [$f - 1] = "\$medzi_vysledok_static";
  							$s_array [$f + 1] = "\$medzi_vysledok_static";
  							//echo "--> \$medzi_vysledok_static = ".$medzi_vysledok_static."<br>";
  							//$n_medzi++; 
                }
              } 
            elseif ($s_array[$f] == "-"){
							if($scitanie ===0){
                $vzorec = "\$medzi_vysledok_static = wp_math_subtract(\"" . $s_array [$f - 1] . "\" , " . $s_array [$f + 1] . ");";
  							//echo "<br>";
                eval ( $vzorec );
  							$s_array [$f - 1] = "\$medzi_vysledok_static";
  							$s_array [$f + 1] = "\$medzi_vysledok_static";
  							//echo "--> \$medzi_vysledok_static = ".$medzi_vysledok_static."<br>"; 
  							//$n_medzi++;
  							$scitanie++; 
  							}
  						else{
                $vzorec = "\$medzi_vysledok_static = wp_math_subtract(\"" . $medzi_vysledok_static . "\" , " . $s_array [$f + 1] . ");";
  							//echo "<br>";
                eval ( $vzorec );
  							$s_array [$f - 1] = "\$medzi_vysledok_static";
  							$s_array [$f + 1] = "\$medzi_vysledok_static";
  							//echo "--> \$medzi_vysledok_static = ".$medzi_vysledok_static."<br>"; 
  							//$n_medzi++;                
                
                }
						  }
					
            if(count($s_array) === 1){
              //echo "$string_exploded[0]";
					    if($s_array[0] == ""){
                $vzorec = "\$medzi_vysledok[$n_medzi] = \$$string_exploded[0];";
                //echo "dosad";
                }
              else{
                //print_r($s_array); 
                $vzorec = "\$medzi_vysledok[$n_medzi] = $s_array[0];";
                }
              eval($vzorec);
                                         						  
              }
               
					   }
					//echo $scitanie;
					//echo $n_medzi;
					if($scitanie == 0){
					 $vysledok[$i] = $medzi_vysledok[$n_medzi];
					 }
					else{
            $vysledok[$i] = $medzi_vysledok_static;
            }
					//echo $medzi_vysledok."<br>";
          break;
          }
			 }
			//echo $a; 
			//print_r($string_exploded);
			if($add_variable === true){
			  $new_variable = "\$$string_exploded[0] = \$vysledok[$i];";
        eval($new_variable);
        }
      //echo $medzi_vysledok ; 
			$final_result = wm_math_result ( $vysledok[$i] );
			//$final_result = $medzi_vysledok;
			//echo "$a";
		  }
		//echo $medzi_vysledok;        //vysledok
		//echo $code."<br>";

		if($add_result == true){
  		  //echo "true";
        if ($double_equal === false) {
    		  $code = " <m>".$code.$final_result."</m> ";
    		  }
        else {
          $inputs_array = make_math_array($inputs);
          
    			$inputs = preg_replace ( "/([a-zA-Z_]+)/", '$\1', $inputs );
    			
    			for($i=0;$i<count($inputs_array);$i++){
            if($inputs_array[$i] != "+" && $inputs_array[$i] != "-" && $inputs_array[$i] != "*" && $inputs_array[$i] != "/"){
              $input_result = "\$input_result = $inputs_array[$i];";
              eval($input_result);
              $input_result = wm_math_result($input_result);
              //echo $inputs;
              
              $inputs = str_replace($inputs_array[$i], $input_result, $inputs);
              }
            }
    			//print_r($inputs_array);
    			
    			
    			$inputs = "\$inputs = \"" . $inputs . "\";";
    			eval ( $inputs );
    			$code = str_replace ( "==", "=", $code );
    			$code = " <m>" . $code . $inputs . "=" . $final_result . "</m> ";
    		  }
        }
      else{
        $code = " <m>".$code."</m> ";
        }
	   }
	 //************************ ADD GRAPHS ***********************************
   else{
      $code = str_replace("graph:", "", $code);
      $md5 = stristr($code, "\$md5");
      $md5 = str_replace("\$md5 = ","",$md5);
      
      $code = stristr($code, "\$md5", TRUE); 
      
      $md5 = explode(" ",$md5);
      for($i=0;$i<count($md5);$i++){
        $md5_array = stristr($md5[$i], "\$");
        if($md5_array != ""){
          $new_string_md = "\$new_string_md = $md5_array";
          eval($new_string_md);
          for($j=0;$j<count($new_string_md);$j++){
            $md5_final .= $new_string_md[$j];
            }
          }
        else{
          $md5_final .= $md5[$i];
          }  
        }
      eval($code);
      $md5 = wp_math_graphs($title,$values_final,$axis_x,$axis_y,$md5_final);
      $home_url = get_home_url();
      $content = str_replace($math[0],"<img src='$home_url/wp-content/plugins/wp-math/graphs/$md5.png' title='$title' alt='$title'>",$content);
      }
   
   //echo $math[0]." -> ".$code."<br><br><br>";
   $content = str_replace_first($math[0], $code, $content);
	
	 }
	 //print_r($a);
	//wp_math_graphs(); 
	return $content;
  }

function make_math_array($string) {
	
  $string = str_replace ( array ("(", ")" ), array ("", "" ), $string );
	$string = preg_replace ( "/([a-zA-Z_]+)/", '$\1', $string );
	
	
	$string = preg_replace ( "/([a-zA-z]+)\{(.*?)\}/", '\1(\2)', $string ); //************************
	
  $string = wp_math_functions_replace($string);
	$string = wp_math_implemented_functions($string);
	
	$n = 0;
	//echo 10*-5;
  $s_array[0] = "";
	$zatvorka = 0;
	$s_leng = strlen ( $string );
	
	for($j = 0; $j < $s_leng; $j ++) {
		//echo $string [$j];
		//echo "<br>";
    if ($string [$j] == "(") {
			$zatvorka ++;
		  }
		if ($string [$j] == ")") {
			$zatvorka --;
		  }
		
		if (($string [$j] == "+" || $string [$j] == "-" || $string [$j] == "*" || $string [$j] == "/") && $zatvorka == 0) {
			$s_array [++ $n] = $string [$j];
			$n ++;
		  } 
    else {
			$s_array [$n] .= $string [$j];
		  }
	  }
	//print_r($s_array);
	
	return $s_array;
  }

function show($array) {
	echo "<br><table>";
	for($i = 0; $i < count ( $array ); $i ++) {
		echo "<tr><td>";
		print_r ( $array [$i] );
		echo "</td></tr>";
	}
	echo "</table>";
}

function wm_math_result($result) {
	$string = "";
	
	//print_r($result);
	if (is_array ( $result )) {
		
		for($i = 0; $i < count ( $result ); $i ++) {
			//echo "asdakshdakjhsdksajh<br>";
			for($j = 0; $j < count ( $result [0] ); $j ++) {
				$result [$i] [$j] = round($result [$i] [$j], get_option('wp_math_round'));
        if ($i == 0 && $j == 0) {
					$string .= "{".$result [$i] [$j]."}";
				  } 
        else {
				  $string .= " {" . $result [$i] [$j]."}";
				  }
			 }
		  }
		$result = "delim{[}{matrix{" . count ( $result ) . "}{" . count ( $result [0] ) . "}{" . $string . "}}{]}";
	}
	else{
    $result = round($result, get_option('wp_math_round'));
    }
	//echo "tralalal";
	return $result;
}
?>