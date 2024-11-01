<?php
//************************ GET SOME SETTINGS *********************************
if(isset($_POST["wp_math_size"])){
 
  $wp_math_size = $_POST["wp_math_size"];
  $wp_math_size = max(10,$wp_math_size);
  $wp_math_size = min(24,$wp_math_size);
  
  $wp_math_mail = $_POST["wp_math_mail"];
  $wp_math_only_mail = $_POST["wp_math_only_mail"];    
  $wp_math_round = $_POST["wp_math_round"];
  $wp_math_static = $_POST["wp_math_static"];
  
  
  update_option('wp_math_size', $wp_math_size);
  update_option('wp_math_mail', $wp_math_mail);
  update_option('wp_math_only_mail', $wp_math_only_mail);
  update_option('wp_math_round', $wp_math_round);
  update_option('wp_math_static', $wp_math_static);
  }
else{
  $wp_math_size = get_option('wp_math_size');
  $wp_math_mail = get_option('wp_math_mail');
  $wp_math_only_mail = get_option('wp_math_only_mail');
  $wp_math_round = get_option('wp_math_round');
  $wp_math_static = get_option('wp_math_static');
  }

//******************* SEND MAIL WITH SOME BUGS OR SHARE IDEAS *****************
if(isset($_POST["send"])){
  $bug_report_subject = $_POST["bug_report_subject"];
  $bug_report_text = $_POST["bug_report_text"];
  
  if($bug_report_subject == "" &&  $bug_report_text == ""){
    $bug_report_error_both = true; $bug_report_error = true;
    }
  elseif($bug_report_subject == ""||  $bug_report_text == ""){
    $bug_report_error_one = true; $bug_report_error = true;
    }
  else{
    wp_mail( "stanislav.guncaga@gmail.com", "WP Math Bug Report: $bug_report_subject", $bug_report_text);
    $bug_report_success = true;
    $bug_report_subject = "";
    $bug_report_text = "";
    } 
  }



?>
<div class="wrap"> 

<?php
//***************************** REPORTS **************************************
if($bug_report_success){
  echo "<div id=\"message\" class=\"updated\">";
  _e('Message was sent. Thanks.', WPMP_TEXTDOMAIN);
  echo "</div>";
  }
if($wp_math_only_mail && !$wp_math_mail){
  echo "<div id=\"message\" class=\"error\">";
  _e('Evil orcs corrupted WP Math. Switch "<b>Convert mail to png</b>" or "<b>Use just Mail convertor</b>", otherwise plugin will do nothing...', WPMP_TEXTDOMAIN);
  echo "</div>";
  }
if($bug_report_error_both){
  echo "<div id=\"message\" class=\"error\">";
  _e('Bug report: Both fields are empty', WPMP_TEXTDOMAIN);
  echo "</div>";
  }
if($bug_report_error_one){
  echo "<div id=\"message\" class=\"error\">";
  _e('Bug report: One field is empty', WPMP_TEXTDOMAIN);
  echo "</div>";
  }
?>

<div id="icon-options-general" class="icon32"><br /></div> 
<h2><?php _e('WP Math', WPMP_TEXTDOMAIN); ?></h2>

<script type="text/javascript">
var polevisible_wp_math_settings=false;
var polevisible_wp_math_bugs=<?php if(isset($_POST["send"])){echo "false";} else {echo "true";} ?>;
var polevisible_wp_math_help=true;
var polevisible_wp_math_news=true;

function wp_math_settings(){
    if(polevisible_wp_math_settings==true)
      document.getElementById('wp_math_settings').style.display='inline';
    else
      document.getElementById('wp_math_settings').style.display='none';
      
    polevisible_wp_math_settings = !polevisible_wp_math_settings;
}

function wp_math_bugs(){
    if(polevisible_wp_math_bugs==true)
      document.getElementById('wp_math_bugs').style.display='inline';
    else
      document.getElementById('wp_math_bugs').style.display='none';
      
    polevisible_wp_math_bugs = !polevisible_wp_math_bugs;
}

function wp_math_help(){
    if(polevisible_wp_math_help==true)
      document.getElementById('wp_math_help').style.display='inline';
    else
      document.getElementById('wp_math_help').style.display='none';
      
    polevisible_wp_math_help = !polevisible_wp_math_help;
}

function wp_math_news(){
    if(polevisible_wp_math_news==true)
      document.getElementById('wp_math_news').style.display='inline';
    else
      document.getElementById('wp_math_news').style.display='none';
      
    polevisible_wp_math_news = !polevisible_wp_math_news;
}

</script> 

<style>
td{
padding: 3px;
}
</style>

<h2>Display:</h2>
| <a href="#" onclick="javascript: wp_math_settings();">Settings</a> | <a href="#" onclick="javascript: wp_math_bugs();">Bugs report</a> | <a href="#" onclick="javascript: wp_math_help();">Help</a> | <a href="#" onclick="javascript: wp_math_news();">News</a> | 

