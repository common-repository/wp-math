<?php
//$a = "a=matrix{1}{2}{1 2 3 5}*matrix{2}{2}{5 52 3 55}+matrix{2}{2}{5 52 3 55}";

function wp_math_matrix($content){
  preg_match_all("/matrix{[0-9]+}{[0-9]+}{[a-zA-Z0-9\._ ]+}/", $content, $regs, PREG_SET_ORDER);
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
        $matrix[$i][$j] = $values[$z++];
        }
      }
    
    }
  return $matrix;
  }

//print_r(wp_math_matrix($a));

//*************************** ADDING ********************************
function wp_math_add($a="",$b=""){
  if(is_array($a) && is_array($b)){
    if(count($a) == count($b) && count($a[0]) == count($b[0])){
      for($i=0;$i<count($a);$i++){
        for($j=0;$j<count($a[0]);$j++){
          $c[$i][$j] = $a[$i][$j] + $b[$i][$j];
          }
        }
      }
    else{
      return "matice sa nedaju sčítať";
      }
    }
  elseif(is_array($a) && !is_array($b)){
    for($i=0;$i<count($a);$i++){
      for($j=0;$j<count($a[0]);$j++){
        $c[$i][$j] = $a[$i][$j] + $b;
        }
      }
    }
  elseif(!is_array($a) && is_array($b)){
    for($i=0;$i<count($b);$i++){
      for($j=0;$j<count($b[0]);$j++){
        $c[$i][$j] = $b[$i][$j] + $a;
        }
      }
    }  
  else{$c = $a + $b;}
  return $c;
  } 
  
//*************************** SUBTRACT ********************************
function wp_math_subtract($a="",$b=""){

  if(is_array($a) && is_array($b)){
    if(count($a) == count($b) && count($a[0]) == count($b[0])){
      for($i=0;$i<count($a);$i++){
        for($j=0;$j<count($a[0]);$j++){
          $c[$i][$j] = $a[$i][$j] - $b[$i][$j];
          }
        }
      }
    else{
      return "matice sa nedaju odčítať";
      }
    }
  elseif(is_array($a) && !is_array($b)){
    for($i=0;$i<count($a);$i++){
      for($j=0;$j<count($a[0]);$j++){
        $c[$i][$j] = $a[$i][$j] - $b;
        }
      }
    }
  elseif(!is_array($a) && is_array($b)){
    for($i=0;$i<count($b);$i++){
      for($j=0;$j<count($b[0]);$j++){
        $c[$i][$j] = $b[$i][$j] - $a;
        }
      }
    } 
  else{$c = $a - $b;}
  return $c;
  } 

//******************************************* DIVIDING **********************************
function wp_math_divide($a="",$b=""){
  if(is_array($a) && is_array($b)){
    if(count($a) == count($b[0]) && count($b) == count($b[0])){
      $b_inverse = wp_math_inverse_matrix($b);
      $c = wp_math_multiply($a,$b_inverse);
      }
    else{
      echo "matice sa nedaju delit";
      }
    }
  elseif(is_array($a) && !is_array($b)){
    for($i=0;$i<count($a);$i++){
      for($j=0;$j<count($a[0]);$j++){
        $c[$i][$j] = $a[$i][$j]/$b;
        }
      }
    }
  elseif(!is_array($a) && is_array($b)){
    for($i=0;$i<count($b);$i++){
      for($j=0;$j<count($b[0]);$j++){
        $c[$i][$j] = $b[$i][$j]/$a;
        }
      }
    }
  else{
    $c = $a / $b;
    }
  return $c;
  } 


