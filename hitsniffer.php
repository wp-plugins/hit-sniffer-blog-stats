<?php
/*
Plugin Name: Hit Sniffer Blog Analytics
Plugin URI: http://www.hitsniffer.com/
Description: Hit Sniffer
Author: hitsniffer.com
Version: 2.1.5
Author URI: http://www.hitsniffer.com/
*/ 

add_action('admin_menu', 'hs_admin_menu');
add_action('wp_footer', 'hitsniffer');



function hitsniffer() {
global $_SERVER,$_COOKIE;

$option=get_hs_conf();
$option['code']=str_replace(" ","",html_entity_decode($option['code']));


	if( round($option['iga'])==1 && current_user_can("manage_options") ) {
		echo "\n<!-- ".__("Hit Sniffer tracking code not shown because you're an administrator and you've configured Hit Sniffer plugin to ignore administrators.", 'hitsniffer')." -->\n";
		return;
	}

$htmlpar='';


$purl='http://www.';
if ($_SERVER["HTTPS"]=='on'){
$purl='https://';
$htssl=" - SSL";
}

?><!-- HITSNIFFER TRACKING CODE<?php echo $htssl; ?> v2.1.5 - DO NOT CHANGE --><?php

if (is_search()){

?><script>MySearch='<?php echo addslashes(get_search_query()); ?>';</script><?php

$htmlpar.='&MySearch='.urlencode(addslashes(get_search_query()));

} ?><?php


	if( $option['tkn']!=2 ) { 
?>
	<script type='text/javascript'>
	function hitsniffer_gc( name ) {
		var ca = document.cookie.split(';');
		for( var i in ca ) {
			if( ca[i].indexOf( name+'=' ) != -1 )
				return decodeURIComponent( ca[i].split('=')[1] );
		}
		return '';
	}

ipname='<?php

global $current_user;
      get_currentuserinfo();

      echo $current_user->user_login
?>';


		ipnames=hitsniffer_gc( 'comment_author_<?php echo md5( get_option("siteurl") ); ?>' );
		if (ipnames!='') ipname=ipnames;
  	</script>
<?php

$ipname=$_COOKIE['comment_author_'.md5( get_option("siteurl"))]; 

if ($ipname=='') $ipname=$current_user->user_login;

if ($ipname!=''){
$htmlpar.='&amp;ipname='.urlencode(addslashes($ipname));
}
	
	}
	
$htmlpar.='&amp;ref='.urlencode(addslashes($_SERVER["HTTP_REFERER"]));
$htmlpar.='&amp;title='.urlencode(addslashes(wp_title('',false)));



$keyword[0]='Realtime Web Statistics';
$keyword[1]='website statistics';
$keyword[2]='website tracking software';
$keyword[3]='website tracking';
$keyword[4]='blog statistics';
$keyword[5]='blog tracking';
$keyword[6]='Realtime website statistics';
$keyword[7]='Realtime website tracking software';
$keyword[8]='Realtime website tracking';
$keyword[9]='Realtime blog statistics';
$keyword[10]='Realtime blog tracking';
$keyword[11]='free website tracking';
$keyword[12]='visitor activity tracker';
$keyword[13]='visitor activity monitoring';
$keyword[14]='visitor activity monitor';





?>
<script type="text/javascript">
(function(){
var hstc=document.createElement("script");
hstc.src="<?php echo $purl; ?>hitsniffer.com/track.php?code=<?php echo substr($option['code'],0,32); ?>";
hstc.async=true;
var htssc = document.getElementsByTagName("script")[0];
htssc.parentNode.insertBefore(hstc, htssc);
})();
</script>
<noscript><a href="http://www.hitsniffer.com/"><img src="<?php echo $purl; ?>hitsniffer.com/track.php?mode=img&amp;code=<?php echo substr($option['code'],0,32); ?><?php echo $htmlpar; ?>" alt="<?php echo $keyword[mt_rand(0,14)]; ?>" border='0' /><?php echo $keyword[mt_rand(0,14)]; ?></a></noscript>
<!-- HITSNIFFER TRACKING CODE<?php echo $htssl; ?> - DO NOT CHANGE --><?php     
}


function get_hs_conf(){
$config=get_option('hs_setting');
if (round($option['wgd'])==0) $option['wgd']=1;
if (round($option['tkn'])==0) $option['tkn']=1;
if (round($option['iga'])==0) $option['iga']=2;
return $config;
}
function set_hs_conf($conf){update_option('hs_setting',$conf);}


function hs_admin_menu(){
	add_options_page('Hit Sniffer Options', 'Hit Sniffer', 9, __FILE__, 'hs_optionpage');
}

