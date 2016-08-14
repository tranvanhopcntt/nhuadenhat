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
class JHTMLAdsmanagerField
{
	var $content;
	var $conf;
	var $field_values;
	var $mode;
	var $plugins;
	
	function JHTMLAdsmanagerField($conf,$field_values,$mode,$plugins) {
		$this->conf = $conf;
		$this->field_values = $field_values;
		$this->mode = $mode;
		//if $mode = 0 (list) => modetitle = 2 only title,
	    //if $mode = 1 (details) => modeltitle = 1 (details)
		//if $mode = 2 (search) => modeltitle = 0 (search)
		$this->modetitle = 2 - $mode;
		$this->plugins = $plugins;
		$this->baseurl = JURI::root();
	}

	function showFieldTitle($catid,$field)
	{
		$return = "";
		//echo $this->modetitle." ".$catid;
		if ((strpos($field->catsid, ",".@$catid.",") !== false)||(strpos($field->catsid, ",-1,") !== false))
		{
			
			if (($this->modetitle == 0) ||
				(($field->type != 'checkbox')&&($field->display_title & $this->modetitle) == $this->modetitle))
			{
				$return = JText::_($field->title);
			}
		}
		return $return;
	}
	
	function showFieldValue($content,$field)
	{		
		$return = "";
		if ((strpos($field->catsid, ",".$content->catid.",") !== false)||(strpos($field->catsid, ",-1,") !== false))
		{			
			if ($field->title)
				$name = $field->name;
				
			$value = "";
			$content = $content;
			$val = "\$content->".$field->name;
			$fieldname = $field->name;
			//var_dump($content);
			eval("if (isset($val)) \$value = \"$val\";");
			$value = JText::_(str_replace('::',': :',$value));
			switch($field->type)
			{
				case 'checkbox':
					if (ADSMANAGER_SPECIAL == "abrivac") {
						if ($value == 1)
						{
							$return .= JText::_($field->title)."";
						}
					} else {
						if (($this->modetitle == 0) ||
							(($field->type != 'checkbox')&&($field->display_title & $this->modetitle) == $this->modetitle))
						{
							$return .= JText::_($field->title);
							if ($value == 1)
								$return .= ":&nbsp;".JText::_('ADSMANAGER_YES')."";
							else
								$return .= ":&nbsp;".JText::_('ADSMANAGER_NO')."";
						}
						else if ($value == 1)
						{
							$return .= JText::_($field->title)."";
						}		
					}
					break;
					
				case 'multicheckbox':
				case 'multicheckboximage':
					$found = 0;
					for($i=0,$nb=count($this->field_values[$field->fieldid]);$i < $nb ;$i++)
					{
						$fieldvalue = @$this->field_values[$field->fieldid][$i]->fieldvalue;
						$fieldtitle = @$this->field_values[$field->fieldid][$i]->fieldtitle;

						if (strpos($value, ",".$fieldvalue.",") !== false)
						{
							$return .= "<div class='multicheckboxfield'>";
							if ($field->type == 'multicheckbox')
								$return .= JText::_($fieldtitle);
							else
								$return .= "<img src='".$this->baseurl."images/com_adsmanager/fields/".$fieldtitle."' alt='$fieldtitle' />";
							$return .= "</div>";
						}
					}
					
					break;
					
				case 'url':
					if ((isset($field->link_text))&&($field->link_text != ""))
						$linkObj = $field->link_text;
					else if ((isset($field->link_image))&&(file_exists(JPATH_BASE."/images/com_adsmanager/fields/".$field->link_image)))
						$linkObj = "<img src='".$this->baseurl."images/com_adsmanager/fields/".$field->link_image."' />";
					else
					{
						$linkObj = $value;
					}
					if ($value != "")
					{
						$return .= "<a href='http://$value' target='_blank'>$linkObj</a><br />";
					}
					break;
					
				case 'date':
					$return .= $value;
					break;
	
				case 'select':
					if (isset($this->field_values[$field->fieldid])) {
					foreach($this->field_values[$field->fieldid] as $v)
					{
						if ($value == $v->fieldvalue)
						{
							$return .= JText::_($v->fieldtitle);
						}
					}
					}
					break;
	
				case 'multiselect':
					$found = 0;
					if (isset($this->field_values[$field->fieldid])) {
					foreach($this->field_values[$field->fieldid] as $v)
					{
						if (strpos($value, ",".$v->fieldvalue.",") === false)
						{
						}
						else
						{
							if ($found == 1)
								$return .= "<br/>";
							$return .= JText::_($v->fieldtitle);
							$found = 1;
						}
					}
					}
					break;
				
				case 'emailaddress':
					if ($value != "")
					{
						switch($this->conf->email_display) {
							case 2:
								$emailForm = TRoute::_("index.php?option=com_adsmanager&view=message&contentid=".$content->id."&catid=".$content->catid);
								$return .= '<a href="'.$emailForm.'">'.JText::_('ADSMANAGER_EMAIL_FORM').'</a>';
								break;
							case 1:
								$return .= $this->Txt2Png($value);
								break;
							default:
								$return .= JText::_('ADSMANAGER_FORM_EMAIL').": <a href='mailto:".$value."'>".$value."</a>";
								break;
						
						}
					}
					break;
				
				case 'textarea':
					$return .= str_replace(array("\r\n", "\n", "\r"), "<br />", $value);
					break;
				
				case 'editor':
				case 'number':
				case 'text':
					$return .= $value;
					break;
				case 'price':
					if ($value != "") {	
						$price =  sprintf(JText::_('ADSMANAGER_DEVICE'),number_format(floatval($value), 2, '.', ' '));
						//for Right to Left language
						$return .= str_replace(" ","&nbsp;",$price);
					}
					break;
				case 'radio':	
				case 'radioimage':	
					for($i=0,$nb=count($this->field_values[$field->fieldid]);$i < $nb ;$i++)
					{
						$fieldvalue = @$this->field_values[$field->fieldid][$i]->fieldvalue;
						$fieldtitle = @$this->field_values[$field->fieldid][$i]->fieldtitle;
						if ($value == $fieldvalue)
						{
							if ($field->type == 'radio')
								$return .= $fieldtitle;
							else
								$return .= "<img src='".$this->baseurl."images/com_adsmanager/fields/".$fieldtitle."' alt='$fieldtitle' />";
							$return .= "<br/>";					
						}
					}
					break;
				case 'file':
					if ($value != "")
					{
						$return .= "<a href='{$this->baseurl}images/com_adsmanager/files/$value' target='_blank'>".JText::_('ADSMANAGER_DOWNLOAD_FILE')."</a></b>";
					}
					break;
					
				default:
					if (isset($this->plugins[$field->type]))
					{
						if ($this->mode == 0)
							$plug = $this->plugins[$field->type]->getListDisplay($content,$field );
						else
							$plug = $this->plugins[$field->type]->getDetailsDisplay($content,$field );
						$return .= $plug;
					}
					break;
			}
		}
		return $return;
	}

