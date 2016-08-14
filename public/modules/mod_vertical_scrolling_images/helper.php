<?php
/**
 * Vertical scrolling images Module
 *
 * @package Vertical scrolling images
 * @subpackage Vertical scrolling images
 * @version   3.0 February, 2012
 * @author    Gopi http://www.gopiplus.com
 * @copyright Copyright (C) 2010 - 2012 www.gopiplus.com, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

class modVerticalScrollingImagesHelper
{
	function loadScripts(&$params)
	{
		$doc = &JFactory::getDocument();
		$doc->addScript(JURI::Root(true).'/modules/mod_vertical_scrolling_images/tmpl/mod_vertical_scrolling_images.js');
	}
	
	static function getImages(&$params, $folder)
	{
		$type = $params->get('type', 'jpg');

		$files	= array();
		$images	= array();

		$dir = JPATH_BASE.DS.$folder;

		// check if directory exists
		if (is_dir($dir))
		{
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != '.' && $file != '..' && $file != 'CVS' && $file != 'index.html') {
						$files[] = $file;
					}
				}
			}
			closedir($handle);

			$i = 0;
			foreach ($files as $img)
			{
				if (!is_dir($dir .DS. $img))
				{
					if (preg_match('/'.$type.'/', $img)) {
						$images[$i] = new stdClass;
						
						$images[$i]->name	= $img;
						$images[$i]->folder	= $folder;
						$i++;
					}
				}
			}
		}
		return $images;
	}

	static function getFolder(&$params)
	{
		$folder	= $params->get('folder');

		$LiveSite	= JURI::base();

		// if folder includes livesite info, remove
		if (JString::strpos($folder, $LiveSite) === 0) {
			$folder = str_replace($LiveSite, '', $folder);
		}
		// if folder includes absolute path, remove
		if (JString::strpos($folder, JPATH_SITE) === 0) {
			$folder= str_replace(JPATH_BASE, '', $folder);
		}
		$folder = str_replace('\\', DS, $folder);
		$folder = str_replace('/', DS, $folder);

		return $folder;
	}
}