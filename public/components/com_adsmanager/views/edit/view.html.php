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
class AdsmanagerViewEdit extends JView
{
	function display($tpl = null)
	{
		$app = JFactory::getApplication();

		$user		= JFactory::getUser();
		$app	= JFactory::getApplication();
		$pathway = $app->getPathway();
		$document	= JFactory::getDocument();
		
		$configurationmodel	= $this->getModel("configuration");
		$fieldmodel		= $this->getModel("field");
		$contentmodel	= $this->getModel("content");
		$catmodel		= $this->getModel("category");
		$usermodel		= $this->getModel("user");
		
		// Get the parameters of the active menu item
		$menus	= $app->getMenu();
		$menu    = $menus->getActive();
		
		$conf = $configurationmodel->getConfiguration();
		
		$this->assignRef('conf',$conf);	
		
		$fields = $fieldmodel->getFields();	
		$this->assignRef('fields',$fields);
		
		
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
		$this->assignRef('field_values',$field_values);
		
		$plugins = $fieldmodel->getPlugins();
		$field = new JHTMLAdsmanagerField($conf,$field_values,"1",$plugins);
		
		$this->assignRef('field',$field);
		
		$errorMsg = JRequest::getString( 'errorMsg',	"" );
		$this->assignRef('errorMsg',$errorMsg);	
		
		/* No need to user query, if errorMsg */
		if ($errorMsg == "")
		{
			if ($conf->comprofiler == 0)
			{	
				$profile = $usermodel->getProfile($user->id);
			}
			else if (COMMUNITY_BUILDER == 1)
			{
				$profile = $usermodel->getCBProfile($user->id);
			} else {
				$profile = new stdClass();
			}
			$this->assignRef('default',$profile);
		}
		
		$contentid = JRequest::getInt( 'id', 0 );
		
		// Update Ad ?
		if ($contentid > 0)
		{ // edit ad	
			$content = $contentmodel->getContent($contentid,false);
			//$content->ad_text = str_replace ('<br/>',"\r\n",$content->ad_text);
			
			if ($content->userid == $user->id)
			{
				$isUpdateMode = 1;
			}
			else
			{
				if (COMMUNITY_BUILDER_ADSTAB == 1)
					$app->redirect( TRoute::_('index.php?option=com_comprofiler&task=userProfile&tab=AdsManagerTab'),"" );
				else
					$app->redirect( TRoute::_('index.php?option=com_adsmanager&view=myads'), "" );
			}
			
		}
		else { // insert
			$isUpdateMode = 0;	
		}
		
		$this->assignRef('content',$content);
		$this->assignRef('isUpdateMode',$isUpdateMode);
		
		$catid = JRequest::getInt( 'catid',	0 );
		
		if (($catid == 0)&&($isUpdateMode == 1))
		{
			$catid = $content->cats[0]->catid;
		}
		
		if ($catid != "0") {
			$category = $catmodel->getCategory($catid);
			$category->img = JPATH_BASE.'/images/com_adsmanager/categories/'.$catid.'cat_t.jpg';
		}
		else
		{
			$category = new stdClass();
			$category->name = JText::_("");
			$category->description = "";
			$category->img = "";
		}
		$this->assignRef('category',$category);
		$this->assignRef('catid',$catid);
		
		if (isset($content))
			$extra = " - ".$content->ad_headline;
		else
			$extra = "";
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE')." ".$category->name.$extra);
		
		$tree = $catmodel->getCatTree();
		$this->assignRef('cats',$tree);
		
		if ($errorMsg != "") {
			//$post = (object) $_POST;
			$this->assignRef('default',JRequest::get( 'post' ));
		}
			
		if (($conf->submission_type == 2)&&($user->id == "0"))
		{
			$txt = JText::_('ADSMANAGER_WARNING_NEW_AD_NO_ACCOUNT')."<br/>";
			$this->assignRef('warning_text',$txt);
		}
		
		switch($errorMsg)
		{
			case "bad_password":
				$txt = "<div class='errormsg'>".JText::_('ADSMANAGER_BAD_PASSWORD')."</div>";
				$this->assignRef('error_text',$txt);
				break;
			case "email_already_used":
				$txt = "<div class='errormsg'>".JText::_('ADSMANAGER_EMAIL_ALREADY_USED')."</div>";
				$this->assignRef('error_text',$txt);
				break;
			case "file_too_big":
				$txt = "<div class='errormsg'>".JText::_('ADSMANAGER_FILE_TOO_BIG')."</div>";
				$this->assignRef('error_text',$txt);
			default:
				if ($errorMsg != "") {
					$txt = "<div class='errormsg'>".$errorMsg."</div>";
					$this->assignRef('error_text',$txt);
				}
		}
		
		$nbcats = $conf->nbcats;
		if (function_exists("getMaxCats"))
		{
		  $nbcats = getMaxCats($conf->nbcats);
		}
		$this->assignRef('nbcats',$nbcats);
		
		if (($conf->submission_type == 0)&&($user->id == 0))
		{
			$account_creation = 1;
		}
		else
			$account_creation = 0;
		
		$this->assignRef('account_creation',$account_creation);
		
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('adsmanagercontent');
		
		$event = new stdClass();
		$results = $dispatcher->trigger('ADSonContentAfterForm', array ($content));
		$event->onContentAfterForm = trim(implode("\n", $results));
		$this->assignRef('event',$event);

		parent::display($tpl);
	}
	
