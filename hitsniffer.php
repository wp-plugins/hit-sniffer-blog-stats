<?php

/*
Plugin Name: Hit Sniffer Live Blog Analytics
Plugin URI: http://www.hitsniffer.com/
Description: Hit Sniffer
Author: hitsniffer.com
Version: 2.4.5.5
Author URI: http://www.hitsniffer.com/
*/ 


add_action('admin_menu', 'hs_admin_menu');

add_action('wp_footer', 'hitsniffer');

add_action('wp_head', 'hitsniffer');

hitsniffer_admin_warnings();





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

$htssl='';

if (isset($_SERVER["HTTPS"])){

if ($_SERVER["HTTPS"]=='on'){

$purl='https://';

$htssl=" - SSL";

}

}



?><!-- HITSNIFFER TRACKING CODE<?php echo $htssl; ?> v2.4.5 - DO NOT CHANGE --><?php



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







function hitsniffer_admin_warnings() {

$option=get_hs_conf();



	if ( $option['code']=='' && $_POST['action']!='do' && $_REQUEST['hitmagic']!='do' ) {

		function hitsniffer_warning() {

			echo "

			<div id='hitsniffer-warning' class='updated fade'><p><strong>".__('hitsniffer is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your hitsniffer API key</a> for it to work.'), "options-general.php?page=hit-sniffer-blog-stats/hitsniffer.php")."</p></div>

			";

		}

		add_action('admin_notices', 'hitsniffer_warning');

		return;

	}

}







function get_hs_conf(){

$config=get_option('hs_setting');

if (round($option['wgd'])==0) $option['wgd']=1;

if (round($option['tkn'])==0) $option['tkn']=1;

if (round($option['iga'])==0) $option['iga']=0;

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





$magicable=1;

global $current_user;

if(function_exists('get_currentuserinfo')){

get_currentuserinfo();

}

if ($current_user->user_email==''){

$magicable=0;

}

if ($current_user->display_name==''){

$current_user->display_name=$current_user->user_firstname;

}

if ($current_user->user_identity!=''){

$current_user->display_name=$current_user->user_identity;

}

if ($current_user->user_firstname==''){

$current_user->user_firstname=$current_user->display_name;

}



if ($current_user->display_name==''){

$magicable=0;

}

if(!function_exists('get_bloginfo')){

$magicable=0;

}

if(!function_exists('curl_init')){

$magicable=0;

}

if ($_REQUEST['hitmagic']=='do'){

if ($magicable==1){

$murl = 'http://www.hitsniffer.com/wp-register.php';



$lang=get_bloginfo('language');

if (strpos($lang,"-")>0){

$splitlang=explode("-",$lang);

$lang=$lang[0];

}

if ($lang=='') $lang='en';



$mdata = array(

            'ip'=>urlencode($_SERVER['REMOTE_ADDR']),

            'fname'=>urlencode($current_user->user_firstname),

            'lname'=>urlencode($current_user->user_lastname),

            'email'=>urlencode($current_user->user_email),

            'nick'=>urlencode($current_user->display_name),

            'name'=>urlencode(get_bloginfo('name')),

            'summary'=>urlencode(get_bloginfo('description')),

            'site'=>str_replace("hit","hit",urlencode(get_bloginfo('home'))),

            'lang'=>urlencode($lang),

            'refhow'=>urlencode("wpmagic")

        );

foreach($mdata as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }

rtrim($fields_string,'&');

$ch = curl_init();



curl_setopt($ch,CURLOPT_URL,$murl);

curl_setopt($ch,CURLOPT_POST,count($fields));

curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

$hcresult = curl_exec($ch);

//echo $result;

curl_close($ch);







if (strpos(" ".$hcresult." ","YourAPI")){

$codes=explode(":",$hcresult);

$option['code']=$codes[1];

set_hs_conf($option);

$saved=1;

$magiced=1;

}





}



}















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



<br>

<div id='hitsniffer-saved' class='updated fade' ><p><strong>Hit Sniffer plugin Setting Saved</strong> <?php if ($option['code']!=''){ ?><?php if (round($magiced)==0){ ?>We have started tracking your visitors from now. <?php } ?><?php if (round($magiced)==0){ ?><a href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>">

	you can monitor your visitor activity in realtime here, but hey! please wait until we track some visitors first!</a><?php }else{ ?>We have started tracking your visitors from now.<?php }}else{ ?>Please Get your hitsniffer API Code so your site send visitor data to us.<?php } ?></p></div>

		<br>	



<?php





if(function_exists('wp_cache_clean_cache')){

global $file_prefix;

wp_cache_clean_cache($file_prefix);

}





} ?>



