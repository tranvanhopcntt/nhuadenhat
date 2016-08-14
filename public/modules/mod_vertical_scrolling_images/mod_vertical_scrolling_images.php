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

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$link	= $params->get('link');
$width	= $params->get('width');
$height	= $params->get('height');
$scrollercount	= $params->get('scrollercount');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$folder	= modVerticalScrollingImagesHelper::getFolder($params);
$images	= modVerticalScrollingImagesHelper::getImages($params, $folder);

if (!count($images)) 
{
	echo JText::_('NO IMAGES ' . $folder . '<br><br>');
	return;
}

modVerticalScrollingImagesHelper::loadScripts($params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_vertical_scrolling_images', $params->get('layout', 'default'));
