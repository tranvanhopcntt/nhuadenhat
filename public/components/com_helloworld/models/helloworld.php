<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

class HelloWorldModelHelloWorld extends JModelItem
{
	
	protected $item;
	protected $State;
		
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'agents_store', 'a.agents_store',
				'provinces','p.provinces',
			);
		}

		parent::__construct($config);
	}
	protected function populateState($ordering = null, $direction = null)
	{
		
			// Initialise variables.
			$app = JFactory::getApplication('administrator');

			$input = JFactory::getApplication()->input;		
			
			$search = $input->getInt('filter_search');
			$this->setState('filter_search', preg_replace('/\s+/',' ', $search));
			
			$provinces = $input->getInt('filter_provinces');			
			$this->setState('filter_provinces', $provinces);

			$district = $input->getInt('filter_district');			
			$this->setState('filter_district', $district);

			parent::populateState('a.id', 'asc');
	}	
	/**
	 * Get the message
	 * @return string The message to be displayed to the user
	 */
	public function getItem() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('a.*, p.pre_name as name, d.dis_name as district');
		$query->from('#__agents_store as a');
		$query->join('left','#__province as p ON p.pre_id=a.id_province');
		$query->join('left','#__district as d ON d.id=a.id_district');	
		
		$province=(int)$this->getState('filter_provinces');
		if(	$province>0){
			$query->where('p.pre_id='.$province);
			$district=(string)$this->getState('filter_district');
			
			if(	$district!=='*' && (int)$district>0){
				$query->where('d.id ='.$district);
			}
		}

		$query->order(' a.id ASC');				
		$db->setQuery((string)$query);
		$this->item = $db->loadObjectList();		
		return $this->item;
	}
	
	public function getProvinces(){
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('p.pre_id as id, p.pre_name as name');
		$query->from('#__province as p');
		$query->order(' p.pre_order ASC');		
		$db->setQuery((string)$query);
		$resurl = $db->loadObjectList();		
		return $resurl;
	}
	
	public function getDistrict($id_province=1){
		 			
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('d.dis_name as name, d.id');
		$query->from('#__district as d');
		//$query->join('LEFT','#__district d');
		$query->where('d.pre_id='.$id_province);		
		$query->order(' d.id ASC');				
		$db->setQuery((string)$query);
		$resurl = $db->loadObjectList();		
		
		return $resurl;
	}
}
