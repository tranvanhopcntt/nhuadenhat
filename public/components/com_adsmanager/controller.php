<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2012 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport( 'joomla.filesystem.file' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'tables');


/**
 * Content Component Controller
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class AdsManagerController extends JController
{
	function display($cachable = false, $urlparams = false)
	{
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$user		= JFactory::getUser();
		
		if ( ! JRequest::getCmd( 'view' ) ) {
			$default	= 'front';
			JRequest::setVar('view', $default );
		}
		
		$viewName  = JRequest::getVar('view', 'front', 'default', 'cmd');
		$type	   = JRequest::getVar('format', 'html', 'default', 'cmd');
		$view      = $this->getView($viewName,$type);
		
		if ($viewName == "edit")
		{
			$this->write();
			return;
		}
		
		$uri = JFactory::getURI();
		$baseurl = JURI::base();
		$view->assign("baseurl",$baseurl);
		$view->assignRef("baseurl",$baseurl);
		
		if (($type == "html")&&(!defined( '_ADSMANAGER_CSS' ))) {
			/** ensure that functions are declared only once */
			define( '_ADSMANAGER_CSS', 1 );
			$uri = JFactory::getURI();
			$baseurl = JURI::base();
			
			$document = JFactory::getDocument();
			$app = JFactory::getApplication();
			$templateDir = JPATH_ROOT . '/templates/' . $app->getTemplate();
			if (is_file($templateDir.'/html/com_adsmanager/css/adsmanager.css')) {
				$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
				$document->addStyleSheet($templateDir.'/html/com_adsmanager/css/adsmanager.css');
			} else {
				$document->addStyleSheet($baseurl.'components/com_adsmanager/css/adsmanager.css');
			}
		}
		
		// Push a model into the view
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		
		$contentmodel	=$this->getModel( "content" );
		$catmodel		=$this->getModel( "category" );
		$positionmodel	=$this->getModel( "position" );
		$columnmodel	=$this->getModel( "column" );
		$fieldmodel	    =$this->getModel( "field" );
		$usermodel		=$this->getModel( "user" );
		$adsmanagermodel=$this->getModel( "adsmanager" );
		$configurationmodel	=$this->getModel( "configuration" );

		if (!JError::isError( $contentmodel )) {
			$view->setModel( $contentmodel, true );
		}	
		
		$view->setModel( $contentmodel);
		$view->setModel( $catmodel);
		$view->setModel( $positionmodel);
		$view->setModel( $columnmodel);
		$view->setModel( $fieldmodel);
		$view->setModel( $usermodel);
		$view->setModel( $adsmanagermodel);
		$view->setModel( $configurationmodel);
		
		$conf = $configurationmodel->getConfiguration();
		
		if ((ADSMANAGER_SPECIAL == "abrivac") &&
			((JRequest::getCmd( 'view' ) == 'front')||(JRequest::getCmd( 'view' ) == 'rules')))
			return;
		
		if (file_exists( JPATH_BASE .'/components/com_adsmanager/cron.php' ))
			require_once( JPATH_BASE .'/components/com_adsmanager/cron.php' );
		if ($last_cron_date != "Ymd") {
			$contentmodel->manage_expiration($fieldmodel->getPlugins(),$conf);
		}
		if (function_exists("managePaidOption")) {
			managePaidOption();
		}
		
		if ($viewName == "details") {
			$contentid = JRequest::getInt( 'id',	0 );
			$content = $contentmodel->getContent($contentid,false);
			// increment views. views from ad author are not counted to prevent highclicking views of own ad
			if ( $user->id <> $content->userid || $content->userid==0) {
				$contentmodel->increaseHits($content->id);
			}
		}
		
		if (($viewName == "list")&&($user->get('id')==0)&&(JRequest::getInt( 'user',	-1 ) == 0)) {
			TTools::redirectToLogin("index.php?option=com_adsmanager&view=list&user=");
	    	return;
		}
		
		
		if ($user->get('id'))
		{
			parent::display(false);
		}
		else if ($viewName == "list")
		{
			$cache = JFactory::getCache( 'com_adsmanager' );
			$method = array( $view, 'display' );
			
			$tsearch = $app->getUserStateFromRequest('com_adsmanager.front_content.tsearch','tsearch',"");
			$limit   = $conf->ads_per_page;
			$order   = $app->getUserStateFromRequest('com_adsmanager.front_content.order','order',0,'int');
			$mode    = $app->getUserStateFromRequest('com_adsmanager.front_content.mode','mode',$conf->display_expand);
			$url = $uri->toString();
			
			echo $cache->call( $method, null,$url,$tsearch,$limit,$order,$mode) . "\n";
		}
		else
		{	
			parent::display(true);
		}
		
		$path = JPATH_ADMINISTRATOR.'/../libraries/joomla/database/table';
		JTable::addIncludePath($path);
	}
	
	function reloadForm($content,$errorMsg="") {
		$errors = $content->getErrors();
		if (count($errors) > 0 )
			$error_msg = htmlspecialchars(implode("<br/>",$errors));
		else 	
			$error_msg = htmlspecialchars($errorMsg);
			
		$catid = JRequest::getInt('category', 0 );
		$url = TRoute::_("index.php?option=com_adsmanager&task=write&catid=$catid");
		echo "<form name='form' action='$url' method='post'>"; 
		foreach(JRequest::get( 'post' ) as $key=>$val) 
		{
			if (is_array($val))
				$val = implode(',',$val);
			echo "<input type='hidden' name='$key' value=\"".htmlspecialchars($val)."\">"; 
		}
		echo "<input type='hidden' name='errorMsg' value='$error_msg'>"; 
		echo '</form>'; 
		echo '<script language="JavaScript">'; 
		echo 'document.form.submit()'; 
		echo '</script>'; 		
		exit();
	}
	
	function write()
	{
		$app = JFactory::getApplication();
		
		$document = JFactory::getDocument();
		
		// Set the default view name from the Request
		$type = "html";
		
		$uri = JFactory::getURI();
		$baseurl = JURI::base();
		
		// Push a model into the view
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$configurationmodel	=$this->getModel( "configuration" );
		$catmodel		    =$this->getModel( "category" );
		$contentmodel		=$this->getModel( "content" );
		$fieldmodel			=$this->getModel( "field" );
		$usermodel			=$this->getModel( "user");
		$user = JFactory::getUser();
		$conf = $configurationmodel->getConfiguration();
		
		
		if (!defined( '_ADSMANAGER_CSS' )) {
			/** ensure that functions are declared only once */
			define( '_ADSMANAGER_CSS', 1 );
			$uri = JFactory::getURI();
			$baseurl = JURI::base();
			$document = JFactory::getDocument();
			$templateDir = JPATH_ROOT . '/templates/' . $app->getTemplate();
			if (is_file($templateDir.'/html/com_adsmanager/css/adsmanager.css')) {
				$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
				$document->addStyleSheet($templateDir.'/html/com_adsmanager/css/adsmanager.css');
			} else {
				$document->addStyleSheet($baseurl.'components/com_adsmanager/css/adsmanager.css');
			}
		}
		
		$document->addStyleSheet($baseurl.'components/com_adsmanager/js/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css');	
		$document->addScript($baseurl.'components/com_adsmanager/js/plupload/plupload.full.js');
		$document->addScript($baseurl.'components/com_adsmanager/js/plupload/jquery.plupload.queue/jquery.plupload.queue.js');
		$lang = JFactory::getLanguage();
		$tag = $lang->getTag();
		$tag = substr($tag,0,strpos($tag,'-'));
		if (file_exists(JPATH_BASE."/components/com_adsmanager/js/plupload/i18n/{$tag}.js"))
			$document->addScript($baseurl."components/com_adsmanager/js/plupload/i18n/{$tag}.js");	
		
		/* submission_type = 1 -> Account needed */
	    if (($conf->submission_type == 1)&&($user->id == "0")) {	
	    	TTools::redirectToLogin("index.php?option=com_adsmanager&task=write");
	    	return;
	    }
	    else
	    {
		    $contentid = JRequest::getInt( 'id', 0 );
		    $nbcontents = $contentmodel->getNbContentsOfUser($user->id);
		  
			if (($contentid == 0)&&($user->id != "0")&&($conf->nb_ads_by_user != -1)&&($nbcontents >= $conf->nb_ads_by_user))
			{
				//REDIRECT
				$redirect_text = sprintf(JText::_('ADSMANAGER_MAX_NUM_ADS_REACHED'),$conf->nb_ads_by_user);
				$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=list'), $redirect_text );
			}
			else 
			{
				$view = $this->getView("edit",'html');
				$view->setModel( $contentmodel, true );
				$view->setModel( $catmodel );
				$view->setModel( $configurationmodel );
				$view->setModel( $fieldmodel );
				$view->setModel( $usermodel );
				
				$uri = JFactory::getURI();
				$baseurl = JURI::base();
				$view->assign("baseurl",$baseurl);
				$view->assignRef("baseurl",$baseurl);
		
				$view->display();
			}
	    }
	    $path = JPATH_ADMINISTRATOR.'/../libraries/joomla/database/table';
		JTable::addIncludePath($path);
	}

	/**
	* Saves the content item an edit form submit
	*
	* @todo
	*/
	function save()
	{	
		$app = JFactory::getApplication();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$user = JFactory::getUser();
		$content = JTable::getInstance('contents', 'AdsmanagerTable');
		
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$configurationmodel	=$this->getModel( "configuration" );
		$contentmodel		=$this->getModel( "content" );
		$usermodel			=$this->getModel( "user" );
		$fieldmodel 		=$this->getModel("field");
		$conf = $configurationmodel->getConfiguration();
		$plugins = $fieldmodel->getPlugins();
		
		$id = JRequest::getInt( 'id', 0 );
		
		// New or Update
		if ($id != 0) {	
			$content->load($id);
			if (($content == null)||($content->userid != $user->id)) {
				$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=list'), "" );
			}
			
			$isUpdateMode = 1;
			$redirect_text = JText::_('ADSMANAGER_AD_UPDATED');
		} else {
			$isUpdateMode = 0;
			if ($conf->auto_publish == 0)
				$redirect_text = JText::_('ADSMANAGER_INSERT_SUCCESSFULL_CONFIRM');
			else
				$redirect_text = JText::_('ADSMANAGER_INSERT_SUCCESSFULL_PUBLISH');
		}
		
		//Check Max Ads by User
		if (($id == 0)&&($user->id != "0")&&($conf->nb_ads_by_user != -1))
		{
			$nb = $contentmodel->getNbContentsOfUser($user->id);
			if ($nb >= $conf->nb_ads_by_user)
			{
				$redirect_text = sprintf(JText::_('ADSMANAGER_MAX_NUM_ADS_REACHED'),$conf->nb_ads_by_user);
				$app->redirect(TRoute::_('index.php?option=com_adsmanager&view=list'), $redirect_text );
			}
		}
		
		$current = clone $content;
				
		$content->bindContent(JRequest::get( 'post' ),JRequest::get( 'files' ),
							  $conf,$this->getModel("adsmanager"),$plugins);
		
		
		if (function_exists('bindPaidSystemContent')) {
			bindPaidSystemContent($content,
								  JRequest::get( 'post' ),JRequest::get( 'files' ),
								  $conf,$this->getModel("adsmanager"));
		}
		
		$content->current = $current;

		$errors = $content->getErrors();
		if (count($errors) > 0) {
			$this->reloadForm($content);  
		}
		
		if ($conf->metadata_mode == 'backendonly') {
			$content->metadata_description = JRequest::getVar('ad_text', '');
			$content->metadata_keywords = str_replace(" ",",",JRequest::getVar('ad_headline', ''));
		}
		
		$errorMsg = null;
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('adsmanagercontent');
		
		try {
			$results = $dispatcher->trigger('ADSonContentBeforeSave', array ());
		} catch(Exception $e) {
			$errorMsg = $e->getMessage();
			$this->reloadForm($content,$errorMsg);
		}
		
		//Creation of account if needed
		if (($conf->submission_type == 0)&&($user->id == 0))
		{
			$username = JRequest::getVar('username', "" );
			$password = JRequest::getVar('password', ""  );
			$email = JRequest::getVar('email', ""  );
			$errorMsg = $usermodel->checkAccount($username,$password,$email,$userid,$conf);
			if (isset($errorMsg))
			{
				$this->reloadForm($content,$errorMsg);
			}
			$user->id = $userid;
		}
		
		//Valid account or visitor are allowed to post
		if (($user->id != 0)||($conf->submission_type == 2))
		{
			$content->userid = $user->id;
		} else {
			//trying to save ad, without being registered
			return;
		}
		
		if (function_exists("getPaidSystemMode"))
			$mode = getPaidSystemMode();
		else
			$mode = "nopaidsystem";
			
		$total = 0;
				
		switch($mode) { 
			case "credits":
				computeCost($total,$items,$content,$conf,$isUpdateMode);
				if ($total == 0) {
					$content->save();
				} else if (checkCredits($total,$user->id) == true) {
					//generateBill($content,$total,$items,$mode,"ok");
					removeCredits($user->id,$total);
					$content->save();
				} else {
					$errorMsg= JText::_('PAIDSYSTEM_NOT_ENOUGH_CREDITS');
					$this->reloadForm($content,$errorMsg);
				}
				break;
				
			case "payperad":
				$adid = $content->savePending();
				computeCost($total,$items,$content,$conf,$isUpdateMode);
			
				if ($total == 0) {	
					$content->save();
				} else {
					generateBill($content,$total,$items,$mode,"pending",$adid);
				}
				break;
				
			case "nopaidsystem":
				$content->save();
				break;
		}
		
		if (($mode == "payperad" )&&($total > 0)&&($isUpdateMode ==0)) {
			if (@$conf->preview == 1)
				$app->redirect( 'index.php?option=com_adsmanager&view=preview&id='.$adid, "" );	
			else
				$app->redirect( 'index.php?option=com_paidsystem&view=payment', "" );	
		} else if ((@$conf->preview == 1)&&(JRequest::getInt('pending',0) == 1)) {
			$app->redirect( 'index.php?option=com_adsmanager&view=preview&id='.$adid, "" );	
		} else if (($mode == "payperad" )&&($total > 0)&&($isUpdateMode == 1)) {
			$app->redirect( 'index.php?option=com_paidsystem&view=payment', "" );
		} else {	
			$cache = & JFactory::getCache('com_adsmanager');
			$cache->clean();
			
			if ($isUpdateMode == 0) {
				if (($conf->send_email_on_new_to_user == 1)&&($conf->auto_publish == 1)) {
					$contentmodel->sendMailToUser($conf->new_subject,$conf->new_text,$user,$content,$conf);
				} else if (($conf->send_email_on_validation_to_user == 1)&&($conf->auto_publish == 0)) {
					$contentmodel->sendMailToUser($conf->waiting_validation_subject,$conf->waiting_validation_text,$user,$content,$conf);
				}
				if ($conf->send_email_on_new == 1) {
					$contentmodel->sendMailToAdmin($conf->admin_new_subject,$conf->admin_new_text,$user,$content,$conf);
				}
			} else {
				if ($conf->send_email_on_update_to_user == 1) {
					$contentmodel->sendMailToUser($conf->update_subject,$conf->update_text,$user,$content,$conf);
				}
				if ($conf->send_email_on_update == 1) {
					$contentmodel->sendMailToAdmin($conf->admin_update_subject,$conf->admin_update_text,$user,$content,$conf);
				}
			}
		
			JPluginHelper::importPlugin('adsmanagercontent');
			try {
				$results = $dispatcher->trigger('ADSonContentAfterSave', array ($content,$isUpdateMode,$conf));
			} catch(Exception $e) {
				$errorMsg = $e->getMessage();
			}
		
			//Redirect 
			if ($conf->submission_type == 2)
				$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=list'), $redirect_text );	
			else if (COMMUNITY_BUILDER_ADSTAB == 1)
				$app->redirect( TRoute::_('index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab'), $redirect_text );
			else
				$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=myads'), $redirect_text );
		}
	}
	
	function valid() {
		$app = JFactory::getApplication();
		$id = JRequest::getInt('id', 0);
		$user = JFactory::getUser();
		
		$db =JFactory::getDBO();
		
		$db->setQuery("SELECT id FROM #__paidsystem_orders WHERE userid=".$user->id." AND pending_id = ".$id." AND state='pending' ORDER BY id DESC");
        $orderid = $db->loadResult();

		$app->redirect( 'index.php?option=com_paidsystem&view=payment&orderid='.$orderid, "" );	
	}
	
	function delete()
	{
		$app = JFactory::getApplication();
		
		$user = JFactory::getUser();
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$configurationmodel =$this->getModel( "configuration" );
		$fieldmodel	        =$this->getModel( "field" );
		
		$content = JTable::getInstance('contents', 'AdsmanagerTable');
		
		$id = JRequest::getInt('id', 0);
		if ($id == 0) {
			$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=list'), "" );
		}
		
		$content->load($id);
		if (($content == null)||($content->userid != $user->id))
			$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=list'), "" );
		
		$conf = $configurationmodel->getConfiguration();
		$plugins = $fieldmodel->getPlugins();
		
		JPluginHelper::importPlugin('adsmanagercontent');
		$dispatcher = JDispatcher::getInstance();
		try {
			$results = $dispatcher->trigger('ADSonContentBeforeDelete', array ($content,$conf));
		} catch(Exception $e) {
			$errorMsg = $e->getMessage();
		}
		
		$content->delete($id,$conf,$plugins);
		
		JPluginHelper::importPlugin('adsmanagercontent');
		try {
			$results = $dispatcher->trigger('ADSonContentAfterDelete', array ($content,$conf));
		} catch(Exception $e) {
			$errorMsg = $e->getMessage();
		}
		
		$cache = JFactory::getCache( 'com_adsmanager');
		$cache->clean();
		
		if (COMMUNITY_BUILDER_ADSTAB == 1)
			$app->redirect( TRoute::_('index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab'), JText::_('ADSMANAGER_CONTENT_REMOVED') );
		else
			$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=myads'), JText::_('ADSMANAGER_CONTENT_REMOVED') );
	}
	
	function sendmessage()
	{
		$app = JFactory::getApplication();
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$contentid = JRequest::getInt( 'contentid',0 );
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$contentmodel =$this->getModel( "content" );
		$content = $contentmodel->getContent($contentid);
		
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('adsmanagercontent');
		
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('adsmanagercontent');
		try {
			$results = $dispatcher->trigger('ADSonMessageBeforeSend', array ());
		} catch(Exception $e) {
			$errorMsg = $e->getMessage();
			$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=message&contentid='.$contentid), $errorMsg );
		}
		
		if (isset($content))
		{
			$name = JRequest::getVar('name' , "" );
			$email = JRequest::getVar('email', "" );
			jimport('joomla.mail.helper');
			if (!JMailHelper::isEmailAddress($email))
			{
				$this->setError(JText::_('INVALID_EMAIL_ADDRESS'));
				$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid), 'INVALID_EMAIL_ADDRESS' );
			}
			$subject = JRequest::getVar('title', "" );
			$body = JRequest::getVar('body' , "" );
			$body = str_replace(array("\r\n", "\n", "\r"), "<br />", $body);
			
			$file = JRequest::getVar( 'attach_file',null,'FILES');
			if ($file['tmp_name'] != "")
			{
				$directory = ini_get('upload_tmp_dir')."";
				if ($directory == "")
					$directory = ini_get('session.save_path')."";
					
				$filename = $directory."/".basename($file['name']);
				rename($file['tmp_name'], $filename);
				if (!JUtility::sendMail($email,$name,$content->email,$subject,$body,1,NULL,NULL,$filename))
				{
					$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
					$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid), JText::_('ADSMANAGER_ERROR_SENDING_MAIL') );
				}
				$config	=JFactory::getConfig();
				$from		= $config->getValue('mailfrom');
				$fromname	= $config->getValue('fromname');
				
				$mailcontent = "Sender: $name - $email<br/>";
				$mailcontent .= "Ad Owner: $content->email (userid={$content->userid})<br/>";
				$mailcontent .= "Ad id: $content->id<br/>";
				$mailcontent .= "Ad title: $content->ad_headline<br/>";
				$mailcontent .= "Message: $body";
				
				/*if (!JUtility::sendMail($from,$fromname,$from,$subject,$mailcontent,1,NULL,NULL,$filename))
				{
					$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
					$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid), JText::_('ADSMANAGER_ERROR_SENDING_MAIL') );
				}*/
			}
			else {
				if (!JUtility::sendMail($email,$name,$content->email,$subject,$body,1))
				{
					$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
					$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid), JText::_('ADSMANAGER_ERROR_SENDING_MAIL') );
				}
				
				$config	=JFactory::getConfig();
				$from		= $config->getValue('mailfrom');
				$fromname	= $config->getValue('fromname');
				
				$mailcontent = "Sender: $name - $email<br/>";
				$mailcontent .= "Ad Owner: $content->email (userid={$content->userid})<br/>";
				$mailcontent .= "Ad id: $content->id<br/>";
				$mailcontent .= "Ad title: $content->ad_headline<br/>";
				$mailcontent .= "Message: $body";
				
				/* TODO option to activate or not
				 * if (!JUtility::sendMail($from,$fromname,$from,$subject,$body,1))
				{
					$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
					$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid), JText::_('ADSMANAGER_ERROR_SENDING_MAIL') );
				}*/	
			}
		}
		$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=details&catid='.$content->catid.'&id='.$contentid), JText::_('ADSMANAGER_EMAIL_SENT') );
	}
	
	function saveprofile()
	{
		$app = JFactory::getApplication();
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$user  = JFactory::getUser();
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$usermodel =$this->getModel( "user" );
		
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('adsmanagercontent');
		try {
			$results = $dispatcher->trigger('ADSonUserBeforeSave', array ());
		} catch(Exception $e) {
			$errorMsg = $e->getMessage();
			$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=profile'), $errorMsg );
		}
	
		$user->orig_password = $user->password;
	
		$password   =  JRequest::getVar('password', "");
		$verifyPass = JRequest::getVar('verifyPass', "");
		if($password != "") {
			if($verifyPass == $password) {
				jimport('joomla.user.helper');
				$salt = JUserHelper::genRandomPassword(32);
				$crypt = JUserHelper::getCryptedPassword($password, $salt);
				$user->password = $crypt.':'.$salt;
			} else {
				$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=profile'), JText::_('_PASS_MATCH') );
				exit();
			}
		} else {
			// Restore 'original password'
			$user->password = $user->orig_password;
		}
	
		$user->name = JRequest::getVar('name', "");
		$user->username = JRequest::getVar('username', "");
		$user->email = JRequest::getVar('email', "");
	
		unset($user->orig_password); // prevent DB error!!
	
		if (!$user->save()) {
			$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=profile'), $user->getError() );
		}
	
		$fieldmodel	    =$this->getModel( "field" );
		$usermodel->updateProfileFields($user->id,$fieldmodel->getPlugins());
		
		$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=profile'), JText::_('ADSMANAGER_PROFILE_SAVED') );
	}
	
	function upload() {
		header('Content-type: text/plain; charset=UTF-8');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	
		// Settings
		$targetDir = JPATH_BASE.'/tmp/plupload/';
		$cleanupTargetDir = false; // Remove old files
		$maxFileAge = 60 * 60; // Temp file age in seconds
	
		// 5 minutes execution time
		@set_time_limit(5 * 60);
	
		// Uncomment this one to fake upload time
		// usleep(5000);
	
		// Get parameters
		$chunk = JRequest::getInt('chunk' , 0 );
		$chunks = JRequest::getInt('chunks' , 0 );
		$fileName = JRequest::getString('name' , '' );
	
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);
	
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);
	
			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;
	
			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}
	
		// Create target dir
		if (!file_exists($targetDir))
			JFolder::create($targetDir);
	
		// Remove old temp files
		if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$filePath = $targetDir . DIRECTORY_SEPARATOR . $file;
	
				// Remove temp files if they are older than the max age
				if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
					JFile::delete($filePath);
			}
	
			closedir($dir);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	
		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
	
		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];
	
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$in = JFile::read($_FILES['file']['tmp_name']);
				$out = $targetDir . DIRECTORY_SEPARATOR . $fileName;
				if ($chunk != 0) {
						$content = JFile::read($out);
						$in = $content .$in ;
				}
				JFile::write($out,$in);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = $targetDir . DIRECTORY_SEPARATOR . $fileName;
			// Read binary input stream and append it to temp file
			$in = fopen("php://input", "rb");
			if ($chunk != 0) {
					$content = JFile::read($out);
					$in = $content.$in ;
			}
			JFile::write($out,$in);
		}
	
		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id","tmpfile" : "'.$fileName.'"}');
	}
	
	function renew() {
		$app = JFactory::getApplication();
		
		$contentid = JRequest::getInt('id', 0);
		
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'models');
		$contentmodel =$this->getModel( "content" );
		
		$confmodel =$this->getModel( "configuration" );
		$conf = $confmodel->getConfiguration();
		
		$c = $contentmodel->getContent($contentid,false);
		if ($c == null)
			exit();
			
		$expiration_time = strtotime($c->expiration_date);
		$current_time = time();
		
		if (function_exists("renewPaidAd")) {
			renewPaidAd($contentid);
		}
		else
		{
			if ($expiration_time - $current_time > ($conf->recall_time * 3600 *24)) {
				$app->redirect(TRoute::_("index.php?option=com_adsmanager"),JText::_('ADSMANAGER_CONTENT_CANNOT_RESUBMIT'));
			}
			$contentmodel->renewContent($contentid,$conf->ad_duration);
		}
		
		$cache = JFactory::getCache( 'com_adsmanager');
		$cache->clean();
			
		if (COMMUNITY_BUILDER_ADSTAB == 1)
				$app->redirect( TRoute::_('index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab'), JText::_('ADSMANAGER_CONTENT_RESUBMIT') );
			else
				$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=myads'), JText::_('ADSMANAGER_CONTENT_RESUBMIT') );
	}
}
