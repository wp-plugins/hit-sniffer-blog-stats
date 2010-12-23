<?php
/*
Plugin Name: Hit Sniffer Live Blog Analytics
Plugin URI: http://www.hitsniffer.com/
Description: Hit Sniffer
Author: hitsniffer.com
Version: 2.2.6.8
Author URI: http://www.hitsniffer.com/
*/ 

add_action('admin_menu', 'hs_admin_menu');
add_action('wp_footer', 'hitsniffer');
add_action('wp_head', 'hitsniffer');



function hitsniffer() {
global $_SERVER,$_COOKIE,$hitsniffer_tracker;

$option=get_hs_conf();
$option['code']=str_replace("\r",'',str_replace("\n",'',str_replace(" ","",trim(html_entity_decode($option['code'])))));


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

?><!-- HITSNIFFER TRACKING CODE<?php echo $htssl; ?> v2.2.6.8 - DO NOT CHANGE --><?php

if (is_search()){

if (round($hitsniffer_tracker)==0){
?><script>MySearch='<?php echo addslashes(get_search_query()); ?>';</script><?php
}

$htmlpar.='&MySearch='.urlencode(addslashes(get_search_query()));

} ?><?php


	if( $option['tkn']!=2 ) { 
?><?php if (round($hitsniffer_tracker)==0){ ?>
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
  	</script><?php } ?>
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
$keyword[15]='user activity tracking';
$keyword[16]='website analytics';
$keyword[17]='blog analytics';
$keyword[18]='visitor analytics';





?><?php if (round($hitsniffer_tracker==0)){ ?>
<script>
(function(){
var hstc=document.createElement('script');
var hstcs='www.';
hstc.src='<?php echo $purl; ?>hitsniffer.com/track.php?code=<?php echo substr($option['code'],0,32); ?>';
hstc.async=true;
var htssc = document.getElementsByTagName('script')[0];
htssc.parentNode.insertBefore(hstc, htssc);
})();

<?php if (round($option['allowchat'])==2){ ?>var nochat=1;
<?php }else{ ?>var nochat=0;<?php } ?>
</script>
<?php }else{ ?>
<noscript><a href="http://www.hitsniffer.com/"><img src="<?php echo $purl; ?>hitsniffer.com/track.php?mode=img&amp;code=<?php echo substr($option['code'],0,32); ?><?php echo $htmlpar; ?>" alt="<?php echo $keyword[mt_rand(0,14)]; ?>" border='0' /><?php echo $keyword[mt_rand(0,14)]; ?></a></noscript>
<?php } ?>
<!-- HITSNIFFER TRACKING CODE<?php echo $htssl; ?><?php if (round($hitsniffer_tracker==0)){ ?> - Header Code<?php }else{ ?> - Footer Code<?php } ?> - DO NOT CHANGE --><?php 

$hitsniffer_tracker=1;

}




function get_hs_conf(){
$config=get_option('hs_setting');
if (round($option['wgd'])==0) $option['wgd']=1;
if (round($option['tkn'])==0) $option['tkn']=1;
if (round($option['iga'])==0) $option['iga']=2;
if (round($option['allowchat'])==0) $option['allowchat']=1;
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
$option['allowchat']=html_entity_decode($option['allowchat']);


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
	<input type="text" name="code" size="20" value="<?php echo $option['code']; ?>"><br>Each site has it's own API Code. Looks something like 3defb4a2e4426642ea... and can be found in <a href='http://www.hitsniffer.com' target='_blank'>Hit Sniffer Website</a> setting page.</p>
<p>Show Hit Sniffer Quick Summary in Wordpress Dashboard?&nbsp;&nbsp;&nbsp;
<input type="radio" value="1" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']!=2) echo "checked"; ?>>Yes&nbsp;
<input type="radio" value="2" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']==2) echo "checked"; ?>>No</p>
<p>Track Visitors Name ( using name they enter when commenting )?&nbsp;&nbsp;&nbsp;
<input type="radio" value="1" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']!=2) echo "checked"; ?>>Yes&nbsp;
<input type="radio" value="2" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']==2) echo "checked"; ?>>No</p>
<p>Ignore Admin Visits?&nbsp;&nbsp;&nbsp;
<input type="radio" value="1" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])!=2) echo "checked"; ?>>Yes&nbsp;
<input type="radio" value="2" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])==2) echo "checked"; ?>>No</p>
<p>Allow me Start a chat with visitors using
<a target="_blank" href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo substr($option['code'],0,32); ?>&tag=wp-to-dash-chat">
Hit Sniffer Dashboard</a>?&nbsp;&nbsp;&nbsp;
<input type="radio" value="1" name="allowchat"  style="width: 22px; height: 20px;" <?php if ($option['allowchat']!=2) echo "checked"; ?> checked>Yes&nbsp;
<input type="radio" value="2" name="allowchat"  style="width: 22px; height: 20px;" <?php if ($option['allowchat']==2) echo "checked"; ?>>No</p>
    
	
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
	<iframe scrollable='no' name="hit-sniffer-stat" frameborder="0" border="0" width="100%" height="495" src="<?php echo $purl; ?>hitsniffer.com/stats/wp-new.php?code=<?php echo $option['code']; ?>">	
		
		<p align="center">
		<a href="http://www.hitsniffer.com/stats/dashboard.php?code=<?php echo substr($option['code'],0,32); ?>&tag=wp-dash-to-hs-dash">
		<span>
		<font face="Verdana" style="font-size: 12pt">Your Browser don't show our widget's iframe. Please Open Hit Sniffer Dashboard manually.</font></span></a></iframe></td>
	</tr>