	function displaySplitCategories($id, $level, $children,&$catid,$root_allowed,$link,$current_cat_only =0) {
		$listcat = array();
		$levels = array();
		
		foreach ($children as $id => $list) { 
			$level = 0;
			foreach($levels as $lid => $l) {
				if (in_array($id,$l)) {
					$level = $lid;
					break;
				}
			}
			foreach ($list as $row) {
				if (!isset($levels[$level+1]))
					$levels[$level+1] = array();
				$levels[$level+1][] = $row->id;
				if (!isset($listcat[$level]))
					$listcat[$level] = array();
				$listcat[$level][] =  $row;
			}
		}
		$maxlevel = count($listcat) -1;
		foreach($listcat as $level => $list) {
			?>
			<div class="selectcategory">
			<?php if ($level == $maxlevel) { ?>
			<select onchange="jumpmenu('parent',this)" parentlevel="<?php echo $level ?>" id="category_level_<?php echo $level?>" class="category_level">
			<?php } else { ?>
			<select parentlevel="<?php echo $level ?>" id="category_level_<?php echo $level?>" class="category_level">
			<?php } ?>
			
			<option value="" parentid="" catid=""></option>
			
			<?php foreach ($list as $row) 
			{
				if ($level == $maxlevel)
				{?>
				<option value="<?php echo TRoute::_("$link&catid=".$row->id); ?>" catid="<?php echo $row->id?>" parentid="<?php echo $row->parent ?>" <?php if ($row->id == $catid) { echo "selected='selected'"; } ?>><?php echo htmlspecialchars($row->name); ?></option>
				<?php } else {?>
				<option value="<?php echo $row->id?>" catid="<?php echo $row->id?>" parentid="<?php echo $row->parent ?>" <?php if ($row->id == $catid) { echo "selected='selected'"; } ?>><?php echo htmlspecialchars($row->name); ?></option>
				<?php 
				} 
			}
			?>
			</select></div>
			<?php //<?php echo TRoute::_("$link&catid=".?>
	<?php } ?>
	<script type="text/javascript">
	maxlevel = <?php echo $maxlevel?>;
	<?php if ($catid != 0) { ?>
		//alert("<?php echo $catid?>");
		catoption = jQ('.category_level option[catid="<?php echo $catid?>"]');
		while(catoption.attr('parentid') != 0) {
			catoption.attr('selected','selected');
			catoption = jQ('.category_level option[catid="'+catoption.attr('parentid')+'"]'); 
		}
		catoption.attr('selected','selected');
	<?php } else { ?>
		for(i=1;i<=maxlevel;i++) {
			jQ('#category_level_'+i).hide();
		}
	<?php } ?>
	
	jQ('.category_level').change(function() {
		level = jQ(this).attr('parentlevel');
		level = parseInt(level);
		current = jQ("option:selected",this).attr('catid');
		nextlevel = level + 1;
		if (current != "") {
			jQ('#category_level_'+nextlevel).show();
			jQ('#category_level_'+nextlevel+ ' option').hide();
			jQ('#category_level_'+nextlevel+' option[parentid="'+current+'"]').show();
			jQ('#category_level_'+nextlevel+' option[parentid=""]').show();
			jQ('#category_level_'+nextlevel+' option[parentid=""]').first().attr('selected','selected');
			for(nextlevel = level +2;nextlevel <= maxlevel;nextlevel++) {
				jQ('#category_level_'+nextlevel).hide();
			}
		} else {
			for(nextlevel = level+1;nextlevel <= maxlevel;nextlevel++) {
				jQ('#category_level_'+nextlevel).hide();
			}
		}
	});
	</script>
	<?php 
	}
	
