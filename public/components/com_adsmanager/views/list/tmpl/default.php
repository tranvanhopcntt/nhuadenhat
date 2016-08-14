<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<script language="javascript" type="text/javascript">
function tableOrdering( order, dir, task )
{
	var form = document.adminForm; 
	form.filter_order.value = order;
	form.filter_order_Dir.value = dir;
	document.adminForm.submit( task );
}
</script>
<div class="blog LatestAds">
<div class="m-title">
<?php $conf= $this->conf; ?>
<h3>
<?php if ($conf->display_inner_pathway == 1) { ?>
   
    <?php 
        $pathway ="";
        $nb = count($this->pathlist);
        for ($i = $nb - 1 ; $i >0;$i--)
        {
            $pathway .= '<a href="'.$this->pathlist[$i]->link.'">'.$this->pathlist[$i]->text.'</a>';
            $pathway .= '<span class="arrow"> » </span>';
        }
        if (isset($this->pathlist[0]))
            $pathway .= '<a href="'.$this->pathlist[0]->link.'">'.$this->pathlist[0]->text.'</a>';
    $pathway .= '<span class="arrow"> » </span>';
	echo $pathway;
    ?>
    
<?php } ?>


<?php
/*	if ($this->list_img != "") {
		echo '<img  class="imgheading" src="'.$this->list_img.'" alt="'.$this->list_img.'" />';
	}*/
	echo JText::_($this->list_name);
	if ($this->conf->show_rss == 1)
	{
		if (isset($this->listuser))
			$linkrss = TRoute::_("index.php?option=com_adsmanager&view=list&format=feed&user=".$this->listuser);
		else
			$linkrss = TRoute::_("index.php?option=com_adsmanager&view=list&format=feed&catid=".$this->catid);
		echo '<a href="'.$linkrss.'" target="_blank"><img align="right" class="imgheading" src="'.$this->baseurl.'components/com_adsmanager/images/rss.png" alt="rss" /></a>';
	}
?>
</h3>

<div class="adsmanager_subcats">
<?php foreach($this->subcats as $key => $subcat) {
	$subcat->link = TRoute::_('index.php?option=com_adsmanager&view=list&catid='.$subcat->id);
	if ($key != 0)
		echo ' | ';
	echo '<a href="'.$subcat->link.'"><span>'.$subcat->name.'</span></a>';
} 
?>
</div>

<?php /*<div class="adsmanager_description"><?php echo $this->list_description; ?></div> */?>
<script type="text/JavaScript">
<!--
function jumpmenu(target,obj){
  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
  obj.options[obj.selectedIndex].innerHTML="<?php echo JText::_('ADSMANAGER_WAIT');?>";			
}		
//-->
</script>

<?php if (($conf->display_list_sort == 1)||($conf->display_list_search == 1)) { ?>
<div class="adsmanager_inner_box">
	<?php if ($conf->display_list_search == 1) { ?>
		<?php if ($this->catid != 0) { ?>
		<form action="<?php echo TRoute::_('index.php?option=com_adsmanager&view=list&catid='.$this->catid) ?>" method="post">
		<?php } else if ($this->modeuser == 1) {?>
		<form action="<?php echo TRoute::_('index.php?option=com_adsmanager&view=list&user='.$this->listuser) ?>" method="post">
		<?php } else  {?>
		<form action="<?php echo TRoute::_('index.php?option=com_adsmanager&view=list') ?>" method="post">
		<?php } ?>
		<div align="left">
			<input name="tsearch" id="tsearch" maxlength="20" alt="search" class="inputbox" type="text" size="20" value="<?php echo $this->tsearch;?>"  onblur="if(this.value=='') this.value='';" onfocus="if(this.value=='<?php echo $this->tsearch;?>') this.value='';" />
		</div>
		<div align="left">
			<a href="<?php echo TRoute::_("index.php?option=com_adsmanager&view=search&catid=".$this->catid);?>"><?php echo JText::_('ADSMANAGER_ADVANCED_SEARCH'); ?></a>
		</div>
		</form> 
	<?php } ?>
	<?php if ($conf->display_list_sort == 1) { ?>
		<?php 
		 if (($this->catid != 0)&&($this->catid != -1)) { 
			$urloptions = "&catid=".$this->catid; 
		 } else if ($this->modeuser == 1) {
			$urloptions = "&user=".$this->listuser;
		 } else  {
		 	$urloptions = "";
		 } ?>
		<?php if (isset($this->orders)) { ?>
		<?php echo JText::_('ADSMANAGER_ORDER_BY_TEXT'); ?>
		<select name="order" size="1" onchange="jumpmenu('parent',this)">
				<option value="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=");?>" <?php if ($this->order == "0") { echo "selected='selected'"; } ?>><?php echo JText::_('ADSMANAGER_DATE'); ?></option>
			   <?php foreach($this->orders as $o)
			   {
	               ?>
				<option value="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=".$o->fieldid);?>" <?php if ($this->order == $o->fieldid) { echo "selected='selected'"; } ?>><?php echo JText::_($o->title); ?></option>
				<?php
			   }
			 ?>
		</select>	
		<?php } ?>	
	<?php } ?>		  
