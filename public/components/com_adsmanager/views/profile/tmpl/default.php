<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<script language="javascript" type="text/javascript">
function submitbutton() {
	var form = document.adminForm;
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

	// do field validation
	if (form.name.value == "") {
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_NAME');?>" );
	} else if (form.email.value == "") {
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_EMAIL');?>" );
	} else if ((form.password.value != "") && (form.password.value != form.verifyPass.value)){
		alert( "<?php echo JText::_('ADSMANAGER_REGWARN_VPASS2');?>" );
	} else if (r.exec(form.password.value)) {
		alert( "<?php printf( JText::_('ADSMANAGER_VALID_AZ09'), JText::_('ADSMANAGER_REGISTER_PASS'), 6 );?>" );
	} else {
		form.submit();
	}
}
</script>
<?php $target = TRoute::_("index.php?option=com_adsmanager&task=saveprofile"); ?>
<form action="<?php echo $target; ?>" method="post" name="adminForm">
<h1 class="componentheading">
<?php echo JText::_('ADSMANAGER_EDIT_PROFILE') ?>
</h1>
<br />
<table cellpadding="5" cellspacing="0" border="0" width="100%" id="adformtable">
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_UNAME'); ?>
	</td>
	<td>
		<?php echo htmlspecialchars($this->user->username);?>
		<input type="hidden" name="username" value="<?php echo htmlspecialchars($this->user->username);?>" />
	</td>
</tr>
<?php if(function_exists("showBalance")){
    showBalance($this->user->id);
} ?>
<tr>
	<td colspan="2">
		<?php echo JText::_('ADSMANAGER_PROFILE_PASSWORD'); ?>
	</td>
</tr>
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_PASSWORD'); ?>
	</td>
	<td>
		<input class="inputbox" type="password" name="password" autocomplete="off" value="" size="40" />
	</td>
</tr>
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_VPASS'); ?>
	</td>
	<td>
		<input class="inputbox" type="password" name="verifyPass" autocomplete="off" size="40" />
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php echo JText::_('ADSMANAGER_PROFILE_CONTACT'); ?>
	</td>
</tr>
<tr>
	<td width=85>
		<?php echo JText::_('ADSMANAGER_PROFILE_NAME'); ?>
	</td>
	<td>
		<input class="inputbox" type="text" name="name" value="<?php echo htmlspecialchars($this->user->name);?>" size="40" />
	</td>
</tr>
<tr>
	<td>
		<?php echo JText::_('ADSMANAGER_FORM_EMAIL'); ?>
	</td>
	<td>
		<input class="inputbox" type="text" name="email" value="<?php echo htmlspecialchars($this->user->email);?>" size="40" />
	</td>
</tr>
<?php
$user = $this->user;

if (isset($this->fields)) {
foreach($this->fields as $f)
{
	if (($f->name != "name")&&($f->name != "email")){
		echo "<tr id=\"tr_{$f->name}\"><td>".$this->field->showFieldLabel($f,$this->user,null)."</td>\n";
		echo "<td>".$this->field->showFieldForm($f,$this->user,null)."</td></tr>\n";
	}
}
}
?>
<?php echo $this->event->onUserAfterForm ?>
<tr>
	<td colspan="2">
		<input class="button" type="button" value="<?php echo JText::_('ADSMANAGER_FORM_SUBMIT_TEXT'); ?>" onclick="submitbutton()" />
	</td>
</tr>
</table>
<?php echo JHTML::_( 'form.token' ); ?>
</form>