<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2012 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

require_once(JPATH_BASE."/components/com_adsmanager/helpers/field.php");

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewProfile extends JView
{
	function display($tpl = null)
	{
		$app = JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= $app->getPathway();
		$document	= JFactory::getDocument();
		
		$usermodel	    =$this->getModel( "user" );
		$configurationmodel	=$this->getModel( "configuration" );
		$fieldmodel =$this->getModel( "field" );
		
		$userid = $user->id;
		
		if ($userid == "0") {
			TTools::redirectToLogin("index.php?option=com_adsmanager&view=profile");	  
	    }
	    else
	    { 	
	    	$conf = $configurationmodel->getConfiguration();
			if (COMMUNITY_BUILDER == 1)
			{
				$app->redirect( TRoute::_("index.php?option=com_comprofiler&task=userDetails"), "" );
			}
			else
			{
				$fields = $usermodel->getProfileFields();
				$plugins = $fieldmodel->getPlugins();
				$field_values = $fieldmodel->getFieldValues();
				foreach($fields as $field)
				{
					if ($field->cbfieldvalues != "-1")
					{
						/*get CB value fields */
						$cbfieldvalues = $fieldmodel->getCBFieldValues($field->cbfieldvalues);
						$field_values[$field->fieldid] = $cbfieldvalues;
					}
				}
		
				$field = new JHTMLAdsmanagerField($conf,$field_values,"1",$plugins);
				$user = $usermodel->getProfile($userid);
				$this->assignRef('field',$field);		
				$this->assignRef('fields',$fields);	
				$this->assignRef('user',$user);	
			}
		}
		
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('adsmanagercontent');
		
		$event = new stdClass();
		$results = $dispatcher->trigger('ADSonUserAfterForm', array ($user));
		$event->onUserAfterForm = trim(implode("\n", $results));
		$this->assignRef('event',$event);
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE'));
		
		parent::display($tpl);
	}
}