<!-- ************************* SETTINGS *********************************-->

<span id="wp_math_settings" style="display: inline">
<div id="poststuff" class="metabox-holder has-right-sidebar"> 
<div id="normal-sortables" class="meta-box-sortables ui-sortable">
<div id="trackbacksdiv" class="postbox ">      

<div class="handlediv" title="Prepnúť zobrazenie"><br></div><h3 class="hndle"><span>Settings</span></h3> 
<div class="inside"> 


<p>
<form method="post">
<table>
  <tr><td style="padding-right: 80px;">
  
    <table>
    
      <tr><td><?php _e('Font size:', WPMP_TEXTDOMAIN); ?></td><td><input type="text" name="wp_math_size" value="<?php echo $wp_math_size; ?>" style="width: 30px"> <?php _e('(between 10-24)', WPMP_TEXTDOMAIN); ?></td></tr>
      
      <tr><td><?php _e('Convert mail to png:', WPMP_TEXTDOMAIN); ?></td><td><input type="checkbox" name="wp_math_mail" value="1" <?php if($wp_math_mail){echo "CHECKED";}?>></td></tr>
      
      <tr><td><?php _e('Use just Mail convertor:', WPMP_TEXTDOMAIN); ?></td><td><input type="checkbox" name="wp_math_only_mail" value="1" <?php if($wp_math_only_mail){echo "CHECKED";}?> > <?php _e('(All other functions will be disabled)', WPMP_TEXTDOMAIN); ?></td></tr>
      
      <tr><td><?php _e('Round number to:', WPMP_TEXTDOMAIN); ?></td><td><input type="text" name="wp_math_round" value="<?php echo $wp_math_round; ?>" style="width: 30px"> <?php _e('(between 0 - 13)', WPMP_TEXTDOMAIN); ?></td></tr>
      
      <tr><td><?php _e('Static:', WPMP_TEXTDOMAIN); ?></td><td><input type="checkbox" name="wp_math_static" value="1" <?php if($wp_math_static){echo "CHECKED";}?> > <?php _e('(This feature needs testing. Disable if is not working properly)', WPMP_TEXTDOMAIN); ?></td></tr>
      
      <tr><td></td><td><input type="submit" name="save" value="<?php _e('Save', WPMP_TEXTDOMAIN); ?>"></td></tr>
      
    </table> 
    
  </td><td style="padding: 10px; border: 1px solid black;"><?php _e('Sample formula:', WPMP_TEXTDOMAIN); echo wp_math("<br /><br />&lt;m&gt;beta=10/3=&lt;/m&gt;"); ?></td><td style="padding: 10px; border: 1px solid black;"><?php _e('Sample e-mail:', WPMP_TEXTDOMAIN); echo wp_math("<br /><br />mail@mail.com"); ?></td></tr>
</table>
</form> 
</p>
</div> 
</div> 
</div>
</div>  
</span>

<!-- ************************* BUG REPORT *********************************-->
<span id="wp_math_bugs" style="display: <?php if(isset($_POST["send"])){echo "inline";} else {echo "none";} ?>"><form method="post">

<div id="poststuff" class="metabox-holder has-right-sidebar"> 
<div id="normal-sortables" class="meta-box-sortables ui-sortable">
<div id="trackbacksdiv" class="postbox ">      

<div class="handlediv" title="Prepnúť zobrazenie"><br></div><h3 class="hndle"><span><?php _e('Report Bugs or share Ideas:', WPMP_TEXTDOMAIN); ?></span></h3> 
<div class="inside"> 
<p>
<form method="post">
<?php _e('Both fields are required.', WPMP_TEXTDOMAIN); ?>
<table>
<tr><td><?php _e('Subject:', WPMP_TEXTDOMAIN); ?></td><td><input type="text" name="bug_report_subject" value="<?php echo $bug_report_subject; ?>" style="width: 500px; border-color: <?php if($bug_report_error && $bug_report_subject == ""){echo "red";} ?>;"></td></tr>
<tr><td><?php _e('Text:', WPMP_TEXTDOMAIN); ?></td><td><textarea name="bug_report_text" style="height: 150px; width: 500px; border-color: <?php if($bug_report_error && $bug_report_text == ""){echo "red";} ?>;"><?php echo $bug_report_text; ?></textarea></td></tr>

<tr><td></td><td><input type="submit" name="send" value="<?php _e('Send', WPMP_TEXTDOMAIN); ?>">  </td></tr>
</table>
</form> 
</p>
</div> 
</div> 
</div>
</div> 
</span>

<!-- ************************* HELP *********************************-->
<span id="wp_math_help" style="display: none">

<?php
echo file_get_contents('http://wp-math.uctovanie.net/wp-math-help.html');
?>

</span>  

<!-- ************************* News *********************************-->
<span id="wp_math_news" style="display: none">

<?php
echo file_get_contents('http://wp-math.uctovanie.net/wp-math-news.html');
?>

</span>  

 
</div>

  