//*************************************** MULTIPLY ****************************************
function wp_math_multiply($a="",$b=""){
  //echo "nasobenie";
  if(is_array($a) && is_array($b)){
    if(count($a) == count($b[0])){
      for($i=0;$i<count($a);$i++){
        for($j=0;$j<count($b[0]);$j++){
          
          $c[$i][$j] = 0;
          for($n=0;$n<count($a[0]);$n++){ 
            $c[$i][$j] = $a[$i][$n]*$b[$n][$j] + $c[$i][$j];
            }
          }
        }
      }
    else{
      echo "matice sa nedaju vynásobiť";
      }
    }
  elseif(is_array($a) && !is_array($b)){
    //echo $b;
    for($i=0;$i<count($a);$i++){
      for($j=0;$j<count($a[0]);$j++){
        $c[$i][$j] = $a[$i][$j]*$b;
        }
      }
    }
  elseif(!is_array($a) && is_array($b)){
    for($i=0;$i<count($b);$i++){
      for($j=0;$j<count($b[0]);$j++){
        $c[$i][$j] = $b[$i][$j]*$a;
        }
      }
    }
  else{
    $c = $a * $b;
    }
  return $c;
  } 

//********************** matrix transpose *********************************

function wp_math_matrix_transpose($A){
  for($i=0;$i<count($A[0]);$i++){
    for($j=0;$j<count($A);$j++){
      $c[$i][$j]= $A[$j][$i];
      }
    }
  return $c;  
  }  

//**************************** identity matrix ******************************
function wp_math_identity_matrix($n){
  for($i=0;$i<$n;$i++){
    for($j=0;$j<$n;$j++){
      if($j==$i){$C[$i][$j] = 1;}
      else{$C[$i][$j] = 0;}
      }
    }
  return $C;  
  }

//*************************** DETERMINANT MATICE ******************************

    
function wp_math_matrix_determinant($A){
  if(wp_math_control_square_matrixa($A) === false){}
  elseif(count($A) == 1){return $A[0][0];}
  else{
    $det=0;
    for($i=0;$i<count($A);$i++){        //0-pocet riadkov
      $riadok1=0;
      for($riadok=0;$riadok<count($A);$riadok++){
        if($riadok!=$i){
          for($stlpec=0;$stlpec<count($A)-1;$stlpec++){
            $A1[$riadok1][$stlpec]=$A[$riadok][$stlpec+1];
            }    
          $riadok1++;
          }
        }
      if($i%2==0){                    //parne +
        $det+=$A[$i][0]*wp_math_matrix_determinant($A1);
        }
      else{                            //neparne -
        $det-=$A[$i][0]*wp_math_matrix_determinant($A1);
        }
      }
    return $det;
    }
  }

//************************* COFACTOR FUNKCIE **********************************
function wp_math_cofactor_matrix($A){
  for($i=0;$i<count($A);$i++){
    for($j=0;$j<count($A[0]);$j++){
      $C[$i][$j] = pow(-1,$i+$j)*$A[$i][$j];
      }
    }
  return $C;
  }

//*************************** ZMENSI MATICU O JEDEN RIADOK A STLPEC **********
function wp_math_decreased_matrix($A,$i,$j){
$n = 0;
  for($a=0;$a<count($A);$a++){
    $m = 0;
    for($b=0;$b<count($A[0]);$b++){
      if($a==$i){}
      elseif($b==$j){}
      else{
        $X[$i][$j][$m][$n] = $A[$b][$a];
        $m++;
        }
      }
    if($a==$i){}
      elseif($b==$j){}
      else{
      $n++;
      }
    }
  return $X[$i][$j]; 
  }

//*************************** INVERZNA MATICA DETERMINANTOM ******************

function wp_math_inverse_matrix($A){
  if(wp_math_control_square_matrixa($A)){
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        $X[$i][$j] = wp_math_decreased_matrix($A,$i,$j);
        $D[$i][$j] = wp_math_matrix_determinant($X[$i][$j]);
        }
      }
    $D = wp_math_cofactor_matrix($D);
    $det = 1/wp_math_matrix_determinant($A);
    $I = wp_math_multiply($det,$D);
    return $I;
    }
  }

//*************************** KONTROLA CI JE STVORCOVA MATICA *****************

function wp_math_control_square_matrixa($A){
  if(count($A)==count($A[0])){return true;}
  else{
    return false;
    }
  }

//*************************** RIESENIE ROVNIC *********************************
//*************************** LINEARNE ROVNICE ********************************
//*************************** REISENIE POMOCOU INVERZNEJ MATICE ***************

function linearne_funkcie($A,$B){
  $A = wp_math_inverse_matrix($A);
  $D = wp_math_multiply($A,$B);
  return $D;
  }



  ?>