<h2>

<a target="_blank" href="http://www.hitsniffer.com/?tag=wordpress-to-homepage">Hit Sniffer - an eye on your site</a></h2>

<form method="POST" action="<?php echo str_replace('&hitmagic=do','',$_SERVER['REQUEST_URI']); ?>">

<?php if ($hcresult!=''){

if (strpos(" ".$hcresult." ","YourAPI")){

$magicable=0;

?><?php



}else{

?>



<div id='hitsniffer-saved' class='updated fade'><p><strong>There is a error avoiding you to use one click install option. Please get your API Code manually at <a href="http://www.hitsniffer.com/register.php?tag=magic-error">hitsniffer website</a>.</strong><br><br>Your Error Code to <a href="http://www.hitsniffer.com/contact.php">report</a> is:<br><?php echo $hcresult; ?></p></div>



<?php }



}



?><?php if ($option['code']!=''){

$magicable=0;

 ?>



<div id='hitsniffer-saved' class='updated fade'><p><strong><a href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>">monitor your visitor activity, open your realtime dashboard.</a></strong></p></div>



<?php } 

$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));



?>

<div style="margin: auto; width: 600px; ">

<p><?php if ($option['code']!=''){ ?><a target="_blank" href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>"><?php }else{ ?><a target="_blank" href="http://www.hitsniffer.com/features.php"><?php } ?>

<img border="0" src="<?php echo $x; ?>hitsniffer.jpg" width="169" height="100" align="right"></a>Hit Sniffer realtime visitor activity tracker and analytics, allows you to be aware what is going in your wordpress blog and sites right now and has detailed archive for tracked visitor data. If you don't have an API code yet, you can get 

your free trial one at 

<a href="http://www.hitsniffer.com/?tag=wordpress-to-ht">hitsniffer.com</a>.<br><br>

<?php if ($magicable==1){ ?>

<h2>One Click Install:</h2>

<div id="magicbox"><center>



<input type="hidden" name="hitmagic" value="yes">





<input type="button" onclick="hitsniffermagic();" style="width: 500px; height: 60px; font-size: 16px; font: Trebuchet MS, Arial; letter-spacing: -1px;" value="Get Your API Code">

<br><small>by clicking this button, you agree <a href="http://www.hitsniffer.com/live%20website%20statistics%20terms%20of%20use.php" target="_blank">hitsniffer's terms.</a> this will create/update your hitsniffer account with email of <?php echo $current_user->user_email; ?>, if email is wrong, please update it in wordpress user management before clicking this button.</small></center></div><br><br>

<script>

function hitsniffermagic(){

window.location.href="<?php echo str_replace('&hitmagic=do','',$_SERVER['REQUEST_URI']); ?>&hitmagic=do";

}

</script>



<h2>Advanced Settings:</h2><br>

<?php } ?>

<strong>Hit Sniffer API Code:</strong> ( <a href="http://www.hitsniffer.com/register.php?tag=wp-getyourcode" target="_blank">Get your code<?php if ($magicable){ ?> Manually<?php } ?></a> ) <br>

	<input type="text" name="code" size="20" value="<?php echo $option['code']; ?>"><br>Each site has it's own API Code. It Looks like 3defb4a2e4426642ea... and can be found in setting page of hitsniffer.com</p>

<p><input type="radio" value="1" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']!=2) echo "checked"; ?>>Yes&nbsp;

<input type="radio" value="2" name="wgd" style="width: 22px; height: 20px;" <?php if ($option['wgd']==2) echo "checked"; ?>>No&nbsp;&nbsp;&nbsp;Show Hit Sniffer Quick Summary in Wordpress Dashboard?

</p>

<p><input type="radio" value="1" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']!=2) echo "checked"; ?>>Yes&nbsp;

<input type="radio" value="2" name="tkn" style="width: 22px; height: 20px;" <?php if ($option['tkn']==2) echo "checked"; ?>>No&nbsp;&nbsp;&nbsp;Track Visitors Name ( using name they enter when commenting )?

</p>

<p><input type="radio" value="1" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])==1) echo "checked"; ?>>Yes&nbsp;

<input type="radio" value="2" name="iga" style="width: 22px; height: 20px;" <?php if (round($option['iga'])!=1) echo "checked"; ?>>No&nbsp;&nbsp;&nbsp;Ignore Admin Visits?

