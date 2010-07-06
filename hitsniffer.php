<?php
/*
Plugin Name: Hit Sniffer Blog Stats
Plugin URI: http://www.hitsniffer.com/
Description: Hit Sniffer
Author: Hitsniffer.com
Version: 1.0
Author URI: http://www.HitSniffer.com/
*/ 

add_action('admin_menu', 'hs_admin_menu');
add_action('wp_head', 'hitsniffer');



function hitsniffer() {


$option=get_hs_conf();
$option['code']=html_entity_decode($option['code']);

?><!-- HITSNIFFER TRACKING CODE - DO NOT CHANGE -->
<script src="http://www.hitsniffer.com/track.php?code=<?php echo $option['code']; ?>" type="text/javascript" ></script>
<noscript><a href="http://www.hitsniffer.com/">
<img src="http://www.hitsniffer.com/track.php?mode=img&code=<?php echo $option['code']; ?>" alt="Realtime wordpress blog statistics" />blog wordpress statistics</a></noscript>
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
    <td>Hit Sniffer Setting Saved</td>
  </tr>
</table>
</center>
<?php } ?>

<h2><a target="_blank" href="http://www.hitsniffer.com/">Hit Sniffer</a></h2>
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<p>Please enter your Hit Sniffer API Code to activate it, If you don't have an API Code, get one for free at HitSniffer.com<br><br>API Code:<br>
	<textarea rows="2" name="code" cols="117" ><?php echo $option['code']; ?></textarea></p>
    
	
	<p class="submit"><input type="submit" value="Save" style="width: 120px;"></p>
	<p class="submit">More Configuration is available in Hit Sniffer Administration Area.</p>
<input type="hidden" name="action" value="do">
</form>
	
</div>

<?php
}
?>