<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<?php
if ($image == 1)
{
?>
<div class='adsmanager_box_module_2'>
<table class='adsmanager_inner_box_2' width="100%">
<tr align="center">
<?php
$ads_by_row = 4;
$num_ads = 0;
if (isset($contents[0])) {
foreach($contents as $row) {
	if ($num_ads >= $ads_by_row) {
		echo "</tr><tr>";
		$num_ads = 0;
	}
	?>
	<td>
	<?php	
	$linkTarget = TRoute::_("index.php?option=com_adsmanager&view=details&id=".$row->id."&catid=".$row->catid);	
	 		
	if (isset($row->images[0])) {
		echo "<div class='center item-ads-latest'>";
		echo "<a class='ads-title' href='$linkTarget' title='$row->ad_headline'>".$row->ad_headline."</a>";
		echo "<a href='".$linkTarget."'><img src='".$baseurl."images/com_adsmanager/ads/".$row->images[0]->thumbnail."' alt='".htmlspecialchars($row->ad_headline)."' border='0' /></a>";
		
	}
	else
	{
		echo "<div class='center'><a href='".$linkTarget."'><img src='".ADSMANAGER_NOPIC_IMG."' alt='noimage' border='0' /></a>"; 
	}   
		

	$iconflag = false;
	if (($conf->show_new == true)&&(isNewContent($row->date_created,$conf->nbdays_new))) {
		echo "<div class='center new'><img align='center' src='".$baseurl."components/com_adsmanager/images/new.gif' /> ";
		$iconflag = true;
	}
	if (($conf->show_hot == true)&&($row->views >= $conf->nbhits)) {
		if ($iconflag == false)
			echo "<div class='center hot'>";
		echo "<img align='center' src='".$baseurl."components/com_adsmanager/images/hot.gif' />";
		$iconflag = true;
	}
	if ($iconflag == true)
		echo "</div>";
		
	if ($displaycategory == 1)
	{
		if ($iconflag == false)
			echo "";
		echo "<span class=\"adsmanager_cat\">(".$row->parent." / ".$row->cat.")</span>";
	}
	if ($displaydate == 1)
	{
		if (($iconflag == false)||($displaycategory == 1))
			echo "";
		//echo reorderDate($row->date_created);
		$iconflag = true;
	}
	//print_r($row);
	if(!empty($row->ad_shortdescript)){
		echo "<div class='shortDescription'>$row->ad_shortdescript</div>";	
		}
	if(!empty($row->ad_price)){
			echo "<div class='price'>$row->ad_price</div>";		
		}
	$first =0;
	foreach($adfields as $f) {
		$fieldname = $f->name;
		if ($row->$fieldname != null) {
			$value = $field->showFieldValue($row,$f);
			if ($first == 0)
				echo "<br/>";
			echo "$value";
			$first++;
		}
	}
	echo "<div class='readmore'><a href='$linkTarget'>".JText::_( 'JDETAILS' )." <span class='arrow'>&raquo;</span></a></div>";
	echo "<hr class='border-bottom'/>";
	echo "</div>";
	?>
	</td>
<?php
	$num_ads ++;
} }
for(;$num_ads < $ads_by_row;$num_ads++)
{
	echo "<td></td>";
}
?>
</tr>
</table>
</div>
<?php
}
else
{
	?>
	<ul class="mostread">
	<?php
	if (isset($contents[0])) {
	foreach($contents as $row) {
	?>
		<li class="mostread">
		<?php	
			$linkTarget = TRoute::_("index.php?option=com_adsmanager&view=details&id=".$row->id."&catid=".$row->catid);
			echo "<a href='$linkTarget'>".$row->ad_headline."</a>"; 
			if ($displaycategory == 1)
				echo "<br /><span class=\"adsmanager_cat\">(".$row->parent." / ".$row->cat.")</span>";
			if ($displaydate == 1)
				echo "<br />".reorderDate($row->date_created);
		?>
		</li>
<?php
	} }
	?>
	</ul>
	<?php
}	