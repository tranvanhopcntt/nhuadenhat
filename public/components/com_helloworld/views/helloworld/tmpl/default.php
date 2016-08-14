<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;
jimport( 'joomla.html.html' );
JHtml::_('behavior.modal');
//print_r($this->state['filter_provinces']);
?>


<div class="blog LatestAds">
    <div class="m-title">
        <h3><?php echo JText::_('MANG_LUOI')?></h3>
        <?php echo $this->item->agents_store; ?>  
    </div>
    <form action="<?php echo JRoute::_('index.php?option=com_helloworld&view=helloworld'); ?>" method="post" name="adminForm"> 
    <div class="filter-bar">
    	<div class="filter-input fl none">
        	<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('AGENTS_STORE'); ?>:</label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_USERS_SEARCH_USERS'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_RESET'); ?></button>
            
        </div>
    	<div class="filter-select fr">    	
        <select name="filter_provinces" class="inputbox" onchange="this.form.submit()">
            <option value="*"><?php echo JText::_('TINH_THANH');?></option>
            <?php echo JHtml::_('select.options', $this->optionProvinces, 'value', 'text',$this->state->filter_provinces);?>
        </select>  
         <select name="filter_district" class="inputbox" onchange="this.form.submit()">            
            <option value="*"><?php echo JText::_('QUAN_HUYEN');?></option>     
            
            <?php echo JHtml::_('select.options',$this->optionDistrict, 'value', 'text',$this->state->filter_district);?>
        </select>   		
        </div>
    </div>
    <div class="box box-daily fl">
    	<h3 class="title_network"><?php echo JText::_('HE_THONG_MANG_LUOI')?></h3>
    	<table class="zebra" width="100%">
        	<thead>
            	<tr>
            	<th><?php echo JText::_('STT');?></th>
                <th><?php echo JText::_('DAI_LY');?></th>
                <th><?php echo JText::_('DIA_CHI');?></th>
                <th><?php echo JText::_('DIEN_THOAI');?></th>
                <th>Fax</th>
                </tr>
            </thead>
            <?php if(empty($this->items)):?>
            <tfoot>
            	<tr>
                	<td colspan="5" align="center"><?php echo JText::_('CHUA_CO_THONG_TIN');?></td>
                </tr>
            </tfoot>
            <?php endif;?>
            <tbody>
            	<?php foreach($this->items as $key=>$item):?>
            	<tr>
                	<td><?php echo $key+1;?></td>
                    <td><?php echo $item->agents_store;?></td>
                    <td><?php echo $item->address.", ".$item->district.", ".$item->name.".";?></td>
                    <td><?php echo $item->telephone;?></td>
                    <td><?php echo $item->fax;?></td>
                </tr>
            	<?php endforeach;?>
            </tbody>
            
        </table>
    </div>
    </form>
</div>