	function showFieldLabel($field,$content,$default)
	{
		$return = JText::_($field->title);
		return $return;
	}
	
	function showFieldForm($field,$content,$default)
	{
		$return = "";
		
		$strtitle = JText::_($field->title);
		$strtitle = htmlspecialchars($strtitle);

		$name = $field->name;
		$value = "@\$content->".$field->name;
		eval("\$value = \"\".$value;");
		$value = JText::_($value);
		
		$default = (object) $default;
		if (($value == "")&&(isset($default)))
		{
			$value ="\$default->".$field->name;
			eval("\$value = @\"$value\";");
			$value = JText::_($value);
		}
		$disabled="";
		$read_only="";
		
		switch($field->type)
		{
			case 'checkbox':
				if ($field->required == 1)
					$mosReq = "mosReq='1'";
				else
					$mosReq = "";
														
				if ($value == 1)
					$return .= "<input class='inputbox' type='checkbox' $mosReq mosLabel='$strtitle' checked='checked' id='$name' name='$name' value='1' />\n";
				else
					$return .= "<input class='inputbox' type='checkbox' $mosReq mosLabel='$strtitle' name='$name' id='$name' value='1' />\n";
				break;
			case 'multicheckbox':
			case 'multicheckboximage':
				$k = 0;
				$return .= "<table>";
				for ($i=0 ; $i < $field->rows;$i++)
				{
					$return .= "<tr>";
					for ($j=0 ; $j < $field->cols;$j++)
					{
						$return .= "<td>";
						$fieldvalue = @$this->field_values[$field->fieldid][$k]->fieldvalue;
						$fieldtitle = @$this->field_values[$field->fieldid][$k]->fieldtitle;
						if ($field->type == 'multicheckbox') {
							if (isset($fieldtitle))
								$fieldtitle=JText::_($fieldtitle);
						}
						else
						{	
							$fieldtitle = "<img src='{$this->baseurl}images/com_adsmanager/fields/$fieldtitle' alt='$fieldtitle' />";
						} 
						if (isset($this->field_values[$field->fieldid][$k]->fieldtitle))
						{
							if (($field->required == 1)&&($k==0))
								$mosReq = "mosReq='1'";
							else
								$mosReq = "";
							
							if ((strpos($value, ",".$fieldvalue.",") === false) &&
								(strpos($value, $fieldtitle."|*|") === false) &&
								(strpos($value, "|*|".$fieldtitle) === false) &&
								($value !=  $fieldtitle))
								$return .= "<input class='inputbox' type='checkbox' $mosReq  mosLabel='$strtitle' id='".$name."[]' name='".$name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
							else
								$return .= "<input class='inputbox' type='checkbox' $mosReq  mosLabel='$strtitle' id='".$name."[]' checked='checked' name='".$name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
							
						}
						$return .= "</td>";
						$k++;
					}
					$return .= "</tr>";
				}
				$return .= "</table>";
				break;


			case 'date':
				$options = array();
				$options['size'] = 25;
				$options['maxlength'] = 19;
				if ($field->required == 1) {
					$options['class'] = 'adsmanager_required';
					$options['mosReq'] = '1';
					$options['mosLabel'] = "$strtitle";
				}
				else 
				{
					$options['class'] = 'adsmanager';
				}
				$return .= JHTML::_('behavior.calendar');
				if ($value != "") {
					if (function_exists("strptime")) {
						$a = strptime($value, JText::_('ADSMANAGER_DATE_FORMAT_LC'));
						$timestamp = mktime(0, 0, 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);
					} else {
						$timestamp = strtotime($value);
					}
					if ($timestamp != null)
						$value = date("Y-m-d",$timestamp);
					else
						$value = "";
				}
				$return .=  JHTML::_('calendar', $value, "$field->name", "$field->name", JText::_('ADSMANAGER_DATE_FORMAT_LC'), $options);
					
				//$return = "<input $class type='text' name='$field->name' id='$field->name' size='25' maxlength='19' value='$value' readonly=true/>";
				//$return .= "<input name='reset' type='reset' class='button' onclick=\"return showCalendar('$field->name', '%y-%m-%d');\" value='...' />";
				//$return .= $return;
				break;
			
			case 'editor':
                $editor = JFactory::getEditor();
				$return .= $editor->display($field->name, $value, '', '', $field->cols, $field->rows);
				break;
		
			case 'select':
				if ($field->editable == 0)
					$disabled = "disabled=true";
				else
					$disabled = "";
					
				if ($field->required == 1)
					$return .= "<select id='$name' name='$name' mosReq='1' mosLabel='$strtitle' class='adsmanager_required' $disabled>\n";
				else
					$return .= "<select id='$name' name='$name' mosLabel='$strtitle' class='adsmanager' $disabled>\n";
					
				if ($value=="")
					$return .= "<option value=''>&nbsp;</option>\n";	
				if (isset($this->field_values[$field->fieldid])) {
				foreach($this->field_values[$field->fieldid] as $v)
				{
					$ftitle = JText::_($v->fieldtitle);
					if (($value == $v->fieldvalue)||($value == $ftitle))
						$return .= "<option value='$v->fieldvalue' selected='selected' >$ftitle</option>\n";
					else
						$return .= "<option value='$v->fieldvalue' >$ftitle</option>\n";
				}
				}
				
				$return .= "</select>\n";
				break;
				
			case 'multiselect':
				if ($field->editable == 0)
					$disabled = "disabled=true";
				else
					$disabled = "";
				if ($field->required == 1)
					$return .= "<select id=\"".$name."[]\" name=\"".$name."[]\" mosReq='1' mosLabel='$strtitle' multiple='multiple' size='$field->size' class='adsmanager_required' $disabled>\n";
				else
					$return .= "<select id='".$name."[]' name=\"".$name."[]\" mosLabel='$strtitle' multiple='multiple' size='$field->size' class='adsmanager' $disabled>\n";
					
				if ($value=="")
					$return .= "<option value=''>&nbsp;</option>\n";	
				if (isset($this->field_values[$field->fieldid])) {
				foreach($this->field_values[$field->fieldid] as $v)
				{
					$ftitle = JText::_($v->fieldtitle);
					if ($field->required == 1)
						$mosReq = "mosReq='1'";
						
					if ((strpos($value, ",".$v->fieldvalue.",") === false) &&
						(strpos($value, $ftitle."|*|") === false) &&
						(strpos($value, "|*|".$ftitle) === false) &&
						($value !=  $ftitle))
						$return .= "<option value='".str_replace("'","\'",$v->fieldvalue)."' >$ftitle</option>\n";
					else
						$return .= "<option value='".str_replace("'","\'",$v->fieldvalue)."' selected='selected' >$ftitle</option>\n";
				}
				}
				
				$return .= "</select>\n";
				break;
				
			case 'textarea':
				if ($field->editable == 0)
					$read_only = "readonly=true";
				else
					$read_only = "";

				if ($field->required == 1)
					$return .= "<textarea class='adsmanager_required' mosReq='1' mosLabel='$strtitle' id='$name' name='$name' cols='".$field->cols."' rows='".$field->rows."' wrap='VIRTUAL' onkeypress='CaracMax(this, $field->maxlength) ;' $read_only>".htmlspecialchars($value)."</textarea>\n"; 
				else
					$return .= "<textarea class='adsmanager' id='$name' mosLabel='$strtitle' name='$name' cols='".$field->cols."' rows='".$field->rows."' wrap='VIRTUAL' onkeypress='CaracMax(this, $field->maxlength) ;' $read_only>".htmlspecialchars($value)."</textarea>\n"; 	
				break;
			
			case 'url':
				if (($this->mode == "write")&&($field->editable == 0))
					$recontent_only = "readonly=true";
				else
					$recontent_only = "";
					
				$return .= "http://";
				if (($this->mode == "write")&&($field->required == 1))
					$return .= "<input class='adsmanager_required' mosReq='1' id='$field->name' type='text' mosLabel='$strtitle' name='$field->name' size='$field->size' maxlength='$field->maxlength' $recontent_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n"; 
				else
					$return .= "<input class='adsmanager' id='$field->name' type='text' name='$field->name' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $recontent_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n";
				break;
		
			case 'number':
			case 'price':
				if ($field->editable == 0)
					$read_only = "readonly=true";
				else
					$read_only = "";
					
				if ($field->required == 1)
					$return .= "<input class='adsmanager_required' mosReq='1' id='$name' type='text' test='number' mosLabel='$strtitle' name='$name' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n"; 
				else
					$return .= "<input class='adsmanager' id='$name' type='text' name='$name' test='number' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n";
				break;
			case 'emailaddress':
				if ($field->editable == 0)
					$read_only = "readonly=true";
				else
					$read_only = "";
					
				if ($field->required == 1)
					$return .= "<input class='adsmanager_required' mosReq='1' id='$name' type='text' test='emailaddress' mosLabel='$strtitle' name='$name' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n"; 
				else
					$return .= "<input class='adsmanager' id='$name' type='text' test='emailaddress' name='$name' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n";
				break;
				
			case 'text':
				if ($field->editable == 0)
					$read_only = "readonly=true";
				else
					$read_only = "";
				
				if ($field->required == 1)
					$return .= "<input class='adsmanager_required' mosReq='1' id='$name' type='text' mosLabel='$strtitle' name='$name' size='$field->size' maxlength='$field->maxlength' $read_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n"; 
				else
					$return .= "<input class='adsmanager' id='$name' type='text' name='$name' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $read_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n";
				break;
				
			case 'radio':
			case 'radioimage':
				$k = 0;
				$return .= "<table>";
				for ($i=0 ; $i < $field->rows;$i++)
				{
					$return .= "<tr>";
					for ($j=0 ; $j < $field->cols;$j++)
					{
						$return .= "<td>";
						$fieldvalue = @$this->field_values[$field->fieldid][$k]->fieldvalue;
						$fieldtitle = @$this->field_values[$field->fieldid][$k]->fieldtitle;
						if ($field->type == 'radio') {
							if (isset($fieldtitle))
								$fieldtitle=JText::_($fieldtitle);
						}
						else
						{
							$fieldtitle="<img src='{$this->baseurl}images/com_adsmanager/fields/$fieldtitle' alt='$fieldtitle' />";
						} 
						if (isset($this->field_values[$field->fieldid][$k]->fieldtitle))
						{
							if (($field->required == 1)&&($k==0))
								$mosReq = "mosReq='1'";
							else
								$mosReq = "";
						
							if (($value == $fieldvalue)||($value == $fieldtitle))
								$return .= "<input type='radio' $mosReq name='$name' id='$name' mosLabel='$strtitle' value='$fieldvalue' checked='checked' />&nbsp;$fieldtitle&nbsp;\n";
							else
								$return .= "<input type='radio' $mosReq name='$name' id='$name' mosLabel='$strtitle' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
						}
						$k++;
						$return .= "</td>";
					}
					$return .= "</tr>";
				}
				$return .= "</table>";
				break;
			case 'file':
				$return .= "<input id='$name' type='file' name='$name' mosLabel='$strtitle'/>";
				if (isset($value)&&($value != ""))
				{
					$return .= "<br/><a href='{$this->baseurl}images/com_adsmanager/files/$value' target='_blank'>".JText::_('ADSMANAGER_DOWNLOAD_FILE')."</a>";
				}
				break;
				
			default:
				
				if(isset($this->plugins[$field->type]))
				{
					if (!isset($content->id))
						$content->id = 0;
					$result = $this->plugins[$field->type]->getFormDisplay($content,$field,$default );
					if ($result != "")
						$return .= $result;
					else
						return "";
				}
		}
		if ((@$field->description)&&($field->description !="")) {
			if (ADSMANAGER_SPECIAL != "abrivac")
						JHTML::_('behavior.tooltip');
			$return .= JHTML::tooltip(JText::_($field->description),JText::_($field->title));
		}
		if (function_exists("checkPaidField"))
		{
			$return .= checkPaidField($field);
		}
		return $return;
	}
	