function hs_optionpage(){
$option=get_hs_conf();
$option['code']=html_entity_decode($option['code']);
$option['wgd']=html_entity_decode($option['wgd']);


		if ($_POST['action']=='do'){
			$option=$_POST;
			$option['code']=htmlentities(str_replace(" ","",stripslashes($option['code'])));
            
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
    <td>Hit Sniffer plugin Setting Saved<br>We have started tracking your visitors from now. <a href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo substr($option['code'],0,32); ?>&tag=wordpress-to-dashboard-saved-setting">
	Now, Monitor your visitors here, but hey! please wait until we track some visitors first!</a></td>
  </tr>
</table>
</center>
<?php } ?>

<h2>
<a target="_blank" href="http://www.hitsniffer.com/?tag=wordpress-to-homepage">Hit Sniffer - an eye on your site</a></h2>
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php if ($option['code']!=''){ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">
	<tr>
		<td>
		<p align="center">
		<a href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo substr($option['code'],0,32); ?>&tag=wordpress-to-dashboard">
		<span style="font-weight: 700">
		<font face="Verdana" style="font-size: 13pt">Click here to view tracked visitors.</font></span></a></td>
	</tr>
</table><?php } ?>
<?php if ($option['code']==''){ ?><p>Please enter your Hit Sniffer API Code to activate it, If you don't have an API Code, get 
your free trial one at 
<a href="http://www.hitsniffer.com/?tag=wordpress-to-ht">HitSniffer.com</a><br><?php } ?><br>Hit Sniffer API Code:<br>
	<textarea rows="2" name="code" cols="117" ><?php echo $option['code']; ?></textarea></p>
<p>Show Hit Sniffer Quick Summary in Wordpress Dashboard?&nbsp;&nbsp;&nbsp;
<input type="radio" value="1" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']!=2) echo "checked"; ?>>Yes&nbsp;
<input type="radio" value="2" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']==2) echo "checked"; ?>>No</p>
<p>Track Visitors Name ( using name they enter when commenting )?&nbsp;&nbsp;&nbsp;
<input type="radio" value="1" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']!=2) echo "checked"; ?>>Yes&nbsp;
<input type="radio" value="2" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']==2) echo "checked"; ?>>No</p>
<p>Ignore Admin Visits?&nbsp;&nbsp;&nbsp;
<input type="radio" value="1" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])!=2) echo "checked"; ?>>Yes&nbsp;
<input type="radio" value="2" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])==2) echo "checked"; ?>>No</p>
    
	
	<p class="submit"><input type="submit" value="Save" style="width: 120px;"></p>
<?php if ($option['code']==''){ ?><p class="submit"><br><br><br><h2>How use Hit Sniffer at Wordpress?</h2>Just 
<a href="http://www.hitsniffer.com/register.php?tag=wordpress-to-ht-reg">Sign up 
at Hit Sniffer</a> and get your free account.<br>
Login to your hit sniffer account and Add your website address in hit sniffer website list.<br>then in hitsniffer.com setting page, get your Wordpress API code.<br>
Input that code here.<br>All Visitors information will be tracked in real-time and you can open and watch them in your hitsniffer.com dashboard, Real-time! it means you open dashboard and it will show your current visitors, once they change a page, it have more to offer!</p><?php } ?>
	<p class="submit"><a href="http://www.hitsniffer.com/features.php" target="_blank">view hit sniffer features</a></p>
<p class="submit">Hit Sniffer also support normal websites ( non wordpress pages 
).<?php if ($option['code']!=''){ ?><br>
If you have a website too, Please put following code into your website pages, 
then hit sniffer can measure your visitors more accurate.</p>
<p class="submit">Website Code:<br>
<textarea rows="5" name="wcode" cols="100" readonly><!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE -->
<script src="http://www.hitsniffer.com/track.php?code=<?php echo substr($option['code'],0,32); ?>" type="text/javascript" ></script>
<noscript><a href="http://www.hitsniffer.com/">
<img src="http://www.hitsniffer.com/track.php?mode=img&code=<?php echo substr($option['code'],0,32); ?>" alt="Realtime website statistics" />Real time website tracking wordpress</a></noscript>
<!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE --></textarea></p><?php } ?>
<input type="hidden" name="action" value="do">
</form>
	
</div>

<?php
}


function hitsniffer_dashboard_widget_function() {
	
	$option=get_hs_conf();
	
$purl='http://www.';
if ($_SERVER["HTTPS"]=='on'){
$purl='https://';
$htssl=" - SSL";
}	
	
	
 if ($option['code']!=''){ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">
	<tr>
		<td>
	<iframe scrollable='no' name="hit-sniffer-stat" frameborder="0" border="0" width="100%" height="400" src="<?php echo $purl; ?>hitsniffer.com/stats/wp-new.php?code=<?php echo $option['code']; ?>">	
		
		<p align="center">
		<a href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo substr($option['code'],0,32); ?>&tag=wp-dash-to-hs-dash">
		<span>
		<font face="Verdana" style="font-size: 12pt">Open Hit Sniffer Dashboard</font></span></a></iframe></td>
	</tr>
</table>

<?php

}else{ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">
	<tr>
		<td>
		<p align="left">Hit Sniffer API Code is not installed. Please open Wordpress Setting -> Hit Sniffer for instruction.</td>
	</tr>
</table>

<?php

}
}


function hitsniffer_add_dashboard_widgets() {

$option=get_hs_conf();

if ($option['wgd']!=2){

    if (function_exists('wp_add_dashboard_widget')){
    
      wp_add_dashboard_widget('hitsniffer_dashboard_widget', 'Hit Sniffer - Your Analytics Summary', 'hitsniffer_dashboard_widget_function');	
    }
}
}


add_action('wp_dashboard_setup', 'hitsniffer_add_dashboard_widgets' );


?>