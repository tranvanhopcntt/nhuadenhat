<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2012 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');
require_once(JPATH_BASE."/components/com_adsmanager/helpers/general.php");

/**
 * @package		Joomla
 * @subpackage	Contacts
 */  
class AdsmanagerViewFront extends JView
{
	function display($tpl = null)
	{
		jimport( 'joomla.session.session' );	
		$currentSession = JSession::getInstance('none',array());
		$currentSession->set("search_fields","");
		$currentSession->set("searchfieldscatid",0);
		$currentSession->set("searchfieldssql"," 1 ");
		$currentSession->set("tsearch","");
		
		$app	= JFactory::getApplication();
		$pathway = $app->getPathway();
		

		$user		= JFactory::getUser();
		
		$document	= JFactory::getDocument();
		
		$contentmodel	=$this->getModel( "content" );
		$catmodel	=$this->getModel( "category" );
		$configurationmodel	=$this->getModel( "configuration" );

		// Get the parameters of the active menu item
		$menus	= $app->getMenu();
		$menu    = $menus->getActive();
		
		$conf = $configurationmodel->getConfiguration();
		
		$cats = $catmodel->getCatTree(true,true,$nbcontents);
		$this->assignRef('cats',$cats);
		$this->assignRef('conf',$conf);
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE'));
		
		$general = new JHTMLAdsmanagerGeneral(0,$conf,$user);
		$this->assignRef('general',$general);
		
		$conf = $configurationmodel->getConfiguration();
		$nbimages = $conf->nb_images;
		if (function_exists("getMaxPaidSystemImages"))
		{
			$nbimages += getMaxPaidSystemImages();
		}
		$this->assignRef('nbimages',$nbimages);
		
		$nb_cols = $conf->nb_last_cols;
		$nb_rows = $conf->nb_last_rows;
		$contents = $contentmodel->getLatestContents($nb_cols*$nb_rows);
		$this->assignRef('contents',$contents);

		parent::display($tpl);
	}
	
	function recurseCategories( $id, $level, &$children) {
		
		if (@$children[$id]) {
			$i=0;$first=true;
			foreach ($children[$id] as $row) {
				$link = TRoute::_("index.php?option=com_adsmanager&view=list&catid=".$row->id);
				if ($level == 0)
				{
					if ($i==0)
					{
						echo '<tr align="center">';
					}
					?>
					<td width="50%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td rowspan="2" width="80"><div align="center">
					  <?php
						if (file_exists(JPATH_BASE."/images/com_adsmanager/categories/".$row->id."cat.jpg"))
							echo '<a href="'.$link.'"><img class="imgcat" src="'.$this->get('baseurl').'/images/com_adsmanager/categories/'.$row->id.'cat.jpg" alt="'.htmlspecialchars($row->name).'" /></a>';
						else
							echo '<a href="'.$link.'"><img class="imgcat" src="'.$this->get('baseurl').'/components/com_adsmanager/images/default.gif" alt="'.htmlspecialchars($row->name).'" /></a>';
					  ?>
					  </div></td>
					  <td> 
						<h2 class="adsmanager_main_cat"><a href="<?php echo $link; ?>"  ><?php echo htmlspecialchars($row->name)." (".$row->num_ads.")"; ?></a></h2>
					  </td>
					</tr>
					<tr>
					<td> 
					<h3 class="adsmanager_sub_cat">
					<?php
				}
				else
				{
					if ($first == false)
						echo ' - ';
					echo '<a href="'.$link.'">'.htmlspecialchars($row->name)." (".$row->num_ads.")".'</a>';
					$first = false;
				}
				if ($level == 0)
				{
					$this->recurseCategories( $row->id, $level+1, $children);
				}
				if ($level == 0)
				{
					?>
					</h3>
					</td>
					</tr>
					</table>
					</td>
					<?php
					if ($i==1)
					{
						echo '</tr>';
					}
				}
				$i++;
				if ($i == 2) $i=0;
			}
		}
	}
	
	function displayContents($contents,$nbimages) {
		$configurationmodel	=$this->getModel( "configuration" );
		$conf = $configurationmodel->getConfiguration();
	?>
		<h1 class="contentheading"><?php echo JText::_('ADSMANAGER_LAST_ADS');?></h1>
		<div class='adsmanager_box_module' align="center">
			<table class='adsmanager_inner_box' width="100%">
			<?php
			$nb_cols = $conf->nb_last_cols;
			$col = 0;
			foreach($contents as $row) {
				if ($col == 0) 
					echo '<tr align="center">';
				$col++;
			?>
				<td>
				<?php	
				$linkTarget = TRoute::_("index.php?option=com_adsmanager&view=details&id=".$row->id."&catid=".$row->catid);			
				if (isset($row->images[0])) {
					echo "<div align='center'><a href='".$linkTarget."'><img src='".$this->get('baseurl')."/images/com_adsmanager/ads/".$row->images[0]->thumbnail."' alt='".htmlspecialchars($row->ad_headline)."' border='0' /></a>";
				} else {
					echo "<div align='center'><a href='".$linkTarget."'><img src='".ADSMANAGER_NOPIC_IMG."' alt='nopic' border='0' /></a>"; 
				} 	
					
				echo "<br /><a href='$linkTarget'>".$row->ad_headline."</a>"; 
				echo "<br /><span class=\"adsmanager_cat\">(".htmlspecialchars($row->parent)." / ".htmlspecialchars($row->cat).")</span>";
				echo "<br />".$this->reorderDate($row->date_created);
				echo "</div>";
				?>
				</td>
			<?php
				if ($col == $nb_cols) {
					echo "</tr>";
					$col = 0;	
				}
			}
			?>
			</table>
			</div>
	<br />
	<?php
	}
	
	function reorderDate( $date ){
		$format = JText::_('ADSMANAGER_DATE_FORMAT_LC');
		
		if ($date && (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/",$date,$regs))) {
			$date = mktime( 0, 0, 0, $regs[2], $regs[3], $regs[1] );
			$date = $date > -1 ? strftime( $format, $date) : '-';
		}
		return $date;
	}
}
