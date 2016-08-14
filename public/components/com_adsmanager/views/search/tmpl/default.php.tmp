<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<script language="JavaScript" type="text/JavaScript">
<!--
function jumpmenu(target,obj,restore){
  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
  obj.options[obj.selectedIndex].innerHTML="<?php echo JText::_('ADSMANAGER_WAIT');?>";	
}		
//-->
</script>
<div class="adsmanager_search_box">
<div class="adsmanager_inner_box">
	<div align="left">
		<table>
			<tr>
				<td><?php echo JText::_('ADSMANAGER_FORM_CATEGORY'); ?></td>
				<td>
					<select name='category_choose' onchange="jumpmenu('parent',this)">			
					 <option value="<?php echo TRoute::_("index.php?option=com_adsmanager&view=search&catid=0"); ?>" <?php if ($this->catid == 0) echo 'selected="selected"'; ?>><?php echo JText::_('ADSMANAGER_MENU_ALL_ADS'); ?></option>
					<?php
					 $link = "index.php?option=com_adsmanager&view=search";
					 $this->selectCategories(0,"",$this->cats,$this->catid,1,$link,0); 
					?>
					</select>
				</td>
			</tr>
		</table> 
		<?php $link = TRoute::_("index.php?option=com_adsmanager&view=result&catid=".$this->catid); ?>
		<form action="<?php echo $link ?>" method="post">
		<table>
			
			<?php 
			foreach($this->searchfields as $fsearch) {
				$title = $this->field->showFieldTitle($this->catid,$fsearch);
				echo "<tr><td>".htmlspecialchars($title)."</td><td>";
				$this->field->showFieldSearch($fsearch,$this->catid,null);
				echo "</td></tr>";
			}?>			
		</table> 
		<input type="hidden" value="1" name="new_search" />
		<input type="submit" value="<?php echo JText::_('ADSMANAGER_SEARCH_BUTTON'); ?>" />
		</form>
	</div>		  
</div>
</div>