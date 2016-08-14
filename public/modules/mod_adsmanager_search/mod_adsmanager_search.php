<?php
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

require_once(JPATH_BASE.'/administrator/components/com_adsmanager/models/configuration.php');
require_once(JPATH_BASE.'/administrator/components/com_adsmanager/models/field.php');
require_once(JPATH_BASE.'/administrator/components/com_adsmanager/models/category.php');
require_once(JPATH_BASE."/components/com_adsmanager/helpers/field.php");

require_once(JPATH_SITE.DS."components".DS."com_adsmanager".DS."lib".DS."core.php");

$lang = JFactory::getLanguage();
$lang->load("com_adsmanager");

if (!defined('_ADSMANAGER_MODULE_SEARCH')) {
	define( '_ADSMANAGER_MODULE_SEARCH', 1 );
	function adsmanagerModuleSelectCategories($id, $level, $children,$catid) {
		if (@$children[$id]) {
			foreach ($children[$id] as $row) {
				if ($level == "") { ?>
					<option style="background-color:#dcdcc3;" value="<?php echo $row->id; ?>" <?php if ($catid == $row->id) echo "selected='selected'"; ?>><?php echo "-- ". $row->name." --"; ?></option>
				<?php } else { ?>
					<option value="<?php echo $row->id; ?>" <?php if ($catid == $row->id) echo "selected='selected'"; ?>><?php echo $row->name; ?></option>
				<?php } 
				adsmanagerModuleSelectCategories($row->id, $level." >> ",$children,$catid);
			}
		}
	}
	
	function adssearchDisplaySplitCategories($children,&$catid) {
		?>
		<input type="hidden" name="catid" id="category" value="<?php echo $catid?>" />
	<?php 
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
	<select parentlevel="<?php echo $level ?>" id="category_level_<?php echo $level?>" class="category_level">
	<?php if ($level == 0) {?>
	<option value="" all="1" parentid="" catid=""><?php echo JText::_('ADSMANAGER_MENU_ALL_ADS'); ?></option>
	<?php } else {?>
	<option value="" all="1" parentid="<?php echo $list[0]->parent ?>" catid="">
	<?php } ?>
	<?php foreach ($list as $row)
	{?>
	<option value="<?php echo $row->id?>" catid="<?php echo $row->id?>" parentid="<?php echo $row->parent ?>" <?php if ($row->id == $catid) { echo "selected='selected'"; } ?>><?php echo htmlspecialchars($row->name); ?></option>
	<?php }
	?>
	</select></div>
	<?php //<?php echo TRoute::_("$link&catid=".?>
	<?php } ?>
	<script type="text/javascript">
	maxlevel = <?php echo $maxlevel?>;
	<?php if ($catid != 0) { ?>
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
		parent = jQ("option:selected",this).attr('parentid');
		nextlevel = level + 1;
		if (current != "") {
			jQ('#category_level_'+nextlevel).show();
			jQ('#category_level_'+nextlevel+ ' option').hide();
			jQ('#category_level_'+nextlevel+' option[parentid="'+current+'"]').show();
			jQ('#category_level_'+nextlevel+' option[all=1]').show();
			jQ('#category_level_'+nextlevel+' option[all=1]').first().attr('selected','selected');
			for(nextlevel = level +2;nextlevel <= maxlevel;nextlevel++) {
				jQ('#category_level_'+nextlevel).hide();
			}
			jQ('#category').val(current);
		} else {
			for(nextlevel = level+1;nextlevel <= maxlevel;nextlevel++) {
				jQ('#category_level_'+nextlevel).hide();
			}
			jQ('#category').val(parent);
		}
	});
	
	</script>
	<?php
	}
}

/****************************************************/
jimport( 'joomla.session.session' );	
$currentSession = JSession::getInstance('none',array());
$defaultvalues = $currentSession->get("search_fields",array());
			
$catid = $currentSession->get("searchfieldscatid",JRequest::getInt('catid', 0 ));
$app = JFactory::getApplication();
$text_search = $currentSession->get("tsearch",$app->getUserStateFromRequest('com_adsmanager.front_content.tsearch','tsearch',""));
		
$itemid = intval($params->get( 'default_itemid', JRequest::getInt('Itemid', 0 ) )) ;
$advanced_search = intval($params->get( 'advanced_search', 1)) ;
$search_by_cat = intval($params->get( 'search_by_cat', 1)) ;

$fields[] = $params->get( 'field1', "") ;
$fields[] = $params->get( 'field2', "") ;
$fields[] = $params->get( 'field3', "") ;
$fields[] = $params->get( 'field4', "") ;
$fields[] = $params->get( 'field5', "") ;
$type = $params->get( 'type', "table") ;
$listfields="";

foreach($fields as $field)
{
	if (($listfields == "")&&($field != ""))
		$listfields .= "'$field'";
	if ($field != "")
		$listfields .= ",'$field'";
}

$fieldmodel  = new AdsmanagerModelField();
$field_values = array();
if ($listfields != "")
{
	$searchfields = $fieldmodel->getFieldsByName($listfields);
	$field_values = $fieldmodel->getFieldValues();

	foreach($searchfields as $field)
	{
		if ($field->cbfieldvalues != "-1")
		{
			/*get CB value fields */
			$cbfieldvalues = $fieldmodel->getCBFieldValues($field->cbfieldvalues);
			$field_values[$field->fieldid] = $cbfieldvalues;
		}
	}
}

$categorymodel = new AdsmanagerModelCategory();
$cats = $categorymodel->getCatTree();

$confmodel = new AdsmanagerModelConfiguration();
$conf = $confmodel->getConfiguration();
$baseurl = JURI::base();

$field = new JHTMLAdsmanagerField($conf,$field_values,"2",$fieldmodel->getPlugins());//0 =>list

$url = "index.php";

require(JModuleHelper::getLayoutPath('mod_adsmanager_search'));
$content="";
$path = JPATH_ADMINISTRATOR.'/../libraries/joomla/database/table';
JTable::addIncludePath($path);