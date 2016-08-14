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

	

function ivrss_scroll() {
	ivrss_obj.scrollTop = ivrss_obj.scrollTop + 1;
	ivrss_scrollPos++;
	if ((ivrss_scrollPos%ivrss_heightOfElm) == 0) {
		ivrss_numScrolls--;
		if (ivrss_numScrolls == 0) {
			ivrss_obj.scrollTop = '0';
			ivrss_content();
		} else {
			if (ivrss_scrollOn == 'true') {
				ivrss_content();
			}
		}
	} else {
		setTimeout("ivrss_scroll();", 10);
	}
}

var ivrss_Num = 0;
/*
Creates amount to show + 1 for the scrolling ability to work
scrollTop is set to top position after each creation
Otherwise the scrolling cannot happen
*/
function ivrss_content() {
	var tmp_vsrp = '';

	w_vsrp = ivrss_Num - parseInt(ivrss_numberOfElm);
	if (w_vsrp < 0) {
		w_vsrp = 0;
	} else {
		w_vsrp = w_vsrp%ivrss_array.length;
	}
	
	// Show amount of vsrru
	var elementsTmp_vsrp = parseInt(ivrss_numberOfElm) + 1;
	for (i_vsrp = 0; i_vsrp < elementsTmp_vsrp; i_vsrp++) {
		
		tmp_vsrp += ivrss_array[w_vsrp%ivrss_array.length];
		w_vsrp++;
	}

	ivrss_obj.innerHTML 	= tmp_vsrp;
	
	ivrss_Num 			= w_vsrp;
	ivrss_numScrolls 	= ivrss_array.length;
	ivrss_obj.scrollTop 	= '0';
	// start scrolling
	setTimeout("ivrss_scroll();", 2000);
}