</div>
<?php } ?>

<?php $this->general->showGeneralLink() ?>

<div class="adsmanager_results">
<?php
if ($this->pagination->total == 0 ) 
{
	echo JText::_('ADSMANAGER_NOENTRIES'); 
}
else
{
	$total=$this->pagination->total;
	$result=$this->pagination->getResultsCounter();
?>    
</div>
	
	<form name="adminForm" id="adminForm" method="post" action="<?php echo $this->requestURL; ?>" >
	<input type="hidden" id="mode" name="mode" value="<?php echo $this->mode?>"/>	
	<?php /*?>
	<?php  if ($this->conf->display_expand == 2) { ?>
		<script type="text/javascript">
		function changeMode(mode)
		{
			element = document.getElementById("mode");
			element.value = mode;
			form = document.getElementById("adminForm");
			form.submit();
		}
		</script>
		<div class="adsmanager_subtitle">
		<?php 
		 //Display SubTitle 
			echo '<a href="javascript:changeMode(0)">'.JText::_('ADSMANAGER_MODE_TEXT')." ".JText::_('ADSMANAGER_SHORT_TEXT').'</a>';
		    echo " / ";
		    echo '<a href="javascript:changeMode(1)">'.JText::_('ADSMANAGER_EXPAND_TEXT').'</a>';
		?>
		</div>
	<?php }  ?><?php */?> 
	<?php if ($this->mode != 1) { ?>
   <center>
		<table class="adsmanager_table zebra">
		<thead>
            <tr>
			  <th><?php echo JText::_('ADSMANAGER_CONTENT'); ?>
			 
			  <a href="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=5&orderdir=ASC");?>"><img src="<?php echo $this->baseurl ?>images/ads_img/sort_asc.png" alt="+" /></a>
			  <a href="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=5&orderdir=DESC");?>"><img src="<?php echo $this->baseurl ?>images/ads_img/sort_desc.png" alt="-" /></a>
			   
			  </th>
			  <?php 
			  	  foreach($this->columns as $col): ?>
					<th><?php echo JText::_($col->name) ?>
					<?php $order = @$this->fColumns[$col->id][0]->fieldid; ?>
					<a href="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=$order&orderdir=ASC");?>"><img src="<?php echo $this->baseurl ?>images/ads_img/sort_asc.png" alt="+" /></a>
				    <a href="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=$order&orderdir=DESC");?>"><img src="<?php echo $this->baseurl ?>images/ads_img/sort_desc.png" alt="-" /></a>
				   </th>
                    <?php 
				  endforeach;  ?>
			  <th><?php echo JText::_('ADSMANAGER_DATE'); ?>
			   <a href="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=orderdir=ASC");?>"><img src="<?php echo $this->baseurl ?>images/ads_img/sort_asc.png" alt="+" /></a>
			  <a href="<?php echo TRoute::_("index.php?option=com_adsmanager&view=list".$urloptions."&order=orderdir=DESC");?>"><img src="<?php echo $this->baseurl ?>images/ads_img/sort_desc.png" alt="-" /></a>
			  
              </th>
			</tr>
            </thead>
        <tfoot>
            <tr>
                <td colspan="5" align="right"><span><?php echo $result; ?></span></td>
            </tr>
        </tfoot> 
        <tbody>
		<?php
		foreach($this->contents as $content){
			$linkTarget = TRoute::_( "index.php?option=com_adsmanager&view=details&id=".$content->id."&catid=".$content->catid);
			if (function_exists('getContentClass')) 
				$classcontent = getContentClass($content,"list");
	  	    else
				$classcontent = "";
			?>
              
			<tr class="adsmanager_table_description <?php echo $classcontent;?> trcategory_<?php echo $content->catid?>"> 
				
                <td class="column_desc">
					<?php
					if (isset($content->images[0])) {
						echo "<a href='".$linkTarget."'><img width='120' height='100' class='adimage ' name='adimage".$content->id."' src='".$this->baseurl."images/com_adsmanager/ads/".$content->images[0]->thumbnail."' alt='".htmlspecialchars($content->ad_headline)."' /></a>";
					} else {
						echo "<a href='".$linkTarget."'><img width='120' height='100' class='adimage' src='".ADSMANAGER_NOPIC_IMG."' alt='nopic' /></a>";
					}
					?>
					<div>                    
					<h2>
						<?php echo '<a href="'.$linkTarget.'">'.$content->ad_headline.'</a>'; ?>
						<span class="adsmanager_cat"><?php echo "(".$content->parent." / ".$content->cat.")"; ?></span>
					</h2>
					<?php 
						$content->ad_text = str_replace ('<br />'," ",$content->ad_text);
						$af_text = JString::substr($content->ad_text, 0, 100);
						if (strlen($content->ad_text)>100) {
							$af_text .= "[...]";
						}
						echo $af_text;
					?>
					</div>
				</td>
				<?php 
					foreach($this->columns as $col) {
						echo '<td class="tdcenter column_'.$col->id.'">';
						if (isset($this->fColumns[$col->id]))
							foreach($this->fColumns[$col->id] as $field)
							{
								$c = $this->field->showFieldValue($content,$field); 
								if ($c != "") {
									$title = $this->field->showFieldTitle(@$content->catid,$field);
									if ($title != "")
										echo htmlspecialchars($title).": ";
									echo "$c<br/>";
								}
							}
						echo "</td>";
					}
				?>
				<td class="tdcenter column_date">
					<?php 
					$iconflag = false;
					if (($conf->show_new == true)&&($this->isNewcontent($content->date_created,$conf->nbdays_new))) {
						echo "<div class='center'><img align='center' src='".$this->baseurl."components/com_adsmanager/images/new.gif' /> ";
						$iconflag = true;
					}
					if (($conf->show_hot == true)&&($content->views >= $conf->nbhits)) {
						if ($iconflag == false)
							echo "<div class='center'>";
						echo "<img align='center' src='".$this->baseurl."components/com_adsmanager/images/hot.gif' />";
						$iconflag = true;
					}
					if ($iconflag == true)
						echo "</div>";
					echo $this->reorderDate($content->date_created); 
					?>
					<br />
					<?php
					if ($content->userid != 0)
					{
					   echo JText::_('ADSMANAGER_FROM')." "; 
	
					   if ($conf->comprofiler == 3) {
					   		$target = TRoute::_("index.php?option=com_community&view=profile&userid=".$content->userid);
					   }
					   else if (COMMUNITY_BUILDER_ADSTAB == 1)
					   {
							$target = TRoute::_("index.php?option=com_comprofiler&task=userProfile&tab=adsmanagerTab&user=".$content->userid);
					   }
					   else
					   {
							$target = TRoute::_("index.php?option=com_adsmanager&view=list&user=".$content->userid);
					   }
					   
					   if ($conf->display_fullname == 1)
					   		echo "<a href='".$target."'>".$content->fullname."</a><br/>";
					   else
					   		echo "<a href='".$target."'>".$content->user."</a><br/>";
					}
					?>
					<?php echo sprintf(JText::_('ADSMANAGER_VIEWS'),$content->views); ?>
				</td>
			</tr>
            
		<?php	
		}
		?></tbody>
		</table>
        </center>
        

	<?php 
	} else { 
$ads_by_row = 4;
$num_ads = 0;
	?>
<table class='adsmanager_inner_box_2' width="100%">
<tr align="center">
		<?php foreach($this->contents as $key => $content) 
		{ 
				if ($num_ads >= $ads_by_row) {
				echo "</tr><tr>";
				$num_ads = 0;
			}
			$linkTarget = TRoute::_( "index.php?option=com_adsmanager&view=details&id=".$content->id."&catid=".$content->catid);
			
			if ($key == 0)
				$this->loadScriptImage($this->conf->image_display);
			if (function_exists('getContentClass')) 
				$classcontent = getContentClass($content,"details");
	  	    else
				$classcontent = "";
			?>  
			<td>
            
			<div class="<?php echo $classcontent?> center item-ads-latest fl">		
				<a class="ads-title" href="<?php echo $linkTarget;?>"><?php echo $content->ad_headline;	?></a>                
               <?php  echo "<a href='".$linkTarget."'><img src='".$baseurl."images/com_adsmanager/ads/".$content->images[0]->thumbnail."' alt='".htmlspecialchars($content->ad_headline)."' border='0' /></a>";            ?>                
                <?php
                if(!empty($content->ad_shortdescript)){
					echo "<div class='shortDescription'>$content->ad_shortdescript</div>";	
				}
				if(!empty($content->ad_price)){
					echo "<div class='price'>$content->ad_price</div>";		
				}				
                echo "<div class='readmore'><a href='$linkTarget'>".JText::_( 'JDETAILS' )." <span class='arrow'>&raquo;</span></a></div>";
				//echo "<hr class='border-bottom'/>";
				?>						
			</div>
            </td>
            <?php $num_ads ++;?>
		<?php } ?>
<?php        
for(;$num_ads < $ads_by_row;$num_ads++)
{
	echo "<td></td>";
}?>
</tr>
</table>
	<?php } ?>
	<div class="pagelinks"><?php echo $this->pagination->getPagesLinks(); ?></div>
    </form>
	

<?php 
}//$this->general->endTemplate();
?>
<?php if ($this->pagination->total == 0):?>
</div>
<?php endif;?>
</div>
</div>