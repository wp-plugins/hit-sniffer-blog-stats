<?php
/*
Plugin Name: Hit Sniffer Blog Stats
Plugin URI: http://www.hitsniffer.com/
Description: Hit Sniffer
Author: Hitsniffer.com
Version: 1.3
Author URI: http://www.hitsniffer.com/
*/ 

add_action('admin_menu', 'hs_admin_menu');
add_action('wp_head', 'hitsniffer');



function hitsniffer() {


$option=get_hs_conf();
$option['code']=html_entity_decode($option['code']);

?><!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE -->
<script src="http://www.hitsniffer.com/track.php?code=<?php echo $option['code']; ?>" type="text/javascript" ></script>
<noscript><a href="http://www.hitsniffer.com/"><img src="http://www.hitsniffer.com/track.php?mode=img&code=<?php echo $option['code']; ?>" alt="Realtime hit counter" />web stats</a></noscript>
<!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE --><?php     
}


function get_hs_conf(){
$config=get_option('hs_setting');
return $config;
}
function set_hs_conf($conf){update_option('hs_setting',$conf);}


function hs_admin_menu(){
	add_options_page('Hit Sniffer Options', 'Hit Sniffer', 9, __FILE__, 'hs_optionpage');
}

function hs_optionpage(){
$option=get_hs_conf();
$option['code']=html_entity_decode($option['code']);


		if ($_POST['action']=='do'){
			$option=$_POST;
			$option['code']=htmlentities(stripslashes($option['code']));
            
            set_hs_conf($option);
			$saved=1;
		}


?>
<div class="wrap">
<style>
input{ width: 99%; }
textarea{ width: 99%; }
select{ width: 100%; }
</style>
<?php
if ($saved==1){
?>
<center>
<table width="90%" border="1" style="background-color: rgb(255, 251, 204);" id="message" class="updated fade">
  <tr>
    <td>Hit Sniffer Setting Saved<br>
	<a href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo $option['code']; ?>&tag=wordpress-to-dashboard-saved-setting">
	Open your Dashboard and Watch and monitor your visitors now!</a></td>
  </tr>
</table>
</center>
<?php } ?>

<h2>
<a target="_blank" href="http://www.hitsniffer.com/?tag=wordpress-to-homepage">Hit Sniffer</a></h2>
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php if ($option['code']!=''){ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">
	<tr>
		<td>
		<p align="center">
		<a href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo $option['code']; ?>&tag=wordpress-to-dashboard">
		<span style="font-weight: 700">
		<font face="Verdana" style="font-size: 13pt">Watch and Monitor Your 
		Visitors</font></span></a></td>
	</tr>
</table><?php } ?>
<?php if ($option['code']==''){ ?><p>Please enter your Hit Sniffer API Code to activate it, If you don't have an API Code, get 
your one at 
<a href="http://www.hitsniffer.com/?tag=wordpress-to-ht">HitSniffer.com</a><br><?php } ?><br>API Code:<br>
	<textarea rows="2" name="code" cols="117" ><?php echo $option['code']; ?></textarea></p>
    
	
	<p class="submit"><input type="submit" value="Save" style="width: 120px;"></p>
<?php if ($option['code']==''){ ?><p class="submit"><h2>How use Hit Sniffer at Wordpress?</h2>Just 
<a href="http://www.hitsniffer.com/?tag=wordpress-to-ht">Sign up 
at Hit Sniffer</a> and get your free account.<br>
Add your website address in hit sniffer website and then in hitsniffer.com setting page, get your Wordpress API code.<br>
Input that code here.<br>Your Visitors data will be logged in realtime and you can open and watch them in your hitsniffer.com dashboard.</p><?php } ?>
	<p class="submit">More Configuration is available in your HitSniffer.com 
	Setting.</p>
<p class="submit">Hit Sniffer also support normal websites ( non wordpress pages 
).<?php if ($option['code']!=''){ ?><br>
If you have a website too, Please put following code into your website pages, 
hit sniffer can measure your visitors more accurate.</p>
<p class="submit">Website Code:<br>
<textarea rows="5" name="wcode" cols="100" readonly><!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE -->
<script src="http://www.hitsniffer.com/track.php?code=<?php echo $option['code']; ?>" type="text/javascript" ></script>
<noscript><a href="http://www.hitsniffer.com/">
<img src="http://www.hitsniffer.com/track.php?mode=img&code=<?php echo $option['code']; ?>" alt="Realtime website statistics" />Real time website tracking wordpress</a></noscript>
<!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE --></textarea></p><?php } ?>
<input type="hidden" name="action" value="do">
</form>
	
</div>

<?php
}


function hitsniffer_dashboard_widget_function() {
	
	$option=get_hs_conf();
	
 if ($option['code']!=''){ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">
	<tr>
		<td>
		<p align="center">
		<a href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo $option['code']; ?>&tag=wp-dash-to-hs-dash">
		<span>
		<font face="Verdana" style="font-size: 12pt">Watch Hit Sniffer Dashboard</font></span></a></td>
	</tr>
</table>

<?php

}else{ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">
	<tr>
		<td>
		<p align="left">Hit Sniffer API Code is not installed. Please open Setting -> Hit Sniffer for instruction.</td>
	</tr>
</table>

<?php

}
}


function hitsniffer_add_dashboard_widgets() {
	wp_add_dashboard_widget('hitsniffer_dashboard_widget', 'Hit Sniffer', 'hitsniffer_dashboard_widget_function');	
}


add_action('wp_dashboard_setup', 'hitsniffer_add_dashboard_widgets' );


?>