	function selectCategories($id, $level, $children,&$catid,$root_allowed,$link,$current_cat_only =0) {
		if (@$children[$id]) {
			foreach ($children[$id] as $row) {
				if (($root_allowed == 1)||(!@$children[$row->id])) {
					if ($current_cat_only == 0)
					{?>
					<option value="<?php echo TRoute::_("$link&catid=".$row->id); ?>" <?php if ($row->id == $catid) { echo "selected='selected'"; } ?>><?php echo htmlspecialchars($level.$row->name); ?></option>
					<?php 
					}
					else if ($row->id == $catid)
					{
						echo $level.$row->name;
					}
				}
				$this->selectCategories($row->id, $level.$row->name." >> ", $children,$catid,$root_allowed,$link,$current_cat_only);
			}
		}
	}
	
	function displaySingleCatChooser($ad_id,$conf,$option,$cats,$catid)
	{
		
		if (($ad_id != "")&&
			  file_exists( JPATH_BASE . "/components/com_paidsystem/api.paidsystem.php"))
		{
			$display_current_cat_only = 1;
			$this->selectCategories(0,"",$cats,$catid,$conf->root_allowed,""/*$link*/,$display_current_cat_only); 
		}
		else
		{
		?>
			<script language="JavaScript" type="text/JavaScript">
			<!--
			function jumpmenu(target,obj,restore){
			  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
			  obj.options[obj.selectedIndex].innerHTML="<?php echo JText::_('ADSMANAGER_WAIT');?>";	
			}		
			//-->
			</script>
			<?php
			 if ((@$ad_id)&&($ad_id != ""))
				$link = "index.php?option=com_adsmanager&task=write&id=$ad_id";
			 else
				$link = "index.php?option=com_adsmanager&task=write";
			 
			 if (@$toto == 1) { 
			 	$this->displaySplitCategories(0,"",$cats,$catid,$conf->root_allowed,$link,0);
			 } else {
			 ?> 
			 <select class='adsmanager_required' id="catchoose" name='category_choose' onchange="jumpmenu('parent',this)">
				 <?php 
				 if ($catid == 0)
					echo "<option value='#' selected=selected>".JText::_('ADSMANAGER_SELECT_CATEGORY')."</option>";		
				 if (function_exists("selectPaidCategories"))
					selectPaidCategories(0,"",$cats,$catid,$conf->root_allowed,$link,0); 
				else
					$this->selectCategories(0,"",$cats,$catid,$conf->root_allowed,$link,0); 
				?>
			 </select>
			 
				<?php if ($conf->autocomplete) { ?>
				<script>
				(function( $ ) {
					$.widget( "ui.combobox", {
						_create: function() {
							var self = this,
								select = this.element.hide(),
								selected = select.children( ":selected" ),
								value = selected.val() ? selected.text() : "";
							var input = this.input = jQ( "<input>" )
								.insertAfter( select )
								.val( value )
								.autocomplete({
									delay: 0,
									minLength: 0,
									source: function( request, response ) {
										var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
										response( select.children( "option" ).map(function() {
											var text = jQ( this ).text();
											if ( this.value && ( !request.term || matcher.test(text) ) )
												return {
													label: text.replace(
														new RegExp(
															"(?![^&;]+;)(?!<[^<>]*)(" +
															$.ui.autocomplete.escapeRegex(request.term) +
															")(?![^<>]*>)(?![^&;]+;)", "gi"
														), "<strong>$1</strong>" ),
													value: text,
													option: this
												};
										}) );
									},
									select: function( event, ui ) {
										ui.item.option.selected = true;
										self._trigger( "selected", event, {
											item: ui.item.option
										});
										jumpmenu('parent',self.element.get(0));
									},
									change: function( event, ui ) {
										if ( !ui.item ) {
											var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( jQ(this).val() ) + "$", "i" ),
												valid = false;
											select.children( "option" ).each(function() {
												if ( jQ( this ).text().match( matcher ) ) {
													this.selected = valid = true;
													return false;
												}
											});
											if ( !valid ) {
												// remove invalid value, as it didn't match anything
												jQ( this ).val( "" );
												select.val( "" );
												input.data( "autocomplete" ).term = "";
												return false;
											}
										}
									}
								})
								.addClass( "ui-widget ui-widget-content ui-corner-left" );
			
							input.data( "autocomplete" )._renderItem = function( ul, item ) {
								return jQ( "<li></li>" )
									.data( "item.autocomplete", item )
									.append( "<a>" + item.label + "</a>" )
									.appendTo( ul );
							};
			
							this.button = jQ( "<button type='button'>&nbsp;</button>" )
								.attr( "tabIndex", -1 )
								.attr( "title", "Show All Items" )
								.insertAfter( input )
								.button({
									icons: {
										primary: "ui-icon-triangle-1-s"
									},
									text: false
								})
								.removeClass( "ui-corner-all" )
								.addClass( "ui-corner-right ui-button-icon" )
								.click(function() {
									// close if already visible
									if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
										input.autocomplete( "close" );
										return;
									}
			
									// work around a bug (likely same cause as #5265)
									jQ( this ).blur();
			
									// pass empty string as value to search for, displaying all results
									input.autocomplete( "search", "" );
									input.focus();
								});
						},
			
						destroy: function() {
							this.input.remove();
							this.button.remove();
							this.element.show();
							$.Widget.prototype.destroy.call( this );
						}
					});
				})( jQ );	
				jQ( "#catchoose" ).combobox();
				</script>
				<?php } ?>
			<?php } ?>
		<?php
		}
	}
	
	function displayCatsList($id, $level, $cats,$root_allowed) {
		if (@$cats[$id]) {
			foreach ($cats[$id] as $row) {
				if (($root_allowed == 1)||(!@$cats[$row->id])) {
					?>
					<option value="<?php echo $row->id; ?>">
					<?php echo $level.$row->name; ?>
					</option>
					<?php 
				}
				$this->displayCatsList($row->id, $level.$row->name." >> ", $cats,$root_allowed);
			}
		}
	}
	
	function displaySelectedCatsList($id, $level,$selectedcats, $cats,$root_allowed) {
		if (@$cats[$id]) {
			foreach ($cats[$id] as $row) {
				if (($root_allowed == 1)||(!@$cats[$row->id])) {
					if ((is_array($selectedcats))&&(in_array($row->id,$selectedcats))) {
					?>
					<option value="<?php echo $row->id; ?>">
					<?php echo $level.$row->name; ?>
					</option>
					<?php 
					}
				}
				$this->displaySelectedCatsList($row->id, $level.$row->name." >> ",$selectedcats,$cats,$root_allowed);
			}
		}
	}
	
	function displayMultipleCatsChooser($selectedcats,$cats,$conf,$option)
	{
	?>
	<table width="100%" border="0">
	<tr>
		<td valign="top" width="100">
			<select name="cats" class="cats" class="inputbox" size="10" multiple="multiple">
			<?php 
			if (function_exists("displayPaidCatsList"))
				displayPaidCatsList(0,"",$cats,$conf->root_allowed,$this);
			else
				$this->displayCatsList(0,"",$cats,$conf->root_allowed);
			?>
			</select>
			<br />
		</td>
		<td width="2%">
			<input class="button" type="button" value="&gt;&gt;" name="addcat" onclick="addSelectedToList('adminForm','cats','selected_cats')" title="<?php echo JText::_('ADSMANAGER_ADD'); ?>"/>
			<br/>
			<input class="button" type="button" value="&lt;&lt;" name="delcat" onclick="delSelectedFromList('adminForm','selected_cats')" title="<?php echo JText::_('ADSMANAGER_DELETE'); ?>"/>
		</td>
		<td valign="top">	
			<select name="selected_cats" class="selected_cats" multiple="multiple" class="inputbox" size="10" >
			<?php
			if (function_exists("displayPaidSelectedCatsList"))
				displayPaidSelectedCatsList(0,"",$selectedcats,$cats,$conf->root_allowed,$this);
			else
				$this->displaySelectedCatsList(0,"",$selectedcats,$cats,$conf->root_allowed);
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="3">
		<?php
		if (function_exists("displayPaidCat"))
		{
			displayPaidCat($conf->nbcats); 
		}
		else
		{
			echo sprintf(JText::_('ADSMANAGER_NBCATS_LEGEND'),$conf->nbcats);
		}
		?>
		</td>
	</tr>
	</table>
	<script type="text/javascript">
		/**
		* Adds a select item(s) from one list to another
		*/
		
		var nbmaxcats = <?php echo $conf->nbcats;?>;
		
		function addSelectedToList( frmName, srcListName, tgtListName ) {
			var form = eval( 'document.' + frmName );
			var srcList = eval( 'form.' + srcListName );
			var tgtList = eval( 'form.' + tgtListName );
			var count = 0;

			var srcLen = srcList.length;
			var tgtLen = tgtList.length;
			
			for (var i=0; i < srcLen; i++) {
				if (srcList.options[i].selected) {
					count++;
				}
			}
			if (tgtLen + count > nbmaxcats)
			{
				alert(<?php echo json_encode(JText::_('ADSMANAGER_NBCATS_LIMIT')); ?>);
				return 0;
			}
			var tgt = "x";

			//build array of target items
			for (var i=tgtLen-1; i > -1; i--) {
				tgt += "," + tgtList.options[i].value + ","
			}

			count = 0;
			for (var i=0; i < srcLen; i++) {
				if (srcList.options[i].selected && tgt.indexOf( "," + srcList.options[i].value + "," ) == -1) {
					opt = new Option( srcList.options[i].text, srcList.options[i].value );
					tgtList.options[tgtList.length] = opt;
					count++;
				}
			}
			
			updateFields();
			return count;
		}

		function delSelectedFromList( frmName, srcListName ) {
			var form = eval( 'document.' + frmName );
			var srcList = eval( 'form.' + srcListName );
			var count = 0;
			var srcLen = srcList.length;

			for (var i=srcLen-1; i > -1; i--) {
				if (srcList.options[i].selected) {
					srcList.options[i] = null;
					count++;
				}
			}
			updateFields();
			return count;
		}
	</script>
	<?php
	}
}
