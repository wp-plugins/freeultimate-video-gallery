<?php
/*
	Plugin Name: Ultimatebasic Video Gallery by www.pluginswp.com
	Plugin URI: http://www.pluginswp.com/ultimate-video-gallery/
	Description: Ultimate video gallery is a very fast, easy, powerfull and quick plugin to add a nice video gallery in your Wordpress. In 2 little steps you can add your flv videos and youtube videos in your post, pages and sidebar. 3 in 1.
	 You will see a new button on your wordpress administrator, "freeultimate Video." Click here to create your videos galleries. To insert a gallery in your posts, type [freeultimate_video X/], where X is the ID of the gallery. 
	Version: 0.1
	Author: pluginswp.com
	Author URI: http://www.pluginswp.com/
*/	
$contador=0;

$nombrebox="Webpsilon".rand(99, 99999);
function freeultimate_video_head() {
	
	$site_url = get_option( 'siteurl' );

			
}
function freeultimate_video($content){
	$content = preg_replace_callback("/\[freeultimate_video ([^]]*)\/\]/i", "freeultimate_video_render", $content);
	return $content;
	
}

function freeultimate_video_render($tag_string){
$contador=rand(9, 9999999);
	$site_url = get_option( 'siteurl' );
global $wpdb; 	
$table_name = $wpdb->prefix . "freeultimate_video";	


if(isset($tag_string[1])) {
	$auxi1=str_replace(" ", "", $tag_string[1]);
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = ".$auxi1.";" );
}
if(count($myrows)<1) $myrows = $wpdb->get_results( "SELECT * FROM $table_name;" );
	$conta=0;
	$id= $myrows[$conta]->id;
	$video = $myrows[$conta]->video;
	$titles = $myrows[$conta]->titles;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;
	$tumb = $myrows[$conta]->tumb;
	$round = $myrows[$conta]->round;
	$controls = $myrows[$conta]->controls;
	$skin = $myrows[$conta]->skin;
	$columns = $myrows[$conta]->columns;
	$row= $myrows[$conta]->row;
	$color1 = $myrows[$conta]->color1;
	$color2 = $myrows[$conta]->color2;
	$autoplay = $myrows[$conta]->autoplay;

	$tags = $myrows[$conta]->tags;
	
	$texto='';
	
	

$texto='title='.$titles.'&controls='.$controls.'&color1='.$color1.'&color2='.$color2.'&round='.$round.'&autoplay='.$autoplay.'&skin='.$skin.'&youtube='.$youtube.'&columns='.$columns.'&rows='.$row.'&tumb='.$tumb.'&round='.$round;

$links = array();
$titlesa = array();
if($video!="") $links=preg_split ("/\n/", $video);
if($titles!="") $titlesa=preg_split ("/\n/", $titles);
$cont1=0;

while($cont1<count($links)) {
	$auxititle="";
	$auxivideo="";
	$auxtipo=0;
	if(isset($titlesa[$cont1])) $auxititle=$titlesa[$cont1];
	if(isset($links[$cont1])) $auxivideo=$links[$cont1];
	if($auxivideo!="") {
		$auxtipo=1;
		if(strstr($auxivideo, "http")) {
			if(strpos($auxivideo, "youtube")>0) {
				$auxivideo=getYTidfreeultimate($auxivideo);
				$auxtipo=2;
				
			}
			else $auxtipo=1;
		}
		else $auxtipo=2;
		

	}
	$texto.='&video'.$cont1.'='.$auxivideo.'&title'.$cont1.'='.$auxititle.'&tipo'.$cont1.'='.$auxtipo;
	$cont1++;
}
$texto.='&cantidad='.$cont1;
	
	

	
	$table_name = $wpdb->prefix . "freeultimate_video";
	$saludo= $wpdb->get_var("SELECT id FROM $table_name ORDER BY RAND() LIMIT 0, 1; " );
	$output='
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$width.'" height="'.$height.'" id="freeultimate'.$id.'-'.$contador.'" title="'.$tags.'">
  <param name="movie" value="'.$site_url.'/wp-content/plugins/freeultimate-video-gallery/freeultimate_video.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  	<param name="flashvars" value="'.$texto.'" />
	   <param name="allowFullScreen" value="true" />
  <param name="swfversion" value="9.0.45.0" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
  <param name="expressinstall" value="'.$site_url.'/wp-content/plugins/freeultimate-video-gallery/Scripts/expressInstall.swf" />
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="'.$site_url.'/wp-content/plugins/freeultimate-video-gallery/freeultimate_video.swf" width="'.$width.'" height="'.$height.'">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="transparent" />
    	<param name="flashvars" value="'.$texto.'" />
		   <param name="allowFullScreen" value="true" />
    <param name="swfversion" value="9.0.45.0" />
    <param name="expressinstall" value="'.$site_url.'/wp-content/plugins/freeultimate-video-gallery/Scripts/expressInstall.swf" />
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    <div>
      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
<script type="text/javascript">
<!--
swfobject.registerObject("freeultimate'.$id.'-'.$contador.'");
//-->
</script><br/>'.$ligtext;
	return $output;
}


