//
// $(document).ready(function(){
//	$('.sub-menu').css('display','none');
//	//$('.sub-menu').hide();
//	$('.parent').hover(function(){
//			$('.sub-menu').css('display','block');
//			//$('.sub-menu').slideDown('slow');
//		}
//	
//	,function(){
//			$('.sub-menu').css('display','none');
//			//$('.sub-menu').hide();
//		});   
// });
 
 
 $(document).ready(function(){
	
	$('.sub-menu').hide();
	$('.parent').hover(function(){			
			$('.sub-menu').slideDown('fast');
		}	
	,function(){			
			$('.sub-menu').hide();
		});   
 });