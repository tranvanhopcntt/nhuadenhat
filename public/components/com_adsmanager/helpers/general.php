<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2012 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Content Component HTML Helper
 *
 * @static
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class JHTMLAdsmanagerGeneral
{
	var $catid;
	var $conf;
	var $user;
	
	function __construct($catid,$conf,$user)
	{
		$this->catid = $catid;
		$this->conf = $conf;
		$this->user = $user;
	}
	
	function showGeneralLink()
	{	
		if ($this->conf->display_general_menu == 1) { 
		?>
		<div id="adsmanager_innermenu">
		<?php 
			if ($this->catid == 0)
				$link_write_ad = TRoute::_("index.php?option=com_adsmanager&task=write");
			else
				$link_write_ad = TRoute::_("index.php?option=com_adsmanager&task=write&catid={$this->catid}");
							
			switch($this->conf->comprofiler)
			{
				case 3:
					$link_show_profile = TRoute::_("index.php?option=com_community&view=profile");
					$link_show_user = TRoute::_("index.php?option=com_adsmanager&view=myads");
					break;
				case 2: 
					if (COMMUNITY_BUILDER_ADSTAB == 1) {
						$link_show_profile = TRoute::_("index.php?option=com_comprofiler&task=userDetails");
						$link_show_user = TRoute::_("index.php?option=com_comprofiler&task=showProfile&tab=AdsManagerTab");
					} else {
						$link_show_profile = TRoute::_("index.php?option=com_comprofiler&task=profile");
						$link_show_user = TRoute::_("index.php?option=com_adsmanager&view=myads");
					}
					break;
				case 1:
					$link_show_profile = TRoute::_("index.php?option=com_comprofiler&task=profile");
					$link_show_user = TRoute::_("index.php?option=com_adsmanager&view=myads");
					break;
				default:
					$link_show_profile = TRoute::_("index.php?option=com_adsmanager&view=profile");
					$link_show_user = TRoute::_("index.php?option=com_adsmanager&view=myads");
					break;
			}
		
			$link_show_rules = TRoute::_("index.php?option=com_adsmanager&view=rules");
			$link_show_all = TRoute::_("index.php?option=com_adsmanager&view=list");
			echo '<a href="'.$link_write_ad.'">'.JText::_('ADSMANAGER_MENU_WRITE').'</a> | ';
			echo '<a href="'.$link_show_all.'">'.JText::_('ADSMANAGER_MENU_ALL_ADS').'</a> | ';
			echo '<a href="'.$link_show_profile.'">'.JText::_('ADSMANAGER_MENU_PROFILE').'</a> | ';
			echo '<a href="'.$link_show_user.'">'.JText::_('ADSMANAGER_MENU_USER_ADS').'</a>';
			if ($this->conf->rules_text != "") { 
				echo ' | <a href="'.$link_show_rules.'">'.JText::_('ADSMANAGER_MENU_RULES').'</a>';	
			}
		?>
		</div>
		<br/>
	<?php
		}
	}
	
	function endTemplate() {
		/*TAG*/echo '<div style="text-align:center !important;"><a href="http://www.joomprod.com" title="'.JText::_('ADSMANAGER_FRONT_TITLE').'">'.JText::_('ADSMANAGER_FRONT_TITLE').'</a> powered by AdsManager</div>';	
	}
}