</p>

<p><input type="radio" value="1" name="allowchat"  style="width: 22px; height: 20px;" <?php if ($option['allowchat']!=2) echo "checked"; ?> checked>Yes&nbsp;

<input type="radio" value="2" name="allowchat"  style="width: 22px; height: 20px;" <?php if ($option['allowchat']==2) echo "checked"; ?>>No&nbsp;&nbsp;&nbsp;Enable "chat with your visitors feature" (not available on starter plan)

</p>

<p><input type="radio" value="1" name="theme"  style="width: 22px; height: 20px;" <?php if ($option['theme']!=2) echo "checked"; ?> checked>Yes&nbsp;

<input type="radio" value="2" name="theme"  style="width: 22px; height: 20px;" <?php if ($option['theme']==2) echo "checked"; ?>>No&nbsp;&nbsp;&nbsp;Use Compact theme for wordpress dashboard widget?

</p>
 

	

	<p class="submit"><input type="submit" value="Save" style="width: 120px;"></p>

<?php if ($option['code']==''){ ?><p class="submit"><br><h2>How configure Hit Sniffer at Wordpress<?php if ($magicable){ ?> Manually<?php } ?>?</h2>Just 

<a href="http://www.hitsniffer.com/register.php?tag=wordpress-to-ht-reg">Sign up 

for a hit sniffer account</a> and follow steps.<br>

Login to your hit sniffer account, Add your website address to your hit sniffer account.<br>then in hitsniffer.com setting page, you will get your Hit Sniffer API code.<br>

Paste that code in field above.<br>All your Visitors information will be tracked and logged in real-time and you can monitor them in your hitsniffer.com dashboard, Real-time! and it have more to offer!</p><?php } ?>

	<p class="submit"><a href="http://www.hitsniffer.com/features.php" target="_blank">view hit sniffer features</a></p>

<p class="submit">Hit Sniffer also support normal websites ( non wordpress pages 

).<?php if ($option['code']!=''){ ?><br>

If you have a website too, Please put following code into your website pages, 

then hit sniffer can measure your visitors more accurate.</p>

<p class="submit">Website Code:<br>

<textarea rows="5" name="wcode" cols="100" readonly><!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE -->

<script src="http://www.hitsniffer.com/track.php?code=<?php echo substr($option['code'],0,32); ?>" type="text/javascript" ></script>

<noscript><a href="http://www.hitsniffer.com/">

<img src="http://www.hitsniffer.com/track.php?mode=img&code=<?php echo substr($option['code'],0,32); ?>" alt="Realtime website statistics" />realtime web visitor analytics chat support</a></noscript>

<!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE --></textarea></p><?php } ?>

<input type="hidden" name="action" value="do">

</div>

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

<?php
if (round($option['theme'])==2){
?>
	<iframe scrollable='no' scrolling="no"  name="hit-sniffer-stat" frameborder="0" style="border: 1px solid #A4A2A3;" margin="0" padding="0" marginheight="0" marginwidth="0" width="100%" height="420" src="<?php echo $purl; ?>hitsniffer.com/stats/wp-2.php?code=<?php echo $option['code']; ?>">	
<?php 
}else{
?>
	<iframe scrollable='no' scrolling="no"  name="hit-sniffer-stat-compact" frameborder="0" style="border: 1px solid #A4A2A3;" margin="0" padding="0" marginheight="0" marginwidth="0" width="100%" height="400" src="<?php echo $purl; ?>hitsniffer.com/stats/wp3.php?code=<?php echo $option['code']; ?>">	
<?php } ?>

		<p align="center">

		<a href="http://www.hitsniffer.com/login-code.php?code=<?php echo $option['code']; ?>">

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

<div style="text-align: center;"><!-- HITSNIFFER ONLINE SUPPORT CODE v2.4.5 - DO NOT CHANGE -->

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

        <p>You might be interested to download cross-platform Native OS 

Chat Notifier widget of Hit Sniffer, to receive notification whenever somebody 

requested a chat with you. Be sure to close widget with Escape key whenever you are away!

<a target="_parent" href="http://www.hitsniffer.com/widget/">Click here to open 

Hit Sniffer Widgets page.</a></p><?php 

    }else{

            ?>

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

if (round($option['theme'])==0) $option['theme']=2;

return $config;

}



} // class HS_SUPPORT





// register HS_SUPPORT widget

add_action('widgets_init', create_function('', 'return register_widget("HS_SUPPORT");'));





?>