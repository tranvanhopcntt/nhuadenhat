<?php
/**
 * @version		$Id: index.php  $
 * @package		Joomla.Site
 * @subpackage	tpl_launchtime
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

define( 'TEMPLATEPATH', dirname(__FILE__) );
require_once( TEMPLATEPATH.DS."framework.php");

$app = JFactory::getApplication();
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/themes/<?php echo $theme; ?>/style.css" />

<!--<link href='http://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css' />-->
<link href='http://fonts.googleapis.com/css?family=Squada+One' rel='stylesheet' type='text/css'>
<?php if ($showmailchimp) { ?>
<link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
<?php } ?>

	<!--[if lt IE 8]>
	<style type="text/css">
		#outer-container{display:block}
		#container{top:50%;display:block}
		#inner-container-left, #inner-container-center, #inner-container-right{top:-50%;position:relative}
	</style>
	<![endif]--> 
	
	<!--[if IE 7]>
	<style type="text/css">
		#outer-container{
		position:relative;
		overflow:hidden;
		}
	</style>
	<![endif]--> 
	
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	
<?php if ($bgimage) { ?>	
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/javascript/supersized.3.1.3.core.min.js"></script>
<?php } ?>

<?php if($showcounter) { ?>
	<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/javascript/jquery.lwtCountdown-1.0.js"></script>
	<script type="text/javascript" language="javascript">
	jQuery(document).ready(function() {
				
		jQuery('#countdown_dashboard').countDown({
					targetDate: {
						'day': 		<?php echo $config['targetDate']['day']; ?>,
						'month': 	<?php echo $config['targetDate']['month']; ?>,
						'year': 	<?php echo $config['targetDate']['year']; ?>,
						'hour': 	<?php echo $config['targetDate']['hour']; ?>,
						'min': 		<?php echo $config['targetDate']['minute']; ?>,
						'sec': 		<?php echo $config['targetDate']['second']; ?>
					}
				});
		});
	</script>
<?php } ?>

	
	
	<!--
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
	      {"parsetags": "explicit"}
	</script>
	-->
	
	
</head>

<body style="<?php if($bgcolor) { ?> background-color:#<?php echo $bgcolor; ?>;<?php } ?>">

<jdoc:include type="message" />
<div id="wrp" class="<?php echo $boxposition; ?>"> 
		<div id="inner" class="<?php echo $boxposition; ?>">
			<?php include('templates/launchtime/themes/'.$theme.'/index.php') ; ?>
          </div>
               
</div>
<div class="bx-overlay"></div>

<ul id="footer">
	<li><div style="float:left">
 <span class="squada">Launch Time</span> Template by </div><a href="http://icsc.vn" target="_blank" class="tpfooterlink"><strong>ICSC</strong></a>
	</li>
</ul>

	<?php if($supersize_enable) { ?> 

		<script type="text/javascript">
			var $ = jQuery.noConflict();
			$(function($){
				$.supersized({slides : [ { image : '<?php echo JURI::base() . $bgimage; ?>' } ]}); 
			});
		</script>
		
	<?php } else { ?>

		<style type="text/css">
			body {background:<?php echo '#' . $bgcolor; ?>;}
		</style>
	
	<?php } ?>
	
	
	<script type="text/javascript">
		$(function() {
			$('ul#footer').hover(function(){
				$(this).animate({right:'0px'},{queue:false,duration:500});
			}, function(){
				$(this).animate({right:'-240px'},{queue:false,duration:500});
			});
		});
	</script>
	
</body>
</html>