<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport( 'joomla.html.html.select' );

class HelloWorldViewHelloWorld extends JView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	function display($tpl = null) 
	{
		$this->items            = $this->get('Items');
        //$this->pagination       = $this->get('Pagination');
        $this->state            = $this->get('State');
		//print_r($this->get('State'));
		$id_provinces = (int)JRequest::getInt('filter_provinces');		
		//Assign data to the view
		$this->items = $this->get('item');
		
		//print_r($this->get('State'));
		$this->optionProvinces=$this->optionProvinces();
		$this->optionDistrict=$this->optionDistrict($id_provinces);	
		
		// Display the view
		parent::display($tpl);
	}
	
	function optionProvinces(){		
		$model=$this->getModel();
		$Provinces=$model->getProvinces();
		
		$options = array();		
		if($Provinces){
			foreach($Provinces as $Province){
				//print_r($Province->id);
				$options[] = JHtml::_('select.option', $Province->id, $Province->name);
			}
		}		
		return $options;		
	}
		
	function optionDistrict($id_provinces){
		
		$model=$this->getModel();
		$Districts=$model->getDistrict($id_provinces);
		
		$options = array();
		if($Districts){
			foreach($Districts as $District){				
				$options[] = JHtml::_('select.option', $District->id, $District->name);
			}
		}
		return $options;		
	}
}