function getYTidfreeultimate($ytURL) {
#
 
#
$ytvIDlen = 11; // This is the length of YouTube's video IDs
#
 
#
// The ID string starts after "v=", which is usually right after
#
// "youtube.com/watch?" in the URL
#
$idStarts = strpos($ytURL, "?v=");
#
 
#
// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
#
// bases covered), it will be after an "&":
#
if($idStarts === FALSE)
#
$idStarts = strpos($ytURL, "&v=");
#
// If still FALSE, URL doesn't have a vid ID
#
if($idStarts === FALSE)
#
die("YouTube video ID not found. Please double-check your URL.");
#
 
#
// Offset the start location to match the beginning of the ID string
#
$idStarts +=3;
#
 
#
// Get the ID string and return it
#
$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
#
 
#
return $ytvID;
#
 
#
}


function freeultimate_video_instala(){
	global $wpdb; 
	$table_name= $wpdb->prefix . "freeultimate_video";
   $sql = " CREATE TABLE $table_name(
		id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		video longtext NOT NULL ,
		titles longtext NOT NULL ,
		width tinytext NOT NULL ,
		height tinytext NOT NULL ,
		tumb tinytext NOT NULL ,
		round tinytext NOT NULL ,
		controls tinytext NOT NULL ,
		skin tinytext NOT NULL ,
		columns tinytext NOT NULL ,
		row tinytext NOT NULL ,
		color1 tinytext NOT NULL ,
		color2 tinytext NOT NULL ,
		autoplay tinytext NOT NULL ,
		tags tinytext NOT NULL ,
		PRIMARY KEY ( `id` )	
	) ;";

   	$id= $myrows[$conta]->id;
	$video = $myrows[$conta]->video;
	$titles = $myrows[$conta]->titles;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;
	$tumb = $myrows[$conta]->tumb;
	$round = $myrows[$conta]->round;
	$controls = $myrows[$conta]->controls;
	$skin = $myrows[$conta]->skin;
	$columns = $myrows[$conta]->columns;
	$row= $myrows[$conta]->row;
	$color1 = $myrows[$conta]->color1;
	$color2 = $myrows[$conta]->color2;
	$autoplay = $myrows[$conta]->autoplay;
   	$tags = $myrows[$conta]->tags;
   
	$wpdb->query($sql);
	$sql = "INSERT INTO $table_name (video, titles, width, height, tumb, round, controls, skin, columns, row, color1, color2, autoplay, tags) VALUES ('http://www.youtube.com/watch?v=uelHwf8o7_U\nhttp://www.youtube.com/watch?v=Pki6jbSbXIY\nhttp://www.youtube.com/watch?v=knuoE9-ogcc\nhttp://www.youtube.com/watch?v=r4DQKtYL62Q', 'Eminem Feat Rianna\nLord of the rings Trailer\nBarca VS Madrid Promo\nNew York', '100%', '400px', '25', '4', '0',  '1', '2', '1', '222222', 'cccccc', '0', '');";
	$wpdb->query($sql);
}
function freeultimate_video_desinstala(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "freeultimate_video";
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
}	
function freeultimate_video_panel(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "freeultimate_video";	
	
	if(isset($_POST['crear'])) {
		$re = $wpdb->query("select * from $table_name");
//autos  no existe
if(empty($re))
{
  $sql = " CREATE TABLE $table_name(
		id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		video longtext NOT NULL ,
		titles longtext NOT NULL ,
		width tinytext NOT NULL ,
		height tinytext NOT NULL ,
		tumb tinytext NOT NULL ,
		round tinytext NOT NULL ,
		controls tinytext NOT NULL ,
		skin tinytext NOT NULL ,
		columns tinytext NOT NULL ,
		row tinytext NOT NULL ,
		color1 tinytext NOT NULL ,
		color2 tinytext NOT NULL ,
		autoplay tinytext NOT NULL ,
		tags tinytext NOT NULL ,
		PRIMARY KEY ( `id` )
	) ;";
	$wpdb->query($sql);

}
		
	$sql = "INSERT INTO $table_name (video, titles, width, height, tumb, round, controls, skin, columns, row, color1, color2, autoplay, tags) VALUES ('http://www.youtube.com/watch?v=uelHwf8o7_U\nhttp://www.youtube.com/watch?v=Pki6jbSbXIY\nhttp://www.youtube.com/watch?v=knuoE9-ogcc\nhttp://www.youtube.com/watch?v=r4DQKtYL62Q', 'Eminem Feat Rianna\nLord of the rings Trailer\nBarca VS Madrid Promo\nNew York', '100%', '400px', '25', '4', '0',  '1', '2', '1', '222222', 'cccccc', '0', '');";
	$wpdb->query($sql);
	}
	
