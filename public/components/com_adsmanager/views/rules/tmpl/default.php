<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<?php 
$this->general->showGeneralLink();
echo '<h1 class="contentheading">'.JText::_('ADSMANAGER_RULES').'</h1>';
echo $this->conf->rules_text;	