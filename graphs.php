<?php 
$title = "nadpis";
$values[0] = array('title' => "aut", 'values' => array(10,20,30,40,20));
$values[1] = array('title' => "autobusov", 'values' => array(1,25,12,20,30));
$axis_x = array('title' => "Roky", 'values' => array(1990,1991,1992,1993,1994));
$axis_y = "pocet predanych kusov";

$a = array(array(10,15,2,35,55));
$b = array(array(50,115,2,3,55));

$roky = array(1,2,3,4,5);

$title = "NADPIS GRAFU"; 
$values_final[0] = array('title' => "a", 'values' => $a[0]); 
$values_final[1] = array('title' => "b", 'values' => $b[0]); 
$axis_x = array('title' => "roky", 'values' => $roky); 
$axis_y = "pocet predanych kusov";
//print_r($axis_x );
//show($values);
//wp_math_graphs($title,$values_final,$axis_x,$axis_y);
 
//$title = string
//$values[$i][title][values=array]
//$axis_x = array
//$axis_y = string 

function wp_math_separate_graph_inputs($string,$content){
  $content = stristr($content, $string); 
  $content = stristr($content, ';', TRUE); 
  $content = explode(":",$content);
  $content = trim($content[1]);
  return $content;
  }

function wp_math_gat_graphs($content){
  preg_match_all("|\[graph\](.*?)\[\/graph\]|", $content, $regs, PREG_SET_ORDER);
  
  foreach($regs as $graph){
    $find = $graph[0];
    
    $graph = $graph[1].";";
    $title = wp_math_separate_graph_inputs("title:",$graph);
    $values = wp_math_separate_graph_inputs("values:",$graph);
    $x = wp_math_separate_graph_inputs("x:",$graph);
    $y = wp_math_separate_graph_inputs("y:",$graph);
    
    $values = explode(",",$values);
    for($i=0;$i<count($values);$i++){
      $values[$i] = trim($values[$i]);
      $values_string .= " \$values_final[$i] = array('title' => \"$values[$i]\", 'values' => \$$values[$i][0]);"; 
      $values_string2 .= "\$$values[$i][0]; ";
      }
      
    $string2 = "\$md5 = $title; $values_string2\$$x"."[0];"." $y;";
    $string = "<m>graph:\$title = \"$title\"; $values_string \$axis_x = array('title' => \"$x\", 'values' => \$$x"."[0]"."); \$axis_y = \"$y\";$string2</m>";
    
    $content = str_replace($find, $string, $content);
    }   
  //echo $content;   
  return $content; 
  }
  
 /*preg_match_all("|(.*?)=\((.*?)\)|", $values, $inputs_values, PREG_SET_ORDER);
    $n = 0;
    foreach($inputs_values as $inputs){
      $inputs = $inputs[0];
      if($inputs[0] == ","){$inputs[0] = "";}
      $inputs = trim($inputs);
      $inputs = explode("=",$inputs);
      
      if(strpos($inputs[1], "(") === false){
        $values_final[$n++] = array('title' => "$inputs[0]", 'values' => "\$$inputs[1]");
        }
      else{
        $inputs[1] = str_replace(array("(",")"),array("",""),$inputs[1]);
        $inputs[1] = explode(",",$inputs[1]);
        $values_final[$n++] = array('title' => "$inputs[0]", 'values' => array($inputs[1]));
        }
      
      }
    //show($values_final);
    */
    
function wp_math_graphs($title,$values,$axis_x,$axis_y,$md5){
include("class/pData.class");
include("class/pDraw.class");
include("class/pImage.class");

$md5 = md5($md5);
$generate = true;

if ($handle = opendir('wp-content/plugins/wp-math/graphs')) {
  while (false !== ($file = readdir($handle))) {
    if($file == "$md5.png"){
      $generate = false;
      }
    }
  closedir($handle);
  }

if($generate){
  $myData = new pData();
  
  for($i=0;$i<count($values);$i++){
    $myData->addPoints($values[$i]["values"],"Serie$i");
    $myData->setSerieDescription("Serie$i",$values[$i]["title"]);
    $myData->setSerieOnAxis("Serie$i",0);
    }
  
  $myData->addPoints($axis_x["values"],"Abscissa");
   $myData->setSerieDescription("Abscissa",$axis_x["title"]);
  $myData->setAbscissa("Abscissa");
  
  $myData->setAxisPosition(0,AXIS_POSITION_LEFT);
  $myData->setAxisName(0,"$axis_y");
  $myData->setAxisUnit(0,"");
  
  $myPicture = new pImage(700,350,$myData);
  $myPicture->Antialias = FALSE;
  $Settings = array("R"=>79, "G"=>79, "B"=>79);
  $myPicture->drawFilledRectangle(0,0,700,350,$Settings);
  
  $myPicture->drawRectangle(0,0,699,349,array("R"=>0,"G"=>0,"B"=>0));
  
  $myPicture->setFontProperties(array("FontName"=>"wp-content/plugins/wp-math/fonts/Forgotte.ttf","FontSize"=>20));
  $TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE
  , "R"=>255, "G"=>255, "B"=>255);
  $myPicture->drawText(350,25,"$title",$TextSettings);
  
  $myPicture->setGraphArea(50,50,675,310);
  $myPicture->setFontProperties(array("R"=>255,"G"=>255,"B"=>255,"FontName"=>"wp-content/plugins/wp-math/fonts/pf_arma_five.ttf","FontSize"=>10));
  
  $Settings = array("Pos"=>SCALE_POS_LEFTRIGHT
  , "Mode"=>SCALE_MODE_FLOATING
  , "LabelingMethod"=>LABELING_ALL
  , "GridR"=>255, "GridG"=>255, "GridB"=>255, "GridAlpha"=>40, "TickR"=>255, "TickG"=>242, "TickB"=>242, "TickAlpha"=>50, "LabelRotation"=>0, "CycleBackground"=>1, "DrawXLines"=>1, "DrawYLines"=>ALL);
  $myPicture->drawScale($Settings);
  
  $Config = array("DisplayValues"=>1);
  $myPicture->drawSplineChart($Config);
  
  $Config = array("FontR"=>255, "FontG"=>255, "FontB"=>255, "FontName"=>"wp-content/plugins/wp-math/fonts/pf_arma_five.ttf", "FontSize"=>8, "Margin"=>6, "Alpha"=>30, "BoxSize"=>5, "Style"=>LEGEND_NOBORDER
  , "Mode"=>LEGEND_HORIZONTAL
  );
  $myPicture->drawLegend(523,16,$Config);
  
  $myPicture->Render("wp-content/plugins/wp-math/graphs/$md5.png");
  
  }
return $md5;  
  
}
?>