	function showFieldSearch($field,$catid,$default)
	{
		$default = (object) $default;
		
		if (isset($default))
		{
			$value ="\$default->".$field->name;
			eval("\$value = @\"$value\";");
			$value = JText::_($value);
		}
		
		if ((strpos($field->catsid, ",$catid,") !== false)||(strpos($field->catsid, ",-1,") !== false))
		{
			switch($field->type)
			{
				case 'checkbox':
					if ($value == 1)
						echo "<input class='inputbox' type='checkbox' name='".$field->name."' value='1' checked='checked' />\n";
					else
						echo "<input class='inputbox' type='checkbox' name='".$field->name."' value='1' />\n";
					break;
				case 'multicheckbox':
					echo "<table class='cbMulti'>\n";
					$k = 0;
					for ($i=0 ; $i < $field->rows;$i++)
					{
						echo "<tr>\n";
						for ($j=0 ; $j < $field->cols;$j++)
						{
							$fieldvalue = @$this->field_values[$field->fieldid][$k]->fieldvalue;
							$fieldtitle = @$this->field_values[$field->fieldid][$k]->fieldtitle;
							if (isset($fieldtitle))
								$fieldtitle=JText::_($fieldtitle);
							echo "<td>\n";
							if (isset($this->field_values[$field->fieldid][$k])) {
								if ((strpos($value, ",".$fieldvalue.",") === false) &&
									(strpos($value, $fieldtitle."|*|") === false) &&
									(strpos($value, "|*|".$fieldtitle) === false) &&
									($value !=  $fieldtitle))
									echo "<input class='inputbox' type='checkbox' name='".$field->name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
								else
									echo "<input class='inputbox' type='checkbox' checked='checked' name='".$field->name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
							}
							echo "</td>\n";
							$k++;
						}
						echo "</tr>\n";
					}
					echo "</table>\n";
					break;

				case 'radio':
				case 'select':
					if ((ADSMANAGER_SPECIAL == "abrivac")&&($field->name == "ad_type")) {
						$value = @$default->ad_type;
						if (isset($this->field_values[$field->fieldid])) {
						foreach($this->field_values[$field->fieldid] as $v)
						{
							$ftitle = htmlspecialchars(JText::_($v->fieldtitle));
							$fieldvalue = $v->fieldvalue;
							//var_dump($fieldvalue,$value);
							if (!is_array($value))
								$value = array();
							echo "<div class='champ_filtre_checkbox'>";
							if (in_array($fieldvalue,$value))
								echo "<input class='inputbox' type='checkbox' name='".$field->name."[]' checked='checked' value='$fieldvalue' />&nbsp;$ftitle&nbsp;\n";
							else
								echo "<input class='inputbox' type='checkbox' name='".$field->name."[]' value='$fieldvalue' />&nbsp;$ftitle&nbsp;\n";
							echo "</div>";
						}
						}
							
					} else {
						echo "<select id='".$field->name."' name='".$field->name."'>\n";
						echo "<option value='' >&nbsp;</option>\n";	
						if (isset($this->field_values[$field->fieldid])) {
						foreach($this->field_values[$field->fieldid] as $v)
						{
							$ftitle = JText::_($v->fieldtitle);
							if (($value == $v->fieldvalue)||($value == $ftitle))
								echo "<option value='$v->fieldvalue' selected='selected' >$ftitle</option>\n";
							else
								echo "<option value='$v->fieldvalue' >$ftitle</option>\n";
						}
						}
					
						echo "</select>\n";
					}
					break;
				
				case 'multiselect':
				
					echo "<select name=\"".$field->name."[]\" multiple='multiple' size='$field->size'>\n";	
					if (isset($this->field_values[$field->fieldid])) {
					foreach($this->field_values[$field->fieldid] as $v)
					{
						$ftitle = JText::_($v->fieldtitle);
						if ($field->required == 1)
							$mosReq = "mosReq='1'";
							
						if ((strpos($value, ",".$v->fieldvalue.",") === false) &&
							(strpos($value, $ftitle."|*|") === false) &&
							(strpos($value, "|*|".$ftitle) === false) &&
							($value !=  $ftitle))
							echo "<option value='".str_replace("'","\'",$v->fieldvalue)."' >$ftitle</option>\n";
						else
							echo "<option value='".str_replace("'","\'",$v->fieldvalue)."' selected='selected' >$ftitle</option>\n";
					}
					}
					
					echo "</select>\n";
					break;
					
				case 'price':
					echo "<select id='".$field->name."' name='".$field->name."'>\n";
					echo "<option value='' >&nbsp;</option>\n";	
					if (isset($this->field_values[$field->fieldid])) {
					foreach($this->field_values[$field->fieldid] as $v)
					{
						$ftitle = JText::_($v->fieldtitle);
						if ($value == $v->fieldvalue)
							echo "<option value='$v->fieldvalue' selected='selected'>$ftitle</option>\n";
						else
							echo "<option value='$v->fieldvalue' >$ftitle</option>\n";
					}
					}
					
					echo "</select>\n";
					break;
					
				case 'editor':
				case 'textarea':
				case 'number':
				case 'emailaddress':
				case 'url':
				case 'text':
					if ((ADSMANAGER_SPECIAL == "abrivac")&&(($field->name == "ad_capaciteconf")||($field->name == "ad_capacitemax"))) {
						?>
						<select name="<?php echo $field->name;?>">
							<option value="" <?php if ($value=="") echo 'selected="selected"';?>></option>
							<option value="1" <?php if ($value==1) echo 'selected="selected"';?>>1 <?php echo JText::_('ADSMANAGER_PERSONNE') ?></option>
							<option value="2" <?php if ($value==2) echo 'selected="selected"';?>>2 <?php echo JText::_('ADSMANAGER_PERSONNES') ?></option>
							<option value="3" <?php if ($value==3) echo 'selected="selected"';?>>3 <?php echo JText::_('ADSMANAGER_PERSONNES') ?></option>
							<option value="4" <?php if ($value==4) echo 'selected="selected"';?>>4 <?php echo JText::_('ADSMANAGER_PERSONNES') ?></option>
							<option value="5" <?php if ($value==5) echo 'selected="selected"';?>>5 <?php echo JText::_('ADSMANAGER_PERSONNES') ?></option>
                            <option value="6" <?php if ($value==6) echo 'selected="selected"';?>>6 <?php echo JText::_('ADSMANAGER_PERSONNES') ?></option>
							<option value="7" <?php if ($value==7) echo 'selected="selected"';?>>7 <?php echo JText::_('ADSMANAGER_PERSONNES') ?></option>
							<option value="8" <?php if ($value==8) echo 'selected="selected"';?>>8 <?php echo JText::_('ADSMANAGER_PERSONNES') ?></option>
						</select>
						<?php
					} else {
						echo "<input name='".$field->name."' id='".$field->name."' value='$value' maxlength='20' class='inputbox' type='text' size='20' />";
					}
					break;
					
				case 'date':
					$options = array();
					$options['size'] = 25;
					echo JHTML::_('behavior.calendar');
					echo JHTML::_('calendar', '', "$field->name", "$field->name", JText::_('ADSMANAGER_DATE_FORMAT_LC'), $options);
					break;

				default:
					if(isset($this->plugins[$field->type]))
					{
						if (method_exists($this->plugins[$field->type],"getSearchFormDisplay")) {

							echo $this->plugins[$field->type]->getSearchFormDisplay($default,$field );
						} else {
							$obj = new StdClass();
							echo $this->plugins[$field->type]->getFormDisplay($obj,$field );
						}
					}
			}
		}
	}
	
	function Txt2Png( $text) 
	{	
		$png2display = md5($text);
		$filenameforpng = JPATH_ROOT."/images/com_adsmanager/email/". $png2display . ".png";
		$filename = $this->baseurl."images/com_adsmanager/email/". $png2display . ".png";
		if (!file_exists($filenameforpng)) # we dont need to create file twice (md5)
		{	
			# definitions
			$font = JPATH_ROOT . "/components/com_adsmanager/font/verdana.ttf";
			# create image / png
			$fontsize = 9;
			$textwerte = imagettfbbox($fontsize, 0, $font, $text);
			$textwerte[2] += 8;
			$textwerte[5] = abs($textwerte[5]);
			$textwerte[5] += 4;
			$image=imagecreate($textwerte[2], $textwerte[5]);
			$farbe_body=imagecolorallocate($image,255,255,255); 
			$farbe_b = imagecolorallocate($image,0,0,0); 
			$textwerte[5] -= 2;
			imagettftext ($image, 9, 0, 3,$textwerte[5],$farbe_b, $font, $text);
			#display image
			imagepng($image, "$filenameforpng"); 
		}
	
		$text = "<img src='$filename' border='0' alt='email' />";
		return $text;
	}
}