</table>

<?php

}else{ ?><table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" height="54">
	<tr>
		<td>
		<p align="left">Hit Sniffer API Code is not installed. Please open Wordpress Setting -> Hit Sniffer for instruction.<br>You need get your free hit sniffer account to get an API key.</td>
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












/**
 * HS_SUPPORT Class
 */
class HS_SUPPORT extends WP_Widget {
    /** constructor */
    function HS_SUPPORT() {
        parent::WP_Widget(false, $name = 'Hit Sniffer Live Chat Support');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
    
    
$option=get_hs_conf();
$option['code']=substr(str_replace("\r",'',str_replace("\n",'',str_replace(" ","",trim(html_entity_decode($option['code']))))),0,32);


$purl='http://www.';
if ($_SERVER["HTTPS"]=='on'){
$purl='https://';
$htssl=" - SSL";
}
    
    
    
 if ($option['code']!=''){
    
    
        extract( $args );
        $title = apply_filters('widget_title', $instance['widget_title']);
        $widget_comments_title = apply_filters('widget_comments_title', $instance['widget_comments_title']);






        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
<div style="text-align: center;"><!-- HITSNIFFER ONLINE SUPPORT CODE v2.2 - DO NOT CHANGE -->
<script src="<?php echo $purl; ?>hitsniffer.com/online.php?code=<?php echo $option['code']; ?>" type="text/javascript" ></script>
<!-- HITSNIFFER ONLINE SUPPORT CODE - DO NOT CHANGE --></div>
                  <?php echo $widget_comments_title; ?>
              <?php echo $after_widget; ?>
        <?php
    }
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['widget_title'] = strip_tags($new_instance['title']);
	$instance['widget_comments_title'] = strip_tags($new_instance['comment']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	
    $option=get_hs_conf();		
     if ($option['code']!=''){  	
        $title = esc_attr($instance['widget_title']);
        $widget_comments_title = esc_attr($instance['widget_comments_title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('comment'); ?>"><?php _e('Your Comment:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('comment'); ?>" name="<?php echo $this->get_field_name('comment'); ?>" type="text" value="<?php echo $widget_comments_title; ?>" /></label></p>
		<p>What is this widget?</p><span>Hit Sniffer offer live chat support 
starting from basic plan. This widget show an Online support icon whenever you are online at hit sniffer dashboard and show a Leave a message contact form icon when you are not online.</span>
        <?php 
    }else{
            ?><p>You might be interested to download cross-platform Native OS 
Chat Notifier widget of Hit Sniffer, to receive notification whenever somebody 
requested a chat with you.
<a target="_parent" href="http://www.hitsniffer.com/widget/">Click here to open 
widgets page.</a></p>
            <p>Please configure hit sniffer API Code in your wordpress Setting -> Hit Sniffer before using Chat widget.</p>
        <?php 
    }
    
    }


function get_hs_conf(){
$config=get_option('hs_setting');
if (round($option['wgd'])==0) $option['wgd']=1;
if (round($option['tkn'])==0) $option['tkn']=1;
if (round($option['iga'])==0) $option['iga']=2;
if (round($option['allowchat'])==0) $option['allowchat']=1;
return $config;
}

} // class HS_SUPPORT


// register HS_SUPPORT widget
add_action('widgets_init', create_function('', 'return register_widget("HS_SUPPORT");'));


?>