if(isset($_POST['borrar'])) {
		$sql = "DELETE FROM $table_name WHERE id = ".$_POST['borrar'].";";
	$wpdb->query($sql);
	}
	if(isset($_POST['id'])){	


$sql= "UPDATE $table_name SET `video` = '".$_POST["video".$_POST['id']]."', `titles` = '".$_POST["titles".$_POST['id']]."', `width` = '".$_POST["width".$_POST['id']]."', `height` = '".$_POST["height".$_POST['id']]."' WHERE `id` =  ".$_POST["id"]." LIMIT 1";
			$wpdb->query($sql);
	}
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name" );
$conta=0;

include('template/cabezera_panel.html');
while($conta<count($myrows)) {
	$id= $myrows[$conta]->id;
	$video = $myrows[$conta]->video;
	$titles = $myrows[$conta]->titles;
	$width = $myrows[$conta]->width;
	$height = $myrows[$conta]->height;
	$tumb = $myrows[$conta]->tumb;
	$round = $myrows[$conta]->round;
	$controls = $myrows[$conta]->controls;
	$skin = $myrows[$conta]->skin;
	$columns = $myrows[$conta]->columns;
	$row= $myrows[$conta]->row;
	$color1 = $myrows[$conta]->color1;
	$color2 = $myrows[$conta]->color2;
	$autoplay = $myrows[$conta]->autoplay;
	$tags = $myrows[$conta]->tags;
	include('template/panel.html');			
	$conta++;
	}

}


function widget_freeultimate_video($args) {

 
  
    extract($args);
	
	  $options = get_option("widget_freeultimate_video");
  if (!is_array( $options ))
{
$options = array(
      'title' => 'freeultimate Video',
	  'id' => '1'
      );
  }

	$aaux=array();
	$aaux[0]="freeultimate_video";
	
  echo $before_widget;
  echo $before_title;
  echo $options['title'];
  echo $after_title;
  $aaux[1]=$options['id'];
 echo freeultimate_video_render($aaux);
  echo $after_widget;

}



function freeultimate_video_control()
{
  $options = get_option("widget_freeultimate_video");
  if (!is_array( $options ))
{
$options = array(
      'title' => 'freeultimate Video',
	  'id' => '1'
      );
  }
 
  if ($_POST['freeultimate-Submit'])
  {
    $options['title'] = htmlspecialchars($_POST['freeultimate-WidgetTitle']);
	 $options['id'] = htmlspecialchars($_POST['freeultimate-WidgetId']);
    update_option("widget_freeultimate_video", $options);
  }
  
  
  global $wpdb; 
	$table_name = $wpdb->prefix . "freeultimate_video";
	
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name;" );

if(empty($myrows)) {
	
	echo '
	<p>First create a new gallery of videos, from the administration of freeultimate plugin.</p>
	';
}

else {
	$contaa1=0;
	$selector='<select name="freeultimate-WidgetId" id="freeultimate-WidgetId">';
	while($contaa1<count($myrows)) {
		
		
		$tt="";
		if($options['id']==$myrows[$contaa1]->id)  $tt=' selected="selected"';
		$selector.='<option value="'.$myrows[$contaa1]->id.'"'.$tt.'>'.$myrows[$contaa1]->id.'</option>';
		$contaa1++;
		
	}
	
	$selector.='</select>';
	
	
 
echo '
  <p>
    <label for="freeultimate-WidgetTitle">Widget Title: </label>
    <input type="text" id="freeultimate-WidgetTitle" name="freeultimate-WidgetTitle" value="'.$options['title'].'" /><br/>
	<label for="freeultimate-WidgetTitle">freeultimate Video Gallery ID: </label>
   '.$selector.'
    <input type="hidden" id="freeultimate-Submit" name="freeultimate-Submit" value="1" />
  </p>
';
}


}





function freeultimate_video_init(){
	register_sidebar_widget(__('freeultimate Video'), 'widget_freeultimate_video');
	register_widget_control(   'freeultimate Video', 'freeultimate_video_control', 300, 300 );
}


function freeultimate_video_add_menu(){	
	if (function_exists('add_options_page')) {
		//add_menu_page
		add_menu_page('freeultimate_video', 'freeultimate Video', 8, basename(__FILE__), 'freeultimate_video_panel');
	}
}
if (function_exists('add_action')) {
	add_action('admin_menu', 'freeultimate_video_add_menu'); 
}
add_action('wp_head', 'freeultimate_video_head');
add_filter('the_content', 'freeultimate_video');
add_action('activate_freeultimate_video/freeultimate_video.php','freeultimate_video_instala');
add_action('deactivate_freeultimate_video/freeultimate_video.php', 'freeultimate_video_desinstala');
add_action("plugins_loaded", "freeultimate_video_init");
?>