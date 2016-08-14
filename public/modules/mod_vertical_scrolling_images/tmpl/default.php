<?php
/**
 * Vertical scrolling images Module
 *
 * @package Vertical scrolling images
 * @subpackage Vertical scrolling images
 * @version   3.0 February, 2012
 * @author    Gopi http://www.gopiplus.com
 * @copyright Copyright (C) 2010 - 2012 www.gopiplus.com, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

if ( ! empty($images) ) 
{
	$ivrss_count = 0;
	$ivrss_html = "";
	$ivrss_js = "";
	$ivrss_scrollercount = $scrollercount;
	if(!is_numeric($height))
	{
		$height = 80;
	}
	if(!is_numeric($ivrss_scrollercount))
	{
		$ivrss_scrollercount = 5;
	}
	foreach ( $images as $images ) 
	{
		$ivrss_path = JURI::base().$folder .DS. $images->name;
		$ivrss_path = str_replace('\\', '/', $ivrss_path);
		$dis_height = $height."px";
		$ivrss_html = $ivrss_html . "<div class='cas_div' style='height:@$dis_height;padding:2px 0px 2px 0px;'>"; 
		$ivrss_html = $ivrss_html . "<a style='text-decoration:none' target='_blank' class='cas_div' href='$link'><img border='0' src='$ivrss_path'></a>";
		$ivrss_html = $ivrss_html . "</div>";
		$ivrss_js = $ivrss_js . "ivrss_array[$ivrss_count] = '<div class=\'cas_div\' style=\'height:$dis_height;padding:2px 0px 2px 0px;\'><a style=\'text-decoration:none\' target=\'_blank\' class=\'cas_div\' href=\'$link\'><img border=\'0\' src=\'$ivrss_path\'></a></div>'; ";	
		$ivrss_count++;
	}
	$height = $height + 4;
	if($ivrss_count >= $ivrss_scrollercount)
	{
		$ivrss_count = $ivrss_scrollercount;
		$ivrss_height = ($height * $ivrss_scrollercount);
	}
	else
	{
		$ivrss_count = $ivrss_count;
		$ivrss_height = ($ivrss_count*$height);
	}
	$ivrss_height1 = $height."px";
}
?>
<div style="padding-top:8px;padding-bottom:8px;">
  <div style="text-align:left;vertical-align:middle;text-decoration: none;overflow: hidden; position: relative; margin-left: 1px; height: <?php echo $ivrss_height1; ?>;" id="ivrss_holder1_<?php echo $moduleclass_sfx; ?>"> <?php echo $ivrss_html; ?> </div>
</div>
<script type="text/javascript" language="javascript">
var ivrss_array	= new Array();
var ivrss_obj	= '';
var ivrss_scrollPos 	= '';
var ivrss_numScrolls	= '';
var ivrss_heightOfElm = '<?php echo $height; ?>';
var ivrss_numberOfElm = '<?php echo $ivrss_count; ?>';
var ivrss_scrollOn 	= 'true';
function ivrss_createscroll() 
{
    <?php echo $ivrss_js; ?>
    ivrss_obj	= document.getElementById('ivrss_holder1_<?php echo $moduleclass_sfx; ?>');
    ivrss_obj.style.height = (ivrss_numberOfElm * ivrss_heightOfElm) + 'px'; 
    ivrss_content();
}
</script> 
<script type="text/javascript">
ivrss_createscroll();
</script> 
