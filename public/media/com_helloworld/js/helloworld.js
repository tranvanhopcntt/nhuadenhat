/**
 * @package		Joomla.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

window.addEvent('domready', function() {
	document.formvalidator.setHandler('greeting',
		function (value) {
			regex=/^[^0-9]+$/;
			return regex.test(value);
	});
	
	$('jform_id_province').addEvent('change', function(){
		
		var id_province = document.getElementById("jform_id_province").value;
		//alert(id_province);
		
    	var url='index.php?option=com_helloworld&view=helloworld&task=helloworld.getDistrict';
		var data = '&id_province='+id_province;	
		
		var request = new Request.JSON({
		url: url,
		method:'get',
		data: data,
		onSuccess: function(data){		
					document.getElementById('jform_id_district').innerHTML=  '';		
					document.getElementById('jform_id_district').innerHTML=  data.resutl;		
		}
		
		}).send();